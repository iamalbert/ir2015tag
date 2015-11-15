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
}
