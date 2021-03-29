<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title'];

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel()
    {
        if ($this->status == "OPEN") {
            return '<span class="text-green-600 font-semibold">Buka</span>';
        } else if ($this->status == 'CLOSE') {
            return '<span class="text-red-600 font-semibold">Tutup</span>';
        } else {
            return '<span class="text-gray-800 font-semibold">N/A</span>';
        }
    }
}
