<?php

namespace App\Http\Livewire\Post;

use App\Http\Livewire\Forms\MetadataForm;
use App\Models\Post;
use App\Notifications\NewFollowedPost;
use App\Traits\Livewire\HasAutosave;
use App\Traits\Livewire\HasDispatch;
use App\Traits\Livewire\HasMetadata;
use App\ValueObjects\Metadata;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Editor extends Component
{
    use AuthorizesRequests, HasAutosave, HasDispatch;

    public Post $post;
    public MetadataForm $metadata_form;
    public string $body;
    public bool $ready_to_load_post = false;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null): void
    {
        $this->metadata_form = new MetadataForm();
        if ($post = Post::find($uuid)) {
            $this->authorize("update", $post);
            /** @var Post $post */
            $this->post = $post;
            $this->metadata_form->fill($post->metadata);
        } else {
            $this->authorize("create", Post::class);
            $this->post = new Post();
            $this->metadata_form->fill($this->post->metadata);
        }
        $this->body = json_encode($this->post->body);
    }

    /** @var array<string, string[]> */
    protected $rules = [
        "body" => ["json"],
        "post.title" => ["string"],
        "post.published" => ["boolean"],
        "metadata_form.audience" => ["string"],
        "metadata_form.category" => ["string"],
        "metadata_form.grades" => ["array"],
        "metadata_form.standards" => ["array"],
        "metadata_form.practices" => ["array"],
        "metadata_form.languages" => ["array"],
    ];

    public function save(): void
    {
        $this->validate();
        $this->post->user_id = auth()->user()->id;
        $this->post->metadata = $this->metadata_form->toMetadata();
        if (!$this->post->exists) {
            $this->post->body = json_decode($this->body, true);
        }
        if (!$this->post->save()) {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Post not saved!\n{$this->errorBag->all()}"),
            ]);
            return;
        }
        if ($this->post->wasRecentlyPublished()) {
            $message = __("Post published!");
            $this->post->user->notifyFollowers(
                new NewFollowedPost($this->post),
            );
        } else {
            $message = __("Post saved!");
        }
        $this->dispatchBrowserEvent("success", [
            "message" => $message,
        ]);
        $this->dispatchBrowserEventIf(
            $this->post->wasRecentlyCreated,
            "post-created",
            [
                "url" => route("posts.edit", ["uuid" => $this->post->id]),
            ],
        );
        $this->dispatchBrowserEvent("editor-saved");
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\View\Factory
     */
    public function render()
    {
        return view("livewire.post.editor")->layoutData([
            "title" => __("Post Editor"),
        ]);
    }
}
