<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

final class UserPostStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, Post $post)
    {
        $status = Status::from($request->validate([
            'status' => 'required|enum:' . Status::class,
        ])['status']);

        if ($status->equals(Status::draft())) {
            return session_back()->with('error', 'Draft status is not allowed.');
        }

        $successful = match ($status->value) {
            Status::archived()->value => $post->delete(),
            Status::published()->value => $post->restore(),
            default => true,
        };

        return session_back()->with($successful ? 'success' : 'error', $successful ? 'Post status updated.' : 'Post status update failed.');
    }
}
