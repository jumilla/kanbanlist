@extends('layouts.application')

@section('content')
<div id="wrapper">
<div class="hero-unit">
  <h1>かんばんりすと</h1>
  <p>
    <h3>かんばんりすと って？</h3>
    <ul>
      <li>Web上で使える Todoリストアプリです</li>
      <li>誰でも手軽に気持ちよくタスク管理ができたらいいなという想いで作りました</li>
    </ul>

    <h3>使い方</h3>
    <ul>
      <li>操作の基本は「タスクを追加」「ドラッグ＆ドロップで状態変更」「チェックで完了」です</li>
      <li>タッチ対応ですのでスマートフォンやタブレッド等でもご利用いただけます</li>
    </ul>

    <h3>サンプルアカウント</h3>
    <ul>
      <li>Email: sample@kanban.list</li>
      <li>Pass: sample</li>
    </ul>

    <h3>ソースコード</h3>
    <ul>
      <li><a href="https://github.com/volpe28v/kanban-list">https://github.com/volpe28v/kanban-list</a></li>
      <li>ご意見ご要望などあれば GitHub の issue などでお気軽に連絡ください</li>
    </ul>
  </p>

  <p>
    <a href="{{ route('app.signup') }}" class="btn btn-primary btn-large">ユーザー登録</a>
    <a href="{{ route('app.signin') }}" class="btn btn-primary btn-large">ログイン</a>
 </p>
  There are <span id="user_count">{{ $all_user_count }}</span> users and <span id="today_tasks">{{ $today_task_count }}</span>/<span id="all_tasks">{{ $all_task_count }}</span> [today/all] tasks in かんばんりすと.
</div>
</div>
@stop
