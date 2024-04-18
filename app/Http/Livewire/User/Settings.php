<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public string $body;
    /** @var UploadedFile|null */
    public $avatar = null;
    public User $user;
    public bool $above_19 = false;
    public string $full_name = "";

    /** @return array<string, string[]|string> */
    protected function rules()
    {
        return [
            "user.first_name" => "required|string",
            "user.last_name" => "required|string",
            "above_19" => "boolean",
            "full_name" => "string|required_if:above_19,true",
            "user.consented" => "boolean",
            "user.email" => [
                "required",
                "email",
                Rule::unique("users", "email")->ignore($this->user->id),
            ],
            "user.grades" => "array|required",
            "body" => ["json"],
            "user.school" => "string|required",
            "user.subject" => "string|required",
            "user.no_comment_notifications" => "boolean",
        ];
    }

    public function mount(): void
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $this->fill([
            "user" => $user,
            "body" => json_encode($user->bio),
        ]);
    }

    public function updatedBody(string $value): void
    {
        // @phpstan-ignore-next-line
        $this->user->bio = json_decode($value, true);
    }

    public function deleteAvatar(): void
    {
        $this->authorize("update", $this->user);
        Storage::delete($this->user->avatar);
        $this->user->avatar = "";
        $this->user->save();
    }

    public function save(): void
    {
        abort_if(auth()->id() !== $this->user->id, 403);
        $this->validate();

        if ($this->avatar) {
            if ($avatar = $this->avatar->store("avatars", "public")) {
                Storage::delete($this->user->avatar);
                $this->user->avatar = $avatar;
            }
        }

        if ($this->above_19 and $this->full_name == $this->user->full_name()) {
            $this->user->consented = true;
        }

        if ($this->user->save()) {
            $this->user->refresh();
            if ($this->avatar) {
                $this->dispatchBrowserEvent("avatar-updated", [
                    "url" => $this->user->avatar(),
                ]);
            }
            $this->dispatchBrowserEvent("success", [
                "message" => __("Updated Settings Successfully!"),
            ]);
            $this->dispatchBrowserEvent("editor-saved");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to update settings!"),
            ]);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view("livewire.user.settings")->layoutData([
            "title" => "ConneCTION " . __("My Settings"),
        ]);
    }
}
