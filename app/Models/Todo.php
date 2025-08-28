<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['user_id','title', 'creation_date', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
