@extends('layouts.application')

@section('content')
<div data-role="header" data-position="fixed">
  <h1>かんばんりすと for iPhone</h1>
</div>

<div data-role="content" data-theme="a">
  <p>
    <h3>概要</h3>
    <ul>
      <li>「かんばんりすと」はWeb上で比較的お手軽にTodo管理を行うためのWebアプリです。</li>
    </ul>

    <a href="{{ route('user.create') }}" class="btn btn-primary btn-large" data-role="button" data-inline="true">ユーザー登録</a>
    <a href="{{ route('user.login') }}" class="btn btn-primary btn-large" data-role="button" data-inline="true">ログイン</a>

    <h3>制限事項</h3>
    <ul>
      <li>このiPhone用サイトは現在開発中ですので使える機能が限られています。</li>
      <li>既にあるタスクの編集、状態の変更のみ可能です。</li>
      <li>全ての機能を使用したい場合はPCのブラウザからアクセスしてくださいませ。</li>
    </ul>

    <h3>ソースコード</h3>
    <ul>
      <li><a href=https://github.com/volpe28v/kanban-list>GitHub</a></li>
    </ul>
  </p>
</div>
@stop
