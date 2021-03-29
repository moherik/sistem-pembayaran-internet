<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'packet_id', 'total_item', 'total_price', 'pay_date'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->trx_code = uniqid();
        });
    }

    public function packet()
    {
        return $this->belongsTo(Packet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priceLabel()
    {
        return "Rp " . number_format($this->total_price, 0, ',', '.');
    }

    public function packetLabel()
    {
        return $this->packet->name . " (" . $this->packet->speed . "Mbps)";
    }

    public function createdDate()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function statusLabel()
    {
        $className = "";
        $label = "";
        switch ($this->status) {
            case 'PENDING':
                $className = "text-gray-600";
                $label = "PENDING";
                break;

            case 'SUCCESS':
                $className = "text-blue-600";
                $label = "SUKSES";
                break;

            case 'CANCEL':
                $className = "text-red-600";
                $label = "BATAL";
                break;

            default:
                $className = "text-gray-600";
                $label = "N/A";
                break;
        }

        return '<div class="font-bold ' . $className . '">' . $label . '</div>';
    }
}
