<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\ContentCollection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class UserContentCollectionStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, ContentCollection $collection): RedirectResponse
    {
        $status = Status::from($request->validate([
            'status' => 'required|enum:'.Status::class,
        ])['status']);

        if ($status->equals(Status::draft())) {
            return session_back()->with('error', 'Draft status is not allowed.');
        }

        $successful = false;
        if ($status->equals(Status::archived())) {
            $successful = $collection->delete();
        } elseif ($status->equals(Status::published())) {
            $successful = $collection->restore();
        }

        return session_back()->with($successful ? 'success' : 'error', $successful ? 'Collection status updated.' : 'Collection status update failed.');
    }
}
