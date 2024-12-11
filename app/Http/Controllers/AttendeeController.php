<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket; // Asegúrate de que Ticket esté correctamente importado
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function manage($eventId)
    {
        $event = Event::findOrFail($eventId);
        $attendees = Ticket::where('event_id', $eventId)->with('user')->get(); // Obtener asistentes

        return view('manage_attendees', compact('event', 'attendees'));
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->back()->with('success', 'Asistente eliminado correctamente.');
    }
}
