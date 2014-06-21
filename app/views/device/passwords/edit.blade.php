<h2>Change your password</h2>

{{ Form::open(['url' => 'password_path(resource_name)', 'method' => 'put') }}
  {{ $devise_error_messages }}
  {{ Form::hidden('reset_password_token', 'reset_password_token') }}

  <p>{{ Form::label('password', 'password') }}<br />
  {{ Form::password('password') }}</p>

  <p>{{ Form::label('password_confirmation', 'Confirm new password') }}<br />
  {{ Form::password('password_confirmation') }}</p>

  <p>{{ Form::submit('Change my password') }}</p>
{{ Form::close() }}

@include("devise/shared/links")