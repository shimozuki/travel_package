<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Mendapatkan pengguna yang sedang login

        if ($user->is_admin == 1) {
            // Jika pengguna adalah admin, ambil semua booking
            $bookings = Booking::with('travel_package', 'ticket')
            ->paginate(10);
        } else {
            // Jika pengguna bukan admin, ambil booking berdasarkan id_user
            $bookings = Booking::where('id_user', $user->id)
            ->with('travel_package', 'ticket')
            ->paginate(10);
        }

        return view('admin.bookings.index', compact('bookings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function verify($id)
    {
        $booking = Booking::findOrFail($id);

        // Verifikasi pembayaran lain jika diperlukan
        $booking->status = 1; // Set status menjadi 1 (Lunas)
        $booking->save();

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil diverifikasi.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->back()->with([
            'message' => 'success deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
