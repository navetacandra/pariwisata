<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'address',
        'slug',
        'category',
        'description',
        'image',
        'view',
    ];

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('comment_id');//->belongsToMany(Comment::class);
    }
}
