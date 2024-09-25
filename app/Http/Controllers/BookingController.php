<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'nomor_identitas' => 'required',
                'travel_package_id' => 'required|exists:travel_packages,id',
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
            $booking->travel_package_id = $validatedData['travel_package_id'];
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
            if ($request->has('pemesan_name')) {
                foreach ($request->input('pemesan_name') as $key => $name) {
                    $penumpang = new Booking();
                    $penumpang->nomor_identitas = $request->input('pemesan_nomor_passport')[$key];
                    $penumpang->travel_package_id = $validatedData['travel_package_id'];
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

            return response()->json(['message' => 'Booking berhasil dibuat!', 'booking' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 200);
        }
    }

    public function verify($id)
    {
        $bookings = Booking::where('kode_booking', $id)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
        }

        $bookings->each(function ($booking) {
            $booking->status = 1;
            $booking->save();
        });

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil diverifikasi.']);
    }
}
