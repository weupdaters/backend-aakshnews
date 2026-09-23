<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ContactRequest;
use App\Http\Requests\Api\v1\NewsletterRequest;
use App\Http\Requests\Api\v1\VotePollRequest;
use App\Http\Resources\Api\v1\PollResource;
use App\Models\ContactMessage;
use App\Models\Poll;
use App\Models\PollVote;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngagementApiController extends Controller
{
    use ApiResponse;

    /**
     * POST /api/v1/newsletter
     */
    public function newsletter(NewsletterRequest $request)
    {
        $email = $request->input('email');
        \App\Models\Subscriber::firstOrCreate(
            ['email' => $email],
            ['status' => 'active']
        );

        return $this->successResponse([
            'subscribed' => true,
            'email'      => $email,
        ], 'Subscribed to newsletter successfully!');
    }

    /**
     * POST /api/v1/contact
     */
    public function contact(ContactRequest $request)
    {
        $contact = ContactMessage::create([
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);

        return $this->successResponse([
            'id'      => $contact->id,
            'status'  => 'received',
        ], 'Contact message sent successfully. We will get back to you soon!');
    }

    /**
     * GET /api/v1/polls
     */
    public function polls()
    {
        $polls = Poll::where('is_active', true)->latest()->get();

        if ($polls->isEmpty()) {
            // Seed a sample poll if none exists
            $polls = collect([
                Poll::create([
                    'question'  => 'Will Team India win the upcoming World Championship?',
                    'options'   => ['Yes, absolutely!', 'No, competition is tough', 'Can\'t say right now'],
                    'votes'     => [0 => 120, 1 => 45, 2 => 15],
                    'is_active' => true,
                ])
            ]);
        }

        return $this->successResponse(PollResource::collection($polls), 'Polls fetched successfully.');
    }

    /**
     * POST /api/v1/polls/{id}/vote
     */
    public function votePoll(VotePollRequest $request, $id)
    {
        $poll = Poll::find($id);

        if (!$poll || !$poll->is_active) {
            return $this->errorResponse('Active poll not found.', [], 404);
        }

        $optionIndex = (int) $request->input('option_index');
        $options = $poll->options ?? [];

        if (!isset($options[$optionIndex])) {
            return $this->errorResponse('Invalid poll option selected.', [], 422);
        }

        $userId = Auth::id();
        $ip = $request->ip();

        $existingVote = PollVote::where('poll_id', $id)
            ->where(function ($q) use ($userId, $ip) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('ip_address', $ip);
                }
            })->first();

        if ($existingVote) {
            return $this->errorResponse('You have already voted in this poll.', [], 400);
        }

        PollVote::create([
            'poll_id'      => $id,
            'user_id'      => $userId,
            'ip_address'   => $ip,
            'option_index' => $optionIndex,
        ]);

        $currentVotes = $poll->votes ?? [];
        $currentVotes[$optionIndex] = ($currentVotes[$optionIndex] ?? 0) + 1;
        $poll->update(['votes' => $currentVotes]);

        return $this->successResponse(new PollResource($poll->fresh()), 'Vote submitted successfully.');
    }
}
