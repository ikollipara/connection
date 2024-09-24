{{--
file: resources/views/users/posts/partials/form.blade.php
author: Ian Kollipara
date: 2024-09-11
description: The form for creating or editing a post
 --}}

<x-form form-name="{{ $formName }}"
        action="{{ $action }}"
        x-data="{
            title: {{ Js::from($collection->title) }},
            body: {{ Js::from($collection->body) }},
            persisted: {{ Js::from($collection->exists) }},
            queue: [],
            save(data) {
                this.$dispatch('editor:saving');
                fetch(this.$el.action, {
                    method: this.$refs.method.value,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.$refs.csrf.value ? 'Accept' : 'application/json',
                    },
                    body: JSON.stringify(data)
                }).then(response => {
                    if (response.ok) {
                        this.$dispatch('editor:saved', {
                            action: data.drawerAction,
                            method: 'PUT',
                        });
                        response.json().then(data => {
                            this.$el.id = 'edit-post-form';
                            this.$el.action = data.formAction;
                            this.$refs.method.value = 'PUT';
                            if (response.status === 201) {
                                window.history.replaceState({}, `conneCTION - Edit ${data.title}`, data.url);
                            };
                        });
                    } else {
                        response.json().then(data => {
                            alert(data.message);
                        });
                    }
                })
        
            }
        }"
        x-init="$watch('queue', queue => {
            if (queue.length) {
                save(queue.shift());
            }
        })"
        x-on:save.window="
          if (!persisted) {
            queue.push({ title, body });
          } else {
            queue.length = 0;
            save({ title, body });
          }
          "
        method="{{ $method }}"
        :model="$collection">
  <x-form-input class="bg-none border-none bg-transparent !text-4xl leading-none tracking-tight text-gray-900 focus:ring-0 focus:border-b focus:border-blue-700 px-0 mb-5 py-0"
                name="title"
                x-model="title"
                x-on:input="$dispatch('editor:unsaved')"
                placeholder="Post Title..." />
  <x-form-rich-text name="body"
                    x-model="body"
                    :value="$collection->body" />
</x-form>
@include('users.collections.partials.publishing-drawer', [
    'collection' => $collection,
    'name' => $drawerName,
    'method' => $method,
    'action' => $drawerAction,
])
