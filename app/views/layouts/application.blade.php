<!DOCTYPE html>
<html>
<head>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>かんばんりすと</title>

  {{ stylesheet_link_tag('application') }}
  {{ stylesheet_link_tag('task_default', ['id' => 'task_theme']) }}
  {{ javascript_include_tag('application') }}

</head>
<body id="body_core" style="
 background-color: white;
 background-attachment: fixed;
 background-position: center top;
 background-repeat:  repeat;
 padding-top: 60px;
">
@if (isset($_SERVER['GOOGLE_ANALYTICS_ID']))
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '{{ $_SERVER['GOOGLE_ANALYTICS_ID'] }}', 'heroku.com');
  ga('send', 'pageview');
</script>
@endif

<header>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="/">かんばんりすと</a>
        <div class="nav-collapse">
          <ul class="nav pull-left">
@section('top-left-menu')
@if (Auth::user())
              <li><a href="{{ route('dashboard') }}" rel="tooltip" title="Go to your dashboard"><i class="icon-eye-open"></i></a></li>
              <li><a href="{{ route('tasks.index') }}" rel="tooltip" title="Go to your kanbanlist"><i class="icon-home"></i></a></li>
@endif
@show
          </ul>

          <ul class="nav pull-right">
@section('top-right-menu')
@if (Auth::user())
            <li><a href="{{ route('user.logout') }}">Logout</a></li>
@endif
@show
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>

@include('layouts.new_book_dialog')
@include('layouts.remove_book_dialog')
{{-- @include('layouts/send_mail_dialog') --}}
@include('layouts.set_bg_image_dialog')
@include('layouts.delete_task_dialog')

@yield('content')

  <footer>
    <span>
    Laravel4版 © 2014 <a href="http://github.com/jumilla/kanbanlist/blob/master/readme.md">Laravelers</a>. All rights reserved.
    Rails3版 © 2011 Naoki KODAMA. All rights reserved.
    </span>
  </footer>
</body>
</html>
