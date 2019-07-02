@component('mail::message')
Hello **{{ $data['name'] }}**,

Email: {{ $data['email'] }}<br>
Password: {{ $data['password'] }}

Click below to login now
@component('mail::button', ['url' => $data['link']])
    Go to your panel
@endcomponent
Sincerely,<br>
Club Management.
@endcomponent