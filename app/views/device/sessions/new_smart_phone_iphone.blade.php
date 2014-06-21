<div data-role="page" id="sign-in" data-theme="a">
  <div data-role="header"><h1>ログイン</h1></div>

  <div data-role="content">
    {{ Form::open(['url' => 'users/sign_in', 'method' => 'post', 'class' => 'form-horizontal']) }}
      <fieldset>
        <div class="control-group">
          <div class="controls">
            {{ Form::text('email', ['placeholder' => "Email"]) }}
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            {{ Form::password('email', ['placeholder' => "Password"]) }}
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            {{ Form::submit('ログイン', ['class' => 'btn btn-primary']) }}
          </div>
        </div>
      </fieldset>
    {{ Form::close() }}
  </div>
</div>
