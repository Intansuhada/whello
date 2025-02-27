@component('mail::message')
# You've Been Invited!

You have been invited to join Whello. Click the button below to set up your account.

@component('mail::button', ['url' => route('users.activate.view', $token)])
Accept Invitation
@endcomponent

This invitation link will expire in 24 hours.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
