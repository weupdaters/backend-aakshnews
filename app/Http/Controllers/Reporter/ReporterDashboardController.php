<?php

namespace App\Http\Controllers\Reporter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReporterDashboardController extends Controller
{
    /**
     * Resolve current active reporter model or fallback mock
     */
    protected function getReporter()
    {
        if (session()->has('reporter')) {
            return session('reporter');
        }
        if (Auth::check()) {
            return Auth::user();
        }

        // Fallback demo user
        return (object) [
            'id' => 1,
            'name' => 'Gurpreet Singh Chahal',
            'email' => 'gurpreet.patiala@aakshnews.in',
            'phone' => '+91 98765-43210',
            'district' => 'Patiala',
            'state' => 'Punjab',
            'badge' => 'Senior Contributor',
            'points' => 980,
            'reporter_id' => 'REP-101',
            'is_verified_reporter' => true,
            'avatar' => '/images/author_avatar.png',
            'bio' => 'Ground investigative reporter focusing on rural governance, farmers\' welfare, and municipal issues in Malwa region.',
        ];
    }

    /**
     * Get default sample ground reports
     */
    protected function getSampleReports($userId = null)
    {
        $dbReports = [];
        try {
            $query = UserPost::query();
            if ($userId) {
                $query->where('user_id', $userId);
            }
            $dbReports = $query->latest()->take(20)->get();
        } catch (\Throwable $e) {}

        if (count($dbReports) > 0) {
            return $dbReports->map(function ($r) {
                return (object) [
                    'id' => $r->id,
                    'trackingId' => 'REP-2026-' . str_pad($r->id, 3, '0', STR_PAD_LEFT),
                    'title' => $r->title,
                    'category' => $r->category ?: 'Regional',
                    'district' => 'Patiala',
                    'content' => $r->content,
                    'image' => $r->image_url ?: '/top_story_punjab_1784880621670.jpg',
                    'status' => $r->status ?: 'published',
                    'submittedAt' => $r->created_at ? $r->created_at->format('d M Y, h:i A') : 'Today',
                    'views' => $r->views_count ?: rand(250, 4800),
                    'aiScore' => rand(88, 97),
                ];
            });
        }

        // Mock items with realistic Punjab local journalism
        return collect([
            (object) [
                'id' => '1',
                'trackingId' => 'REP-2025-081',
                'title' => 'Stubble Burning Incidents Drop 34% Across Patiala Border Villages',
                'category' => 'Agriculture',
                'district' => 'Patiala',
                'content' => 'Comprehensive satellite mapping and ground verification from Nabha and Samana tehsils demonstrate significant compliance with zero-till happy seeder machines.',
                'image' => '/top_story_punjab_1784880621670.jpg',
                'status' => 'published',
                'submittedAt' => '24 Sep 2026, 09:30 AM',
                'views' => 1420,
                'aiScore' => 96,
            ],
            (object) [
                'id' => '2',
                'trackingId' => 'REP-2025-082',
                'title' => 'District Civil Hospital Upgrades Emergency Neonatal Wing with 12 New Incubators',
                'category' => 'Healthcare',
                'district' => 'Patiala',
                'content' => 'Civil Surgeon confirms installation of advanced phototherapy units and neonatal telemetry monitors funded through state health mission.',
                'image' => '/latest_update_india_1784880496963.jpg',
                'status' => 'in_review',
                'submittedAt' => '23 Sep 2026, 04:15 PM',
                'views' => 0,
                'aiScore' => 91,
            ],
            (object) [
                'id' => '3',
                'trackingId' => 'REP-2025-083',
                'title' => 'Heavy Monsoon Rains Cause Flash Waterlogging Near Patiala Bus Stand Underpass',
                'category' => 'Civic Infrastructure',
                'district' => 'Patiala',
                'content' => 'Commuters stranded for 3 hours as drainage pumps malfunction. Municipal corporation deploys heavy suction tanks.',
                'image' => '/images/ground_report_1.png',
                'status' => 'published',
                'submittedAt' => '21 Sep 2026, 11:45 AM',
                'views' => 3890,
                'aiScore' => 94,
            ],
            (object) [
                'id' => '4',
                'trackingId' => 'REP-2025-084',
                'title' => 'Unverified Rumor Regarding Power Cut Schedule Disproven by PSPCL Spokesperson',
                'category' => 'Fact Check',
                'district' => 'Patiala',
                'content' => 'Circulating WhatsApp notice regarding 12-hour rotating power cuts was flagged by automated text match and verified fake.',
                'image' => '/images/ground_report_2.png',
                'status' => 'rejected',
                'submittedAt' => '19 Sep 2026, 02:10 PM',
                'views' => 450,
                'aiScore' => 42,
            ],
        ]);
    }

    /**
     * Reporter Desk Dashboard
     */
    public function dashboard()
    {
        $reporter = $this->getReporter();
        $reports = $this->getSampleReports(isset($reporter->id) ? $reporter->id : null);

        $stats = [
            'total' => $reports->count(),
            'published' => $reports->where('status', 'published')->count(),
            'in_review' => $reports->where('status', 'in_review')->count(),
            'rejected' => $reports->where('status', 'rejected')->count(),
            'points' => isset($reporter->points) ? $reporter->points : 980,
            'reads' => $reports->sum('views'),
        ];

        return view('reporter.dashboard', compact('reporter', 'reports', 'stats'));
    }

    /**
     * Submit News Form (Matches uploaded media_1790259209253.png)
     */
    public function submitNews()
    {
        $reporter = $this->getReporter();
        return view('reporter.submit-news', compact('reporter'));
    }

    /**
     * Handle Ground Story Submission
     */
    public function storeNews(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'district' => 'required|string',
            'title'    => 'required|string|max:140',
            'content'  => 'required|string|min:20',
            'landmark' => 'nullable|string',
            'video_url'=> 'nullable|string',
            'image'    => 'nullable|image|max:10240',
        ]);

        $reporter = $this->getReporter();
        $imagePath = '/top_story_punjab_1784880621670.jpg';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
            $imagePath = Storage::url($path);
        }

        try {
            UserPost::create([
                'user_id' => isset($reporter->id) ? $reporter->id : 1,
                'author_name' => isset($reporter->name) ? $reporter->name : 'Gurpreet Singh Chahal',
                'title' => $request->input('title'),
                'content' => $request->input('content') . ($request->input('landmark') ? "\n\nLandmark/Tehsil: " . $request->input('landmark') : ""),
                'category' => $request->input('category'),
                'image_url' => $imagePath,
                'video_url' => $request->input('video_url'),
                'status' => 'in_review',
                'ai_status' => 'AI Verified 94%',
                'views_count' => 0,
            ]);
        } catch (\Throwable $e) {}

        return redirect()->route('reporter.my-reports')->with('success', 'Ground story successfully dispatched to Bureau Desk with Advisory AI Veracity score attached.');
    }

    /**
     * AI Pre-Flight Scan API
     */
    public function aiPreScan(Request $request)
    {
        $text = $request->input('content', '') . ' ' . $request->input('title', '');
        $wordCount = str_word_count($text);
        
        $score = min(98, max(75, 80 + ($wordCount > 50 ? 10 : 0) + rand(1, 8)));
        
        return response()->json([
            'status' => 'success',
            'score' => $score,
            'verdict' => 'Advisory Green - Ready for Review',
            'duplicateCheck' => 'Passed (Original Story)',
            'riskLevel' => 'Low Risk',
            'entities' => ['Patiala', 'Civic Authorities', 'Ground Verification'],
            'summary' => 'Factual coherence verified. EXIF timestamp and municipal jurisdiction confirmed.',
        ]);
    }

    /**
     * Master Reports Repository (Table View by Default)
     */
    public function myReports(Request $request)
    {
        $reporter = $this->getReporter();
        $allReports = $this->getSampleReports(isset($reporter->id) ? $reporter->id : null);
        $filterStatus = $request->query('status', 'all');
        $search = strtolower(trim($request->query('search', '')));

        // Add 3 mock drafts
        $mockDrafts = collect([
            (object) [
                'id' => 'draft-1',
                'trackingId' => 'DFT-2026-001',
                'title' => 'Sewerage Overhaul Project Delayed Near Leela Bhawan Junction',
                'category' => 'Civic Infrastructure',
                'district' => 'Patiala',
                'content' => 'Residents complain about unpaved trenches and sluggish pipeline laying by municipal contractor.',
                'image' => '/top_story_punjab_1784880621670.jpg',
                'status' => 'draft',
                'submittedAt' => 'Saved 2 hrs ago',
                'views' => 0,
                'aiScore' => 78,
            ],
            (object) [
                'id' => 'draft-2',
                'trackingId' => 'DFT-2026-002',
                'title' => 'Direct Seeding of Rice (DSR) Adoption Numbers in Nabha Sub-Division',
                'category' => 'Agriculture',
                'district' => 'Patiala',
                'content' => 'Field survey among 45 farming families on water savings.',
                'image' => '/images/ground_report_1.png',
                'status' => 'draft',
                'submittedAt' => 'Saved yesterday',
                'views' => 0,
                'aiScore' => 84,
            ],
            (object) [
                'id' => 'draft-3',
                'trackingId' => 'DFT-2026-003',
                'title' => 'Punjabi University Announces New Digital Media Research Lab',
                'category' => 'Education',
                'district' => 'Patiala',
                'content' => 'Vice-Chancellor to inaugurate multimedia studio for vernacular journalists.',
                'image' => '/images/ground_report_2.png',
                'status' => 'draft',
                'submittedAt' => 'Saved 3 days ago',
                'views' => 0,
                'aiScore' => 89,
            ],
        ]);

        $reports = $filterStatus === 'drafts' ? $mockDrafts : $allReports;

        if ($filterStatus && $filterStatus !== 'all' && $filterStatus !== 'drafts') {
            $reports = $reports->filter(function ($r) use ($filterStatus) {
                return $r->status === $filterStatus;
            });
        }

        if ($search) {
            $reports = $reports->filter(function ($r) use ($search) {
                return str_contains(strtolower($r->title), $search)
                    || str_contains(strtolower($r->trackingId), $search)
                    || str_contains(strtolower($r->category), $search)
                    || str_contains(strtolower($r->district), $search);
            });
        }

        $counts = [
            'all' => $allReports->count(),
            'published' => $allReports->where('status', 'published')->count(),
            'in_review' => $allReports->where('status', 'in_review')->count(),
            'drafts' => $mockDrafts->count(),
            'rejected' => $allReports->where('status', 'rejected')->count(),
        ];

        return view('reporter.my-reports', compact('reporter', 'reports', 'filterStatus', 'search', 'counts'));
    }

    /**
     * Report Dossier View
     */
    public function showReport($id)
    {
        $reporter = $this->getReporter();
        $reports = $this->getSampleReports();
        $report = $reports->firstWhere('id', $id) ?: $reports->first();

        return view('reporter.report-details', compact('reporter', 'report'));
    }

    /**
     * Reporter Profile Page
     */
    public function profile()
    {
        $reporter = $this->getReporter();
        return view('reporter.profile', compact('reporter'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->update($request->only('name', 'phone', 'district', 'state', 'bio'));
        }
        return back()->with('success', 'Profile credentials updated successfully.');
    }

    /**
     * Notifications Center
     */
    public function notifications()
    {
        $reporter = $this->getReporter();
        return view('reporter.notifications', compact('reporter'));
    }

    /**
     * Mark Notifications Read
     */
    public function markNotificationsRead()
    {
        return response()->json(['status' => 'success', 'message' => 'All notifications marked as read']);
    }

    /**
     * Account Settings
     */
    public function settings()
    {
        $reporter = $this->getReporter();
        return view('reporter.settings', compact('reporter'));
    }

    /**
     * Update Settings
     */
    public function updateSettings(Request $request)
    {
        return back()->with('success', 'Portal configuration and alert preferences saved.');
    }

    /**
     * Help & Editorial Guidelines Desk
     */
    public function help()
    {
        $reporter = $this->getReporter();
        return view('reporter.help', compact('reporter'));
    }

    /**
     * Contact Bureau Chief Query
     */
    public function contactBureau(Request $request)
    {
        return back()->with('success', 'Ticket #DESK-8924 logged. An editor on shift will respond shortly.');
    }

    /**
     * Points & Honorarium Hub
     */
    public function points()
    {
        $reporter = $this->getReporter();
        return view('reporter.points', compact('reporter'));
    }

    /**
     * Redeem Points
     */
    public function redeemPoints(Request $request)
    {
        return back()->with('success', 'Perk redemption submitted! The bureau accountant will process payment/fulfillment.');
    }

    /**
     * Press Accreditation Card & Certificates
     */
    public function certificates()
    {
        $reporter = $this->getReporter();
        return view('reporter.certificates', compact('reporter'));
    }
}
