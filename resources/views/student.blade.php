<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>IR 2015 Tagging System</title>
  <link rel="stylesheet" type="text/css" href="/semantic.min.css">
  <style>
    body {
      padding-top: 20px;
    }
    #menu {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="ui container">
  <div id="menu" class="ui inverted menu">
    <a class="header item" href="/">
      IR 2015 Online Tagging System
    </a>
    <a class="item" href="/{{$user->sid}}">
      {{ $user->sid }}
    </a>
  </div>
<div>
<div class="ui container" id="content">
  <h1 class='header'>{{ $user->sid }}</h1>
</div>

</body>
</html>
