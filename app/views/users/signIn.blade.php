@extends('layouts/default')
@section('content')
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
@include('layouts.notification')

    {{ Form::open(['route' => 'user.signin', 'method' => 'post', 'class' => 'form-horizontal']) }}
      <fieldset>
        <legend>ログイン</legend>
        <div class="control-group">
          {{ Form::label('email', 'email', ['class' => 'control-label']) }}
          <div class="controls">
            {{ Form::text('email') }}
          </div>
        </div>
        <div class="control-group">
          {{ Form::label('password', 'password', ['class' => 'control-label']) }}
          <div class="controls">
            {{ Form::password('password') }}
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            {{ Form::submit('ログイン', ['class' => 'btn btn-primary']) }}
            <button id="login_with_sample" class="btn btn-inverse">サンプルアカウントでログイン</button>
          </div>
        </div>
      </fieldset>
    {{ Form::close() }}
  </div>
</div>

<script>
$(document).ready(function() {
  $("#login_with_sample").click(function(){
    $("#email").val("sample@kanban.list");
    $("#password").val("sample");
    submit();
  });
});
</script>
@stop