<?php

namespace App\Http\Livewire\Collection;

use App\Http\Livewire\Forms\MetadataForm;
use Livewire\Component;
use App\Models\PostCollection;
use App\Notifications\NewFollowedCollection;
use App\Traits\Livewire\HasAutosave;
use App\Traits\Livewire\HasDispatch;
use App\Traits\Livewire\HasMetadata;
use App\ValueObjects\Metadata;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Editor extends Component
{
    use AuthorizesRequests, HasMetadata, HasDispatch, HasAutosave;

    public string $body;
    public MetadataForm $metadata_form;
    public PostCollection $post_collection;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null): void
    {
        $this->metadata_form = new MetadataForm();
        if ($post_collection = PostCollection::find($uuid)) {
            $this->authorize("update", $post_collection);
            $this->post_collection = $post_collection;
            $this->metadata_form->fill($post_collection->metadata);
        } else {
            $this->authorize("create", PostCollection::class);
            $this->post_collection = new PostCollection();
            $this->metadata_form->fill($this->post_collection->metadata);
        }
        $this->body = json_encode($this->post_collection->body);
    }

    /** @var array<string, string[]> */
    protected $rules = [
        "body" => ["json"],
        "post_collection.title" => ["string"],
        "post_collection.published" => ["boolean"],
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
        $this->post_collection->user_id = auth()->user()->id;
        $this->post_collection->metadata = $this->metadata_form->toMetadata();
        if (!$this->post_collection->exists) {
            $this->post_collection->body = json_decode($this->body, true);
        }
        if (!$this->post_collection->save()) {
            $this->dispatchBrowserEvent("error", [
                "message" => __(
                    "Collection not saved!\n{$this->errorBag->all()}",
                ),
            ]);
            return;
        }
        if ($this->post_collection->wasRecentlyPublished()) {
            $message = __("Collection published!");
            $this->post_collection->user->notifyFollowers(
                new NewFollowedCollection($this->post_collection),
            );
        } elseif ($this->post_collection->wasRecentlyCreated) {
            $message = __("Collection created!");
            $this->dispatchBrowserEvent("collection-created", [
                "url" => route("collections.edit", [
                    "uuid" => $this->post_collection->id,
                ]),
            ]);
        } else {
            $message = __("Collection saved!");
        }
        $this->dispatchBrowserEvent("editor-saved");
        $this->dispatchBrowserEvent("success", [
            "message" => $message,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.collection.editor")->layoutData([
            "title" => __("Collection Editor"),
        ]);
    }
}
