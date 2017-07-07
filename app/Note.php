<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'alias','author_id', 'last_user_id', 'changed_at', 'saved_at'
    ];

    // relations
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function lastUser()
    {
        return $this->belongsTo('App\User', 'last_user_id');
    }
}
