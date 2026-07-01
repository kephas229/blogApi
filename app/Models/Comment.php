<?php

namespace App\Models;

use App\Models\Blogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'visitor_name',
        'visitor_email',
        'message'
    ];
    public function blog()
    {
        return $this->belongsTo(Blogs::class);
    }
}
