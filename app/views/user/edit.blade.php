@extends('layouts.application')

@section('content')
<div class="container">
  <div class="row">
    <div class="span12"></div>
    {{ Form::open(['method' => 'post']) }}
      <fieldset>
        <legend>ユーザ情報編集</legend>
        <div class="control-group">
          <?php echo Form::label('username', 'Name', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::text('username', $user->username); ?>
            <span class="help-inline label label-important">必須</span>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('email', 'Email', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::text('email', $user->email); ?>
            <span class="help-inline label label-important">必須</span>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('password', 'Password', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::password('password'); ?>
            <span class="help-inline label label-important">変更する場合は入力</span>
          </div>
        </div>
        <div class="control-group">
          <?php echo Form::label('password_confirmation', 'Password confirmation', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::password('password_confirmation'); ?>
            <span class="help-inline label label-important">変更する場合は入力</span>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <?php echo Form::submit('Update'); ?>
          </div>
        </div>
      </fieldset>
    {{ Form::close() }}
    </div>
  </div>
</div>
@stop