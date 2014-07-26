@extends('layouts.application')

@section('content')
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
@include('layouts.notification')

    {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal']) }}
      <fieldset>
        <legend>Sign up</legend>
        <div class="control-group">
          <?php echo Form::label('username', 'Name', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::text('username'); ?>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('email', 'Email', ['class' => 'control-label']); ?>
          <div class="controls">
			      <?php echo Form::text('email'); ?>
          </div>
        </div>

        <div class="control-group">
          <?php echo Form::label('password', 'Password', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::password('password'); ?>
          </div>
        </div>
        <div class="control-group">
          <?php echo Form::label('password_confirmation', 'Password confirmation', ['class' => 'control-label']); ?>
          <div class="controls">
            <?php echo Form::password('password_confirmation'); ?>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
             {{ Form::submit("Sign in", array('class'=>"btn btn-primary")) }}
          </div>
        </div>
      </fieldset>
    {{ Form::close() }}
    </div>
  </div>
</div>
@stop