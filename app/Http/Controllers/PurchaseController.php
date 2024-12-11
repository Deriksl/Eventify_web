<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Event;

class PurchaseController extends Controller
{
    public function purchaseTicket(Request $request, Event $event)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Incluye el event_id en la URL de éxito y cancel
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $event->name,
                        'description' => $event->description,
                    ],
                    'unit_amount' => $event->ticket_price * 100, // Convertir a centavos
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['event_id' => $event->id]), // Pasar event_id
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }


    public function success(Request $request)
    {
        // Obtener el event_id de la URL
        $event = Event::find($request->event_id);

        if (!$event) {
            return redirect()->route('payment.cancel')->with('error', 'Event not found');
        }

        // Si el precio del evento es nulo, asignamos un valor predeterminado (por ejemplo, 0)
        $ticketPrice = $event->ticket_price ?? 0; // Si es nulo, asignamos 0

        // Registrar el ticket tras el pago
        Ticket::create([
            'price' => $ticketPrice,  // Usamos el precio del evento o 0 si es nulo
            'purchase_date' => now(),
            'ticket_code' => uniqid('TICKET_'),
            'status' => Ticket::STATUS_VALID,
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return view('payment.success');
    }





    public function cancel()
    {
        return view('payment.cancel');
    }
}
