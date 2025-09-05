@component('mail::message')
  # New Survey from conneCTION

  Thank you for consenting to participate in our study.
  Please click the button below to begin the survey.
  The study should take about 1-2 hours to complete.
  Please take your time and answer the questions as accurately as possible.
  If needed, you can save your progress and return to the survey at a later time.

  @component('mail::button', compact('url'))
    Complete Survey
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
