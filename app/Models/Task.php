<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'day', 'order', 'user_id'];

    public function getFinishedAttribute() {
        return (bool) $this->attributes['finished'];
    }
}
