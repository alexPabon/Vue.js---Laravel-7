<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Thought extends Model
{
    
    protected $casts =['created_at'=>"date:d/m/Y H:i"];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i');
    }
}
