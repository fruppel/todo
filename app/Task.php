<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['description', 'day', 'order', 'user_id'];

    public function getFinishedAttribute() {
        return (bool) $this->attributes['finished'];
    }
}
