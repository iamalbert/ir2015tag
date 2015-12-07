<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
  protected function togroup( $tasks ){
    $arr = [];

    foreach($tasks as $task){
      $qid = $task->query_qid;

      if( ! isset( $arr[$qid] ) )
        $arr[$qid] = [];

      $arr[$qid] []= $task;
    }

    ksort($arr);
    return $arr;
  }

  protected $msg = "";

  public function save( Request $req, $id ){
  
    $results = $req->input('result');

    if( is_array($results) ){

      foreach( $results as $result_id => $tag ){


        $r = \App\PoolResult::where('id',$result_id)->first();

        if( $r && $r->get_user_sid() == $id ){

          $tag = (int) $tag;

          if( $tag > 0 ) $tag = 1;
          else if ( $tag < 0 ) $tag = -1;
          else $tag = 0;

          $r->label = $tag;
          $r->save();
        }
      }

    }

    return $this->student($req, $id);
  }
  
    public function student(Request $req, $id){
      $user = \App\User::where('sid', $id )->first();

      if ( $user == null || $user->is_enabled == 0 ){
        return view('test', [
          'error' => $id,
          'sid'   => $id,
        ]);
      }else{
        $tasks = \App\PoolResult::where('assignee_id', $user->id)
            ->orderBy('query_qid', 'asc')
            ->get();

        $progress = [ 'total' => 0, 'finished' => 0 ];
        $progress['total'] = $tasks->count();
        foreach( $tasks as $r ){
          if( $r->label != "0" ) $progress['finished']++;
        }


        $tasks = $this->togroup( $tasks );


        $queries = [];


        foreach( $tasks as $qid => $_ ){
          $ret = \App\Query::where('query_id', $qid)->get();
          $queries[$qid] = $ret;

                 }

        return view('student', [
          'progress' => $progress,
          'percentage' => $progress['total'] != 0 ?
            $progress['finished'] * 100/ $progress['total'] : 100
          ,
          'is_finished' => $progress['total'] == $progress['finished'],
          'msg'  => $this->msg,
          'user' => $user,
          'tasks' => $tasks,
          'queries' => $queries
        ]);
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      $id = $req->input('school_id', '');

      if( $id != '' ){
        return redirect()->action('IndexController@student', [$id] );
      }else{
        return view('test');
      }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
