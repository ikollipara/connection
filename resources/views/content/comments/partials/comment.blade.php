{{--
file: resources/views/content/comments/partials/comment.blade.php
author: Ian Kollipara
date: 2024-09-22
description: The partial view for a comment
 --}}

@php
  $avatar = $comment->user?->avatar ?? 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
  $full_name = $comment->user?->full_name ?? 'Deleted';
@endphp

<article @class([
    'p-6 text-base bg-white rounded-lg dark:bg-gray-900',
    'border-t border-gray-200 dark:border-gray-700' => !$comment->isReply(),
    'ml-6 lg:ml-12' => $comment->isReply(),
])>
  <footer class="flex justify-between items-center mb-2">
    <div class="flex items-center">
      <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"><img
             class="mr-2 w-6 h-6 rounded-full"
             src="{{ $avatar }}"
             alt="{{ $full_name }}">{{ $full_name }}</p>
      <p class="text-sm text-gray-600 dark:text-gray-400"><time
              title="{{ $comment->created_at->toFormattedDateString() }}"
              pubdate
              datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->toFormattedDateString() }}</time>
      </p>
    </div>
    {{-- @if (auth()->user()->is($comment->user))
      <button class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
              id="dropdownComment1Button"
              data-dropdown-toggle="dropdownComment1"
              type="button">
        <svg class="w-4 h-4"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             fill="currentColor"
             viewBox="0 0 16 3">
          <path
                d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
        </svg>
        <span class="sr-only">Comment settings</span>
      </button>
      <!-- Dropdown menu -->
      <div class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
           id="dropdownComment1">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownMenuIconHorizontalButton">
          <li>
            <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
               href="#">Edit</a>
          </li>
          <li>
            <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
               href="#">Remove</a>
          </li>
          <li>
            <a class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
               href="#">Report</a>
          </li>
        </ul>
      </div>
    @endif --}}
  </footer>
  <p class="text-gray-500 dark:text-gray-400">
    {{ $comment->body }}
  </p>
  <div class="flex items-center mt-4 space-x-4 gap-x-4">
    <button class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium"
            data-modal-show="reply-modal"
            data-modal-target="reply-modal"
            type="button">
      <x-lucide-message-square-reply class="mr-1.5 w-3.5 h-3.5" />
      Reply
    </button>
    <x-form class="ml-4"
            x-data
            x-on:submit.prevent="
            fetch($el.action, {
                method: $el.method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $refs.csrf.value
                },
                body: JSON.stringify({
                    model_type: $refs.model_type.value,
                    model_id: $refs.model_id.value,
                }),
            }).then(response => {
                if (response.ok) {
                    response.json().then(data => {
                        $refs.like_button.textContent = data.likes === 1 ? (data.likes + ' Like') : (data.likes + ' Likes');
                    });
                } else {
                    response.json().then(data => {
                        alert(data.message);
                    });
                }
            })
    "
            action="{{ route('api.like') }}"
            method="post">
      <input name="model_type"
             type="hidden"
             value="{{ $comment::class }}"
             x-ref="model_type">
      <input name="model_id"
             type="hidden"
             value="{{ $comment->id }}"
             x-ref="model_id">
      <button class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium"
              type="submit"
              x-ref="like_button">{{ $comment->likes() }} {{ Str::plural('Like', $comment->likes()) }}</button>
    </x-form>
  </div>
</article>
@foreach ($comment->children as $reply)
  @include('content.comments.partials.comment', ['comment' => $reply, 'content' => $content])
@endforeach
@push('modals')
  <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
       id="reply-modal"
       aria-hidden="true"
       tabindex="-1">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Reply
          </h3>
          <button class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                  data-modal-hide="reply-modal"
                  type="button">
            <svg class="w-3 h-3"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 14 14">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          @include('content.comments.partials.comment-form', [
              'parent_id' => $comment->id,
              'content' => $content,
              'action' => $action,
          ])
        </div>
      </div>
    </div>
  </div>
  </div>
@endpush
