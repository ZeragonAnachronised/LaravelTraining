<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function info() {
        return $this->user()->name . ' got an event #' . $this->id . ' is a ' . $this->user()->status;
    }
}
