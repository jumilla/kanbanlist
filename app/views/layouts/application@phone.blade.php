<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>かんばんりすと</title>
  {{ stylesheet_link_tag('application_smart_phone_iphone') }}
  <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
  <script src="http://code.jquery.com/ui/1.8.17/jquery-ui.min.js"></script>
  {{ javascript_include_tag('application_smart_phone_iphone') }}
</head>
<body>
@yield('content')
</body>
