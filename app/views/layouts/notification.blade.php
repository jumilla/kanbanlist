
@if (Session::has('message.success'))
<div class="alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert"></button>
  <i class="fa fa-lg fa-success"></i> {{{ Session::get('message.success') }}}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert"></button>
@foreach ($errors->all() as $error)
  <p>
    <i class="fa fa-lg fa-warning"></i> {{{ $error }}}
  </p>
@endforeach
</div>
@endif

@if (Session::has('message.information'))
<div class="alert alert-info fade in">
  <button type="button" class="close" data-dismiss="alert"></button>
  <i class="fa fa-lg fa-info"></i> {{{ Session::get('message.information') }}}
</div>
@endif
