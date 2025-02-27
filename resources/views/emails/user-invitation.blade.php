@component('mail::message')
# Welcome to Whello!

You have been invited to join Whello. Please click the button below to activate your account.

@component('mail::button', ['url' => $activationUrl])
Activate Account
@endcomponent

This invitation link will expire in 7 days.

If you did not request this invitation, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
