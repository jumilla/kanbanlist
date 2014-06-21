<h2>Resend unlock instructions</h2>

{{ Form::open(['url' => 'unlock_path($resource_name)', 'method' => 'post']) }}
  {{ $devise_error_messages }}

  <p>{{ Form::label('email', 'email') }}<br />
  {{ Form::email('email') }}</p>

  <p>{{ Form::submit('Resend unlock instructions') }}</p>
{{ Form::close() }}


@include("device/shared/links")