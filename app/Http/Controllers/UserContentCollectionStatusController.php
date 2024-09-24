<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\ContentCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserContentCollectionStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, ContentCollection $collection)
    {
        $status = Status::from($request->validate([
            'status' => 'required|enum:'.Status::class,
        ])['status']);

        if ($status->equals(Status::draft())) {
            return session_back()->with('error', 'Draft status is not allowed.');
        }

        $successful = match ($status->value) {
            Status::archived()->value => $collection->delete(),
            Status::published()->value => $collection->restore(),
        };

        return session_back()->with($successful ? 'success' : 'error', $successful ? 'Collection status updated.' : 'Collection status update failed.');
    }
}
