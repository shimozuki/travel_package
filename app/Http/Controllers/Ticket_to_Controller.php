<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class Ticket_to_Controller extends Controller
{
    public function index()
    {
        $tickets = Ticket::paginate(5);
        return view('admin.ticket.index', compact('tickets'));
    }

    public function create()
    {
        return view('admin.ticket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'port_from_id' => 'required',
            'port_to_id' => 'required',
            'departure_date' => 'required',
            'price' => 'required',
        ]);

        Ticket::create($request->all());
        return redirect()->route('admin.tickets.index')->with([
            'message' => 'Success Created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.ticket.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'port_from_id' => 'required',
            'port_to_id' => 'required',
            'departure_date' => 'required',
            'price' => 'required',
        ]);

        $ticket->update($request->all());
        return redirect()->route('admin.tickets.index')->with([
            'message' => 'Success Update !',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus!');
    }
}
