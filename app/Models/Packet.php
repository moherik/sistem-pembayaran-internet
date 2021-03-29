<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'speed', 'description', 'type'];

    protected $hidden = ['deleted_at', 'updated_at'];

    public function speedLabel()
    {
        return (string)$this->speed . " Mbps";
    }

    public function priceLabel()
    {
        return "Rp " . number_format($this->price, 0, ',', '.');
    }

    public function typeLabel()
    {
        switch ($this->type) {
            case 'MONTHLY':
                return 'Bulanan';
                break;

            case 'ANUALLY':
                return 'Tahunan';
                break;

            default:
                return 'N/A';
                break;
        }
    }
}
