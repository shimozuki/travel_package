<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class LoketController extends Controller
{
    public function index()
    {
        return view('admin.cekin.index');
    }

    public function searchTicket(Request $request)
    {
        $codeBooking = $request->input('code_booking');
        // Query your database to find the ticket based on the code booking
        $ticket = Booking::with('travel_package', 'ticket')->where('kode_booking', $codeBooking)->where('status', 1)->get();
        if ($ticket) {
            return response()->json(['success' => true, 'ticket' => $ticket]);
        } else {
            return response()->json(['success' => false, 'message' => 'Ticket not found']);
        }
    }

    public function boardingpass(Request $request)
    {
        $id = $request->id;
        $ticket = Booking::with('travel_package', 'ticket')->find($id);
        return view('admin.cekin.boardingpass', compact('ticket'));
    }
}
