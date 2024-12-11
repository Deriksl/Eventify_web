<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        if ($payload['type'] === 'payment_intent.succeeded') {
            $paymentIntent = $payload['data']['object'];
            $metadata = $paymentIntent['metadata'];

            // Guarda el ticket en la base de datos
            Ticket::create([
                'price' => $paymentIntent['amount'] / 100,
                'purchase_date' => now(),
                'ticket_code' => uniqid(),
                'status' => 'valid',
                'user_id' => $metadata['user_id'],
                'event_id' => $metadata['event_id'],
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
