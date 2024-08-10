<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'travel_package_id' => 'required|exists:travel_packages,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'number_phone' => 'required|string|max:20',
                'date' => 'required|date',
                'proofOfPayment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Simpan data booking
            $booking = new Booking();
            $booking->travel_package_id = $validatedData['travel_package_id'];
            $booking->name = $validatedData['name'];
            $booking->email = $validatedData['email'];
            $booking->number_phone = $validatedData['number_phone'];
            $booking->date = $validatedData['date'];
            $booking->status = 0;

            // Handle Upload
            if ($request->hasFile('proofOfPayment')) {
                $file = $request->file('proofOfPayment');
                $filename = time() . '_' . "bukti";
                $file->storeAs('uploads', $filename, 'public');
                $booking->bukti = 'uploads/' . $filename; // Simpan path file ke dalam database
            }

            $booking->id_user = auth()->id(); // Menyimpan ID pengguna yang sedang login
            $booking->save();

            return response()->json(['message' => 'Booking berhasil dibuat!', 'booking' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 200); // Menyediakan detail kesalahan
        }
    }

    public function verify($id)
    {
        $booking = Booking::findOrFail($id);

        // Verifikasi pembayaran lain jika diperlukan
        $booking->status = 1; // Set status menjadi 1 (Lunas)
        $booking->save();

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil diverifikasi.']);
    }
}
