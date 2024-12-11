<?php

namespace App\Http\Controllers;

use App\Mail\registermail;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Billable;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Ticket; // Esto es lo correcto
use Illuminate\Support\Str;



class EventController extends Controller
{
    public function purchaseTicket(Request $request, Event $event)
    {
        if (is_null($event->price) || $event->price <= 0) {
            return back()->withErrors('El precio del evento no está disponible o es inválido.');
        }

        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Asegúrate de que el monto sea válido (mayor que el mínimo)
        $amount = max($event->price * 100, 50); // 50 centavos es el mínimo para USD

        // Crear un PaymentIntent con Stripe
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount, // El precio del ticket en centavos
            'currency' => 'usd', // O la moneda que estés usando
            'metadata' => ['event_id' => $event->id],
        ]);

        // Guardar la compra del ticket si el pago es exitoso
        $user = $request->user();

        // Asumimos que el pago se ha realizado correctamente en el frontend
        $ticket = Ticket::create([
            'price' => $event->price, // Asegúrate de que $event->price tenga un valor válido
            'purchase_date' => now(),
            'ticket_code' => Str::random(10),
            'status' => 'valid',
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        // Retornar el client secret para completar el pago en el frontend
        return view('event.payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'event' => $event,
            'ticket' => $ticket
        ]);
    }


    public function showTicket(Ticket $ticket)
    {
        // Asegúrate de que el ticket pertenece al usuario autenticado
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este ticket.');
        }

        return view('ticket.show', compact('ticket'));
    }

    public function useTicket(Ticket $ticket)
    {
        // Asegúrate de que el ticket pertenece al usuario autenticado
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para usar este ticket.');
        }

        // Cambiar el estado a 'usado'
        $ticket->update(['status' => 'used']);

        return redirect()->route('tickets.show', $ticket)->with('message', 'Ticket usado correctamente.');
    }



    public function index()
    {
        // Obtener los eventos (ajusta la lógica según lo que necesites)
        $events = Event::paginate(10); // O la lógica que necesites

        // Retornar la vista pasando la variable $events
        return view('home', compact('events'));
    }



    public function myevents()
    {
        $user = auth()->user(); // Obtener al usuario autenticado

        // Obtener los eventos a los que el usuario ha asistido o asistirá
        $attendingEvents = Ticket::where('user_id', $user->id)
            ->with('event') // Relacionar con el evento
            ->get()
            ->pluck('event'); // Obtener solo los eventos

        // Obtener los eventos creados por el usuario (si es necesario)
        $createdEvents = Event::where('user_id', $user->id)->get();

        return view('myevents', compact('attendingEvents', 'createdEvents'));
    }


    // Método para mostrar el formulario de creación de evento
    public function create()
    {
        return view('events.create');
    }

    // Método para almacenar un evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string',
            'date' => 'required|date',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['logo'] = $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null;

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento creado con éxito.');
    }


    // Método para editar un evento
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    // Método para actualizar un evento
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'location' => 'nullable|max:255',
            'date' => 'required|date',
            'status' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validated);

        // Manejo del logo
        if ($request->hasFile('logo')) {
            if ($event->logo) {
                \Storage::delete('public/' . $event->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $event->logo = $path;
            $event->save();
        }

        // Redirigir a la página de "Mis eventos" después de la actualización
        return redirect()->route('myevents')->with('success', 'Evento actualizado exitosamente.');
    }


    // Método para eliminar un evento
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('myevents')->with('success', 'Evento eliminado exitosamente.');
    }


    public function show($id)
    {
        $event = Event::with(['user', 'comments.user'])->findOrFail($id); // Cargar comentarios y el usuario que los hizo
        return view('events.show', compact('event'));
    }


}

