<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener los eventos
        $events = Event::paginate(10); // O la lógica que necesites

        // Retornar la vista pasando la variable $events
        return view('home', compact('events'));
    }
}
