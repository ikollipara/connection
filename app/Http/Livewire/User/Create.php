<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Traits\Livewire\HasDispatch;
use Livewire\Component;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, HasDispatch;

    public User $user;

    /** @var UploadedFile|null */
    public $avatar = null;

    public string $bio = '{"blocks": []}';

    /** @var string[]|array<string, array<string>> */
    protected $rules = [
        "user.first_name" => "required|string",
        "user.last_name" => "required|string",
        "user.consented" => "boolean|nullable",
        "user.email" => "required|email|unique:users,email",
        "avatar" => ["image", "nullable"],
        "bio" => ["json"],
        "user.grades" => ["array", "required"],
        "user.subject" => ["required"],
        "user.school" => ["required_unless:user.is_preservice,true"],
        "user.years_of_experience" => [
            "integer",
            "min:0",
            "required_unless:user.is_preservice,true",
        ],
        "user.is_preservice" => ["required", "boolean"],
    ];

    public function mount(): void
    {
        $this->user = new User();
        $this->user->consented = true;
    }

    /**
     * @param mixed $propertyName
     * @param mixed $value
     */
    public function updated($propertyName, $value): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedBio(): void
    {
        $this->user->bio = json_decode($this->bio, true);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchBrowserEvent("error", [
                "message" => __(
                    "There was an error signing up. " .
                        implode(", ", $e->validator->errors()->all()),
                ),
            ]);
        }
        $this->user->fill(["password" => ""]);
        $this->dispatchBrowserEventIf(!$this->user->save(), "error", [
            "message" => __(
                "There was an error signing up." .
                    implode(", ", $this->errorBag->all()),
            ),
        ]);
        if ($this->avatar) {
            $this->user->update([
                "avatar" => $this->avatar->store("avatars", "public"),
            ]);
        }
        auth()->login($this->user);
        $this->dispatchBrowserEvent("success", [
            "message" => __("You have successfully signed up!"),
        ]);
        return redirect()->route("home");
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.user.create")->layoutData([
            "title" => "ConneCTION " . __("Sign Up"),
        ]);
    }
}
