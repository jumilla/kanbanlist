<h2>Edit {{ resource_name.to_s.humanize }}</h2>

{{ Form::open(['url' => 'registration_path($resource_name)', 'method' => 'post', 'class' => 'form-horizontal']) }}
  {{ $devise_error_messages }}

  <p>{{ Form::label('email', 'email' ) }}<br />
  {{{ Form::email('email') }}</p>

  <p>{{ Form::label('password', 'password' ) }} <i>(leave blank if you don't want to change it)</i><br />
  {{ Form::password('password') }}</p>

  <p>{{ Form::label('password_confirmation', 'password_confirmation' ) }}<br />
  {{ Form::password('password_confirmation') }}</p>

  <p>{{ Form::label('current_password', 'current_password' ) }} <i>(we need your current password to confirm your changes)</i><br />
  {{ Form::password('current_password') }}</p>

  <p>{{ Form::submit('Update') }}</p>
{{ Form::close() }}

<h3>Cancel my account</h3>

<p>Unhappy? {{ link_to('registration_path($resource_name)', 'Cancel my account', [ 'onclick' => 'alert("Are you sure?");' ]) }}.</p>

{{ link_to('#', 'Back', [ 'onclick' => 'history.back(); return false;' ]) }}
