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
    #content {
      width: 500px;
      margin: 0 auto;
    }
  </style>
</head>
<body>

<div class="ui container">
  <div id="menu" class="ui inverted menu">
    <a class="header item" href="/">
      IR 2015 Online Tagging System
    </a>
  </div>
<div>
<div class="ui container" id="content">
  <h1 class="header"> Login with your School ID </h1>
  
  <form class="ui large form {{ isset($error) ? 'error' : '' }}" action="/">

    <div class="ui error message">
      <div class="header">Action Forbidden</div>
      <p> {{ $sid or '' }} is not in database or is disabled</p>
    </div>

    <div class="ui stacked segment">
      <div class="field">
        <div class="ui left icon input">
          <i class="user icon"></i>
          <input type="text" name="school_id" placeholder="eg. r03922101">
        </div>
      </div>
     <button type="submit" class="ui fluid large blue submit button">Login</button>
     <p> {{ $user or '' }} </p>
    </div>

    <div class="ui error message"></div>

  </form>
</div>

</body>
</html>
