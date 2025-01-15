{{--
file: resources/views/users/events/partials/edit-details-drawer.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The drawer for editing event details
 --}}

@php
  use App\Enums\Audience;
  use App\Enums\Category;
  use App\Enums\Grade;
  use App\Enums\Language;
  use App\Enums\Practice;
  use App\Enums\Standard;
@endphp

<div class="fixed top-0 left-0 z-40 w-96 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
     id="{{ $name }}"
     aria-labelledby="{{ $name }}-label"
     tabindex="-1">
  <h5 class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400"
      id="{{ $name }}-label">Event Details</h5>
  <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
          data-drawer-hide="{{ $name }}"
          type="button"
          aria-controls="{{ $name }}">
    <svg class="w-5 h-5"
         aria-hidden="true"
         fill="currentColor"
         viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"></path>
    </svg>
    <span class="sr-only">Close menu</span>
  </button>
  <div class="py-4 overflow-y-auto"
       x-data>
    <ul class="space-y-2 font-medium"
        x-data="{
            days: {{ Js::from($event->days_count) }},
            createDayEl() {
                const li = document.createElement('li');
                const wrapper = document.createElement('div');
                const input = document.createElement('input');
        
                wrapper.classList.add('relative', 'max-w-sm');
        
                input.classList.add('bg-gray-50', 'border', 'border-gray-300', 'text-gray-900', 'text-sm', 'rounded-lg', 'focus:ring-blue-500', 'focus:border-blue-500', 'block', 'w-full', 'p-2.5', 'dark:bg-gray-700', 'dark:border-gray-600', 'dark:placeholder-gray-400', 'dark:text-white', 'dark:focus:ring-blue-500', 'dark:focus:border-blue-500')
                input.name = `days[${this.days}][date]`;
                input.setAttribute('type', 'text');
                input.setAttribute('datepicker', '');
                input.setAttribute('x-model', `days[${this.days}]`);
                input.setAttribute('placeholder', 'Select date');
                input.setAttribute('required', '');
        
                wrapper.appendChild(input);
                li.appendChild(wrapper);
        
                this.days++;
        
                return [li, input];
            }
        }"
        x-on:add-event-day="
            const el = createDayEl();
            $el.appendChild(el[0]);
            new window.flowbiteDatePicker(el[1], {
                format: 'yyyy-mm-dd',
                autohide: true,
            });
        ">
      <li>
        <x-form-select name="audience"
                       :selected="$event->metadata->audience"
                       :options="Audience::cases()" />
      </li>
      <li>
        <x-form-select name="grades"
                       :options="Grade::cases()"
                       :selected="$event->metadata->grades"
                       multiple />
      </li>
      <li>
        <x-form-select name="languages"
                       :options="Language::cases()"
                       :selected="$event->metadata->languages"
                       multiple />
      </li>
      <li>
        <x-form-select name="category"
                       :selected="$event->metadata->category"
                       :options="Category::cases()" />
      </li>
      <li>
        <x-form-select name="practices"
                       :selected="$event->metadata->practices"
                       :options="Practice::cases()"
                       multiple />
      </li>
      <li>
        <x-form-input name="location"
                      placeholder="Location..."
                      required />
      </li>
      <li class="mx-auto grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                 for="start-time">Start time:</label>
          <div class="relative">
            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                   aria-hidden="true"
                   xmlns="http://www.w3.org/2000/svg"
                   fill="currentColor"
                   viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                      d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                      clip-rule="evenodd" />
              </svg>
            </div>
            <input class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   id="start-time"
                   name="start"
                   type="time"
                   value="{{ optional($event->start)->format('H:i') }}"
                   x-data
                   required />
          </div>
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                 for="end-time">End time:</label>
          <div class="relative">
            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                   aria-hidden="true"
                   xmlns="http://www.w3.org/2000/svg"
                   fill="currentColor"
                   viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                      d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                      clip-rule="evenodd" />
              </svg>
            </div>
            <input class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   id="end-time"
                   name="end"
                   type="time"
                   value="{{ optional($event->end)->format('H:i') }}"
                   x-data
                   required />
          </div>
        </div>
      </li>
      <li class="flex flex-col sm:flex-row gap-x-3 items-center w-full justify-between">
        <h2>Days</h2>
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button"
                x-on:click="$dispatch('add-event-day')">Add New Day</button>
      </li>
      <li>
        @forelse($event->days as $idx => $day)
          <div class="relative max-w-sm">
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   id="default-datepicker"
                   name="days[{{ $idx }}][date]"
                   type="text"
                   value="{{ $day->date }}  "
                   required
                   datepicker
                   datepicker-format="yyyy-mm-dd"
                   datepicker-autohide
                   placeholder="Select date">
          </div>
        @empty
          <div class="relative max-w-sm">
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   id="default-datepicker"
                   name="days[0][date]"
                   type="text"
                   required
                   datepicker
                   datepicker-format="yyyy-mm-dd"
                   datepicker-autohide
                   placeholder="Select date">
          </div>
        @endforelse
    </ul>
    <div class="mt-3">
      <x-form-submit label="Save Event" />
    </div>
  </div>
</div>
