@extends('layouts/default')
@section('content')
<div class="container">
  <div class="row">
    <div class="span12"></div>
    {{ Form::open(array('url') => 'users/edit', 'method' => 'post')) }}
      <fieldset>
        <legend>ユーザ情報編集</legend>
        <div class="control-group">
          <?php echo Form::label('name', 'Name', array('class' => 'control-label')); ?>
          <div class="controls">
            <?php echo Form::text('name'); ?>
            <span class="help-inline label label-important">必須</span>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('email', 'email', array('class' => 'control-label'); ?>
          <div class="controls">
            <?php echo Form::text('email'); ?>
            <span class="help-inline label label-important">必須</span>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('password', 'password', array('class' => 'control-label'); ?>
          <div class="controls">
            <?php echo Form::password('password'); ?>
            <span class="help-inline label label-important">変更する場合は入力</span>
          </div>
        </div>
        <div class="control-group">
          <?php echo Form::label('password_confirmation', 'password confirmation', array('class' => 'control-label'); ?>
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