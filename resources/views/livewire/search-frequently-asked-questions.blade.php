<div>
  <x-hero class="is-primary">
    <x-forms.field empty class="has-addons">
      <div class="control is-expanded">
        <input type="text" class="input" placeholder="Search..." wire:model.debounce.500ms="search">
      </div>
      <div class="control">
        <a href="{{ route('faq.create') }}" class="button is-dark">
          Create Question
        </a>
      </div>
    </x-forms.field>
  </x-hero>

  @empty($this->questions)
    <div class="notification is-warning is-light mt-5 mx-5">
      No questions found.
    </div>
  @else
    <table class="table is-fullwidth is-hoverable">
      <thead>
        <tr>
          <th>Question</th>
          <th>Answer</th>
          <th>Rating</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->questions as $question)
          <tr>
            <td>{{ __($question->title) }}</td>
            <td>{{ __($question->answer_excerpt) }}</td>
            @unless ($question->history->count())
              <td>Unrated</td>
            @else
              <td>{{ $question->rating . '%' }}</td>
            @endunless
            <td>
              <a class="link" href="{{ route('faq.show', compact('question')) }}">Visit</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endempty
</div>
