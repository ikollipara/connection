{{--
file: resources/views/posts/partials/action-bar.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The action bar for a post
 --}}

<ul class="flex flex-wrap items-center justify-start text-gray-900 dark:text-white">
  <li>
    <x-form x-data
            x-on:submit.prevent="
            const previousLikes = {{ $post->likes() }};
            $refs.like_button.textContent = (previousLikes + 1) === 1 ? ((previousLikes + 1) + ' Like') : ((previousLikes + 1) + ' Likes');
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
                        $refs.like_button.textContent = previousLikes === 1 ? (previousLikes + ' Like') : (previousLikes + ' Likes');
                    });
                }
            })
            "
            action="{{ route('api.like') }}"
            method="post">
      <input name="model_type"
             type="hidden"
             value="{{ $post::class }}"
             x-ref="model_type">
      <input name="model_id"
             type="hidden"
             value="{{ $post->id }}"
             x-ref="model_id">
      <button class="me-4 hover:underline md:me-6"
              type="submit"
              x-ref="like_button">{{ $post->likes() }} {{ Str::plural('Like', $post->likes()) }}</button>
    </x-form>
  </li>
  <li>
    <p class="me-4  md:me-6 ">{{ $post->views() }} Views</p>
  </li>
  @auth
    <li>
      <button class="me-4 hover:underline md:me-6"
              data-modal-show="add-to-collection-modal"
              data-modal-target="add-to-collection-modal"
              type="button">Add to Collection</button>
    </li>
  @endauth
  <li>
    <a class="me-4 hover:underline md:me-6"
       href="{{ route('posts.comments.index', $post) }}">See Comments</a>
  </li>
  <li>
    <a class="me-4 hover:underline md:me-6"
       href="{{ route('users.profile.show', $post->user) }}">View Author</a>
  </li>
</ul>
@push('modals')
  <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
       id="add-to-collection-modal"
       data-modal-backdrop="static"
       aria-hidden="true"
       tabindex="-1">
    <div class="relative p-4 w-full max-w-2xl max-h-full"
         x-data="{ collections: [], postId: {{ Js::from($post->id) }} }"
         x-init="fetch('{{ route('api.users.collections.index', auth()->user()) }}?content_id=' + postId)
             .then(response => response.json())
             .then(data => collections = data.collections.map(el => ({ ...el, selected: Boolean(el.hasEntry) })))">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Add to Collection
          </h3>
          <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                  data-modal-hide="add-to-collection-modal"
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
        <div class="p-4 md:p-5 space-y-4">

          <ul class="space-y-4 text-left text-gray-900 dark:text-gray-900">
            <template x-for="collection in collections">
              <li class="flex items-center space-x-3 rtl:space-x-reverse"
                  x-on:click="collection.selected = !collection.selected">
                <template x-if="collection.selected">
                  <x-lucide-circle-check class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
                </template>
                <template x-if="!collection.selected">
                  <x-lucide-circle class="flex-shrink-0 w-5 h-5 text-red-500 dark:text-red-400"
                                   x-show="!collection.selected" />
                </template>
                <span x-text="collection.title"></span>
              </li>
            </template>
          </ul>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                  data-modal-hide="add-to-collection-modal"
                  type="button"
                  x-on:click="
                  $nextTick(() => {
                    fetch(
                        '{{ route('api.posts.collections.store', $post) }}',
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                collections: collections.filter(el => el.selected).map(el => el.id)
                            })
                        }
                    ).then(response => {
                        if (!response.ok) {
                            response.json().then(data => {
                                alert(data.message);
                            });
                        } else {
                            alert('Post added to collection');
                        }
                    });
                  })
                  ">Save</button>
        </div>
      </div>
    </div>
  </div>
@endpush
