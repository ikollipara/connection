<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     *  @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy()
    {
        if ($this->user->delete()) {
            auth()->logout();
            return redirect()
                ->route("index", [], 303)
                ->with("success", "Account deleted successfully!");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Account deletion failed!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.delete-account");
    }
}
