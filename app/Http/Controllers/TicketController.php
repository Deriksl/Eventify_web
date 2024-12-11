<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Event;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function showPurchaseForm($id)
    {
        $event = Event::findOrFail($id);
        return view('purchase', compact('event'));
    }

    public function processPurchase(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'stripeToken' => 'required',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $charge = Charge::create([
            'amount' => $event->price * 100, // Precio en centavos
            'currency' => 'usd',
            'description' => 'Compra de boleto para ' . $event->name,
            'source' => $request->stripeToken,
            'receipt_email' => $request->email,
        ]);

        // Crear el ticket en la base de datos
        Ticket::create([
            'price' => $event->price,
            'purchase_date' => now(),
            'ticket_code' => uniqid('TICKET_'),
            'status' => 'valid',
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return redirect()->route('events.index')->with('success', 'Compra realizada con éxito.');
    }
}
