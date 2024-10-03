<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Str;
use App\Models\Booking;

class list_ticket_controller extends Controller
{
    public function index(Request $request)
    {
        // Get the input values from the modal
        $from = $request->input('from');
        $to = $request->input('to');
        $departure_date = $request->input('departure_date');
        $return_date = $request->input('return_date');

        // Validate the input values
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        // Query the database to search for tickets
        $tickets = Ticket::where('port_from_id', $from)
            ->where('port_to_id', $to)
            ->where('departure_date', $departure_date);

        if ($return_date) {
            $tickets->where('return_date', $return_date);
        }

        $tickets = $tickets->get();

        // Return the search results
        return view('listtikett', compact('tickets'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'nomor_identitas' => 'required',
                'ticket_id' => 'required',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'number_phone' => 'required|string|max:20',
                'date' => 'required|date',
                'proofOfPayment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alamat' => 'required'
            ]);

            $timestamp = time();
            $randomString = Str::random(5);
            $kodeBooking = "BK-" . $timestamp . "-" . $randomString;
            // Simpan data booking
            $booking = new Booking();
            $booking->nomor_identitas = $validatedData['nomor_identitas'];
            $booking->ticket_id = $validatedData['ticket_id'];
            $booking->name = $validatedData['name'];
            $booking->email = $validatedData['email'];
            $booking->number_phone = $validatedData['number_phone'];
            $booking->date = $validatedData['date'];
            $booking->alamat = $validatedData['alamat'];
            $timestamp = time();
            $randomString = Str::random(5);
            $booking->kode_booking = "BK-" . $timestamp . "-" . $randomString;
            $booking->status = 0;

            // Handle Upload
            if ($request->hasFile('proofOfPayment')) {
                $file = $request->file('proofOfPayment');
                $filename = time() . '_' . "bukti";
                $file->storeAs('uploads', $filename, 'public');
                $booking->bukti = 'uploads/' . $filename;
            }

            $booking->id_user = auth()->id();
            $booking->save();

            // Simpan data penumpang
            // Simpan data penumpang
            if ($request->has('penumpang_name')) {
                foreach ($request->input('penumpang_name') as $key => $name) {
                    $penumpang = new Booking();
                    $penumpang->nomor_identitas = $request->input('penumpang_nomor_identitas')[$key];
                    $penumpang->ticket_id = $validatedData['ticket_id'];
                    $penumpang->name = $name;
                    $penumpang->email = $validatedData['email'];
                    $penumpang->number_phone = $validatedData['number_phone'];
                    $penumpang->date = $validatedData['date'];
                    $penumpang->alamat = $validatedData['alamat'];
                    $penumpang->kode_booking = $booking->kode_booking;
                    $penumpang->status = 0;
                    $penumpang->id_user = auth()->id();
                    $penumpang->save();
                }
            }
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat!');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 200);
        }
    }
}
