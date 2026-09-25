<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Auto-ensure status column exists in users table.
     */
    protected function ensureStatusColumnExists(): bool
    {
        if (!Schema::hasColumn('users', 'status')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    if (!Schema::hasColumn('users', 'status')) {
                        $table->string('status')->default('active')->after('email');
                    }
                });
            } catch (\Throwable $e) {
                // If permission denied or locked, gracefully proceed
            }
        }
        return Schema::hasColumn('users', 'status');
    }

    /**
     * Display a listing of users and roles.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $hasStatus = $this->ensureStatusColumnExists();

        $query = User::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($role = $request->input('role')) {
            if ($role !== 'all') {
                $query->where('role', $role);
            }
        }

        // Status filter (safe check)
        if ($hasStatus && ($status = $request->input('status'))) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        // Metrics counters
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $reporterCount = User::where('role', 'reporter')->count();
        $editorCount = User::where('role', 'editor')->count();
        $readerCount = User::whereIn('role', ['user', 'reader'])->orWhereNull('role')->count();
        $activeCount = $hasStatus ? User::where('status', 'active')->count() : $totalUsers;

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminCount',
            'reporterCount',
            'editorCount',
            'readerCount',
            'activeCount'
        ));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $this->ensureStatusColumnExists();
        $hasStatus = Schema::hasColumn('users', 'status');

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|in:admin,editor,reporter,user',
            'phone'    => 'nullable|string|max:50',
            'district' => 'nullable|string|max:100',
            'bio'      => 'nullable|string|max:1000',
        ];

        if ($hasStatus) {
            $rules['status'] = 'required|string|in:active,suspended';
        }

        $request->validate($rules);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        if ($hasStatus) {
            $user->status = $request->input('status', 'active');
        }
        $user->phone = $request->phone;
        $user->district = $request->district;
        $user->bio = $request->bio;
        
        if ($request->role === 'reporter') {
            $user->badge = 'Field Reporter';
            $user->is_verified_reporter = 1;
            $user->reporter_id = 'REP-' . strtoupper(substr(uniqid(), -6));
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', "User '{$user->name}' created successfully with role '{$user->role}'.");
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $user = User::findOrFail($id);

        $this->ensureStatusColumnExists();
        $hasStatus = Schema::hasColumn('users', 'status');

        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role'     => 'required|string|in:admin,editor,reporter,user',
            'phone'    => 'nullable|string|max:50',
            'district' => 'nullable|string|max:100',
            'bio'      => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6',
        ];

        if ($hasStatus) {
            $rules['status'] = 'required|string|in:active,suspended';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($hasStatus && $request->filled('status')) {
            $user->status = $request->status;
        }
        $user->phone = $request->phone;
        $user->district = $request->district;
        $user->bio = $request->bio;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->role === 'reporter' && empty($user->reporter_id)) {
            $user->badge = 'Field Reporter';
            $user->is_verified_reporter = 1;
            $user->reporter_id = 'REP-' . strtoupper(substr(uniqid(), -6));
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Toggle active/suspended status.
     */
    public function toggleStatus($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $user = User::findOrFail($id);
        
        // Prevent suspending self
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own account status.');
        }

        $this->ensureStatusColumnExists();

        if (Schema::hasColumn('users', 'status')) {
            $user->status = ($user->status ?? 'active') === 'active' ? 'suspended' : 'active';
            $user->save();
            return redirect()->back()->with('success', "User '{$user->name}' status changed to '{$user->status}'.");
        }

        return redirect()->back()->with('info', "User status toggle will take effect once the database is updated.");
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in first.');
        }

        $user = User::findOrFail($id);

        // Prevent self deletion
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User '{$name}' has been permanently deleted.");
    }
}
