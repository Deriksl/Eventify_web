<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'date', 'ticket_price', 'user_id', 'logo'];
    protected $casts = [
        'date' => 'datetime',
        'ticket_price' => 'decimal:2',
    ];

    // Relación entre Evento y Usuario (un evento pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con los usuarios que asisten al evento
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
            ->withTimestamps();
    }

    // Relación uno a muchos con los comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
