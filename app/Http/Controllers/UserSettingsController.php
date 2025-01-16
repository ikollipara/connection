<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSettingsRequest;
use App\Http\Requests\UpdateUserSettingsRequest;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class UserSettingsController extends Controller
{
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $user = $user->load('settings');

        return view('users.settings.edit', compact('user'));
    }

    public function update(UpdateUserSettingsRequest $request, User $user): RedirectResponse
    {
        $data = $this->transformUpdateRequest($request);
        $success = $user->settings->update($data);

        return to_route('users.settings.edit', $user, 303)->with(
            $success ? 'success' : 'error',
            $success
                ? 'Settings successfully updated'
                : 'Failed to update settings',
        );
    }

    private function transformUpdateRequest(UpdateUserSettingsRequest $request)
    {
        $validated = $request->validated();
        $validated['receive_weekly_digest'] = isset(
            $validated['receive_weekly_digest'],
        );
        $validated['receive_comment_notifications'] = isset(
            $validated['receive_comment_notifications'],
        );
        $validated['receive_new_follower_notifications'] = isset(
            $validated['receive_new_follower_notifications'],
        );
        $validated['receive_follower_notifications'] = isset(
            $validated['receive_follower_notifications'],
        );

        return $validated;
    }
}
