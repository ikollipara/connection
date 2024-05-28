<?php

namespace App\Http\Livewire\User;

use App\Mail\Login as MailLogin;
use App\Models\User;
use App\Traits\Livewire\HasDispatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class Login extends Component
{
    use HasDispatch;
    public string $email = "";
    public string $password = "";
    public bool $remember_me = false;

    /** @var string[] */
    protected $rules = [
        "email" => "required|email|exists:users,email",
    ];

    /**
     * @return void|\Illuminate\Http\RedirectResponse
     */
    public function mount()
    {
        if (auth()->check()) {
            return redirect()->route("home");
        }
    }

    /**
     * @return void|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $this->validate();

        $this->email = strtolower($this->email);
        Mail::to($this->email)->send(
            new MailLogin(User::where("email", $this->email)->first()),
        );

        $this->dispatchBrowserEvent("success", [
            "message" => __("Please check your inbox to login."),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.user.login")->layoutData([
            "title" => "ConneCTION " . __("Login"),
        ]);
    }
}
