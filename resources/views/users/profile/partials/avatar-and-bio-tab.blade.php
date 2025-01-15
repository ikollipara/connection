{{--
file: resources/views/users/profile/partials/avatar-and-bio-tab.blade.php
author: Ian Kollipara
date: 2024-09-21
description: The avatar and bio tab for the user profile
 --}}

<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
     id="avatarDescription"
     role="tabpanel"
     aria-labelledby="avatarDescription-tab">
  <label class="block mb-3">
    <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      Profile Biography
    </span>
    <x-form-help-text
                      message="Your profile biography. This is shown to all visitors of your profile, so make it count!" />
    <x-form-input-error name="bio" />
    <x-form-rich-text name="bio" />
  </label>
</div>
