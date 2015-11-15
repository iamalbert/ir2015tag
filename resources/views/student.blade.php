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
    .query-story, .news-story, #query-titles .query-title {
      display: none;
    }
    #query-stories {
      max-height: 400px;
      overflow-y: scroll;
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

  <div class="ui grid">
    <div class="three wide column">
      <div class="ui brown vertical fluid menu">
        @foreach( $tasks as $query_id => $stories )
          <a class="item query-selector" data-id="query-{{$query_id}}">
            Query &#35;{{$query_id}}
            <div class="ui brown label"> {{ count($stories) }}</div>
          </a>
        @endforeach
      </div>
    </div>

    {{--
    <div class="four wide column" id="query-titles">
      @foreach( $queries as $qid => $stories )
      <div class="ui vertical fluid secondary pointing menu query-title query-{{$qid}}">
        @foreach( $stories as $story )
        <a class="item "> {{ $story->title }} </a>
        @endforeach
      </div>
      @endforeach
    </div>
    --}}

    <div class="thirteen wide column" id="query-stories">
      @foreach( $queries as $qid => $stories )
        @foreach( $stories as $story )
        <div class="ui segment query-story query-{{$qid}}">
          <h3 class="ui header">{{ $story->title }} </h3>
          {{ $story->text }}
        </div>
        @endforeach
      @endforeach
    </div>

  </div>

  <div class="ui two column grid">
       @foreach( $tasks as $qid => $stories )
        @foreach( $stories as $story ) 
        <div class="column">
          <div class="ui segment news-story query-{{$qid}}">
            <button class="ui green button">RELEVANT</button>
            <button class="ui basic red button">IRRELEVANT</button>
            <a class="ui teal top right attached label">{{ $story->id }}</a>
            <h3 class="ui header"> {{ $story->title }} </h3>
            {{ $story->text }}
          </div>
        </div>
        @endforeach
      @endforeach
  </div>
</div>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
function select_query (id){
  $(".query-story, .news-story, #query-titles .query-title").hide();
  $("."+id).show();
}
$( function(){
  var $selectors = $(".query-selector");
  
  $selectors.on("click", function(){
    var $$ = $(this)

    $selectors.removeClass('active');
    $$.addClass('active');

    select_query( $$.data('id') )
  })
})
</script>
</body>
</html>
