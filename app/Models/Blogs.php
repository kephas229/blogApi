<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $fillable = ['title', 'shortDesc', 'Description', 'author', 'image', 'user_id'];

    //Un article possède plusieurs commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}