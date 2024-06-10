<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSettingsRequest;
use App\Http\Requests\UpdateUserSettingsRequest;
use App\Models\User;
use App\Models\UserSettings;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserSettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSettings  $userSettings
     * @return \Illuminate\Http\Response
     */
    public function show(UserSettings $userSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = $user->load("settings");
        return view("users.settings.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserSettingsRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserSettingsRequest $request, User $user)
    {
        $data = $this->transformUpdateRequest($request);
        $success = $user->settings->update($data);
        return back()->with(
            $success ? "success" : "error",
            $success
                ? "Settings successfully updated"
                : "Failed to update settings",
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSettings  $userSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSettings $userSettings)
    {
        //
    }

    private function transformUpdateRequest(UpdateUserSettingsRequest $request)
    {
        $validated = $request->validated();
        $validated["receive_weekly_digest"] = isset(
            $validated["receive_weekly_digest"],
        );
        $validated["receive_comment_notifications"] = isset(
            $validated["receive_comment_notifications"],
        );
        $validated["receive_new_follower_notifications"] = isset(
            $validated["receive_new_follower_notifications"],
        );
        $validated["receive_follower_notifications"] = isset(
            $validated["receive_follower_notifications"],
        );
        return $validated;
    }
}
