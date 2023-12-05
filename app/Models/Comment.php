<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'destination_id',
        'comment_id',
    ];

    public function replies() {
        return $this->belongsToMany(Comment::class, 'comment_id');
    }
}
