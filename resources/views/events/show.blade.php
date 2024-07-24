
<x-layout no-livewire>
    <x-hero class="is-primary">
        <h1 class="title">Upcoming events</h1>
        <form x-data action="{{ url()->current() }}" method="get">
        <input type="hidden" name="status">
        <x-forms.input name="q" placeholder="Filter by Title..." value="{{ request('q') }}" x-on:change.debounce.300ms="$root.submit()" without-label />
        </form>
    </x-hero>
    <x-container is-fluid class="mt-5">
        <x-table :items="$events" row-component="users.events.row"
            headers="Title, Event Date, Actions" />
    </x-container>
    <div class="sidenav" style="width: 130px;z-index: 1;top: 20px;left: 10px;background: #eee;overflow-x: hidden;padding: 8px 0; margin-left: 20px; margin-top: 20px">
        <button>
            <a href="{{route('users.events.create', 'me')}}" style="margin-left: 10px">Add an Event</a>
        </button>
    </div>
</x-layout>