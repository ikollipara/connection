<?php

declare(strict_types=1);

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

        $successful = false;
        if ($status->equals(Status::archived())) $successful = $post->delete();
        elseif ($status->equals(Status::published())) $successful = $post->restore();


        return session_back()->with($successful ? 'success' : 'error', $successful ? 'Post status updated.' : 'Post status update failed.');
    }
}
