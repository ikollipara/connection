<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContentCollection;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class UserContentCollectionEntryController extends Controller
{
    public function destroy(User $user, ContentCollection $collection, Entry $entry): RedirectResponse
    {
        $entry->delete();

        return session_back(status: Response::HTTP_SEE_OTHER)->with('success', 'Entry deleted successfully.');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
        ];
    }
}
