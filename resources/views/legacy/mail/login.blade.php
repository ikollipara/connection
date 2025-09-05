<x-mail::message>
  # Login to conneCTION

  Please click the button below to login to your account.

  <x-mail::button :url="$url">
    Login
  </x-mail::button>

  If the above button does not work, you can copy and paste the following link into your web browser:

  [{!! $url !!}]({!! $url !!})

  If you did not request a login, no further action is required.

  Thanks,<br>
  {{ config('app.name') }}
</x-mail::message>
