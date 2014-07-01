@extends('layouts.application')

@section('content')
<div data-role="page" id="sign-in" data-theme="a">
  <div data-role="header"><h1>ログイン</h1></div>

  <div data-role="content">
    {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal']) }}
      <fieldset>
        <div class="control-group">
          <div class="controls">
            {{ Form::text('email', '', ['placeholder' => "Email"]) }}
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            {{ Form::password('password', ['placeholder' => "Password"]) }}
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
@stop
