<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
use HasFactory;
    const STATUS_VALID = 'valid';
    const STATUS_USED = 'used';

protected $fillable = [
'price', 'purchase_date', 'ticket_code', 'status', 'user_id', 'event_id',
];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
