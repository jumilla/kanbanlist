<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12"></div>
    {{ $devise_error_messages }}
    {{ Form::open(['url' => 'registration_path($resource_name)', 'method' => 'post', 'class' => 'form-horizontal']) }}
      <fieldset>
        <legend>Sign up</legend>
        <div class="control-group">
          {{ Form::label('name', 'name', [ 'class' => "control-label" ] ) }}
          <div class="controls">
            {{ Form::text('name') }}
          </div>
        </div>

        <div class="control-group">
          {{ Form::label('email', 'email', [ 'class' => "control-label" ] ) }}
          <div class="controls">
            {{ Form::email('email') }}
          </div>
        </div>

        <div class="control-group">
          {{ Form::label('password', 'password', [ 'class' => "control-label" ] ) }}
          <div class="controls">
            {{ Form::password('password') }}
          </div>
        </div>
        <div class="control-group">
          {{ Form::label('password_confirmation', 'password_confirmation', [ 'class' => "control-label" ] ) }}
          <div class="controls">
            {{ Form::password('password_confirmation') }}
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            {{ Form::submit('Sign in', [ 'class' => 'btn btn-primary' ]) }}
          </div>
        </div>
      </fieldset>
    {{ Form::close() }}
    </div>
  </div>
</div>
