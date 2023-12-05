<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';
    protected $fillable = ['image', 'destination_id'];

    public function destination() {
        $this->belongsTo(Destination::class, 'destination_id', 'id');
    }
}
