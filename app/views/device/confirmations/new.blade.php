<h2>Resend confirmation instructions</h2>

{{ Form::open(['url' => 'confirmation_path($resource_name)', 'method' => 'post') }}
  {{ $device_error_messages }}

  <p>{{ Form::label('email', 'email') }}<br />
  {{ Form::email('email','email') }}</p>

  <p>{{ Form::submit('Resend confirmation instructions') }}</p>
{{ Form::close() }}

@include("device/shared/links")