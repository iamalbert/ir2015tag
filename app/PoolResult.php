<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoolResult extends Model
{
    //
    protected $table = 'poolresults';

    public function story(){
      return $this->hasOne('App\Story', 'id', 'story_sid');
    }

    public function user(){
      return $this->hasOne('App\User', 'id', 'assignee_id');
    }

    public function get_user_sid(){
      $u = $this->user;

      if ( $u && $u->is_enabled != "0" ) return $u->sid;
      else return null;
    }
}
