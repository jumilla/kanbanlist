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
@if ($_SERVER['GOOGLE_ANALYTICS_ID'] )
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '{{ $_SERVER['GOOGLE_ANALYTICS_ID'] }}', 'heroku.com');
  ga('send', 'pageview');
</script>
@end

<header>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="/">かんばんりすと</a>
        <div class="nav-collapse">
          <ul class="nav pull-left">
@if (Auth::user())
              <li><a href="{{ route('dashboard') }}" rel="tooltip" title="Go to your dashboard"><i class="icon-eye-open"></i></a></li>
              <li><a href="{{ route('user.signout') }}" rel="tooltip" title="Go to your kanbanlist"><i class="icon-home"></i></a></li>
@end
@include('layouts/book_list_dropdown_li')
@include('layouts/layout_dropdown_li')
@include('layouts/theme_dropdown_li')
          </ul>

          <form id="filter_form" method="post" class="navbar-search pull-left">
            <input type="text" id="filter_str" class="search-query span2" value="" placeholder="Filter"/>
          </form>

          <div class="pull-left">
@include('layouts/task_count_table')
          </div>

          <ul class="nav pull-right">
@include('layouts/trial_feature_dropdown_li')

@if (Auth::user())
              <li><a href="{{ route('user.signout') }}">Logout</a></li>
@end
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>

@include('layouts/new_book_dialog')
@include('layouts/remove_book_dialog')
@include('layouts/send_mail_dialog')
@include('layouts/set_bg_image_dialog')
@include('layouts/delete_task_dialog')

{{ yield }}

  <footer>
    <span>
    © 2011 Naoki KODAMA. All rights reserved.
    </span>
  </footer>
</body>
</html>
