<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'nullable|integer|between:1,5', // Calificación entre 1 y 5
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->route('events.show', $event->id)->with('success', 'Comentario agregado exitosamente.');
    }
}
