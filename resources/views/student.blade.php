<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>IR 2015 Tagging System</title>
  <link rel="stylesheet" type="text/css" href="/semantic.min.css">
  <style>
    body {
      padding-top: 20px;
      position: relative;
    }
    #menu {
      margin-bottom: 20px;
    }
    .query-story, .news-story, #query-titles .query-title {
    }
    .query-stories {
      max-height: 500px;
      overflow-y: scroll;
    } 
    div.news-story.ui.segment{
      padding-top: 30px;
    }
    .tag-cb {
      padding: 10px;
      margin-right: 10px;
      border: solid 2px black;
      border-radius: 0.214286rem;
    }
    input[type=radio].tag-radio {
      display: none;
    }
    .tag-cb.green { border-color: green; color: green; }
    .tag-cb.red   { border-color: red  ; color: red  ; }
    .tag-radio + .tag-cb { background: white; cursor: pointer; font-size:1.2em;}
    .tag-radio:checked + .tag-cb.green { background-color: green; color: white; }
    .tag-radio:checked + .tag-cb.red   { background-color: red  ; color: white; }

    #submit-button { text-align: center; }
    .query-titles, .stories {
      width: 44%;
      margin: 0;
    }
    .query-set {
      position: relative;
      min-height: 1000px;  
    }
    .query-titles {
      float: left;
      margin-left: 5%;
    }
    .stories {
      margin-left: 50%;
    }
    .query-fixed {
      position: fixed;
      top: 10px;
    }
    .query-bottom {
      position: absolute;
      bottom: 5px;
    }
  </style>
</head>
<body>

<div class="ui container" id="top">
  <div id="menu" class="ui inverted menu">
    <a class="header item" href="/">
      IR 2015 Online Tagging System
    </a>
    <a class="item" href="/{{$user->sid}}">
      {{ $user->sid }}
    </a>
  </div>
  <div class="ui progress indicating {{ $is_finished ? "success" : "warning" }}">
    <div class="bar" style="width: {{ $percentage }}%;">
      <div class="progress"></div>
    </div>
    <div class="label"> Progress: {{$progress['finished']}} / {{$progress['total']}} </div>
  </div>
  <h1 class='header'>{{ $user->sid }}</h1>
  <div> {{ $msg or '' }} </div>

</div>
<form class="ui fluid container" id="content" action="/{{$user->sid}}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" />

  
  @foreach( $tasks as $qid => $task )
  <div class="query-set">
    <div class="ui divider"></div>
    <div class="query-titles">
        <h2 class="ui header"> Query &#35;{{$qid}} </h2>
        <div class="query-title ui labels query-title query-{{$qid}}">
          @foreach( $queries[$qid] as $story )
            <a class="ui big brown label" data-target="#qs-{{$story->id}}"> {{ $story->title }} </a>
          @endforeach
        </div>
        <div class="query-stories ui segment query-stories query-{{$qid}}">
          @foreach( $queries[$qid] as $story )
            <h3 class="ui header" id="qs-{{$story->id}}">{{ $story->title }} </h3>
            <p>{{ $story->text }}</p>
          @endforeach
        </div>
    </div>
    <div class="stories">
        <h2 class="ui header"> Relevant Doc Candidates for Query #{{$qid}} </h2>
        @foreach( $task as $result ) 
          <div class="ui teal segment news-story query-{{$qid}}">

            <h2 class="ui header"> {{ $result->story->title }} </h2>
            <p class="story-content"> {{ $result->story->text }} </p>
            <a class="ui teal top right attached label">{{ '#'.$result->story->id }}</a>

            <input class="tag-radio" type="radio" id="result-{{$result->id}}-r" name="result[{{ $result->id }}]"
              value="1" {{ $result->label == "1" ? "checked" : "" }} > 
            <label class="tag-cb green" for="result-{{$result->id}}-r"> RELEVANT</label>

            <input class="tag-radio" type="radio" id="result-{{$result->id}}-i" name="result[{{ $result->id }}]"
              value="-1" {{ $result->label == "-1" ? "checked" : "" }} > 
            <label class="tag-cb red" for="result-{{$result->id}}-i"> IRRELEVANT</label>


          </div>
        @endforeach
    </div>
  </div>
  @endforeach
  <div class="ui one column grid">
    <div class="column text-center" id="submit-button">
          <button type="submit" class="ui huge blue button"> Save </button>
    </div>
  </div>
</form>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
function select_query (id){
  $(".query-stories, .news-story, #query-titles .query-title").hide();
  $("."+id).show();
}

jQuery.fn.scrollTo = function($elem) { 
  var $this = $(this)
  $this.animate( {
    scrollTop: $this.scrollTop() - $this.offset().top + $elem.offset().top
  })
  return this; 
};

$( function(){
  var $selectors = $(".query-selector");
  
  $selectors.on("click", function(){
    var $$ = $(this)

    $selectors.removeClass('active');
    $$.addClass('active');

    //select_query( $$.data('id') )
  })

  $(".query-title a").on("click", function(){
    var $target = $( $(this).data('target') )
    $target.parent().scrollTo( $target )
  })

  var query_set_height = []
  $(".query-set").each( function(){
    var $this = $(this)
    query_set_height.push( { 
      ele: $this.find(".query-titles"), 
      top: function(){ return $this.offset().top },
      bottom: function(){ return $this.offset().top + $this.height() }
    } )
  })

  //console.log(query_set_height)


  $( document ).on("scroll", function(e){
    var top = $(this).scrollTop()
    var ele
    //console.log( top )


    for( var i = 0; i < query_set_height.length; i++ ){
      if( query_set_height[i].top() > top ) { 
        for( var j = i; j < query_set_height.length; j++ ){
          query_set_height[j].ele.removeClass("query-fixed").removeClass("query-bottom");
        }
        i--; 
        break; 
      }else{
        query_set_height[i].ele.removeClass("query-fixed").removeClass("query-bottom");
      }
    }

    if( i == query_set_height.length ) i--;

    if( i >= 0 && i < query_set_height.length ){
      var $ele = query_set_height[i].ele
      //console.log( $ele.find("h2").html() )

      if( top + $ele.height() > query_set_height[i].bottom()  ){
        $ele.removeClass("query-fixed");
        $ele.addClass("query-bottom");
      }else{
        $ele.addClass("query-fixed");
        $ele.removeClass("query-bottom");
      }
    }
  })

  //$selectors.eq(0).trigger('click')
})
</script>
</body>
</html>
