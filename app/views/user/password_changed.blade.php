@extends('layouts.application')

@section('content')
<div class="container-fluid">
	<div class="well">
		<center>
		<p>パスワードを変更しました。再ログインをお願いします。</p>
		<a class="btn btn-primary btn-large" href="{{ route('user.login') }}">ログイン<a>
		</center>
	</div>
</div>
@stop
