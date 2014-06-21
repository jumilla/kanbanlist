<h2>Forgot your password?</h2>

{{ Form::open(['url' => 'password_path(resource_name)', 'method' => 'post') }}
  {{ $devise_error_messages }}

  <p>{{ Form::label('email') }}<br />
  {{ Form::email('email') }}</p>

  <p>{{ Form::submit('Send me reset password instructions') }}</p>
{{ Form::close() }}

@include("devise/shared/links")