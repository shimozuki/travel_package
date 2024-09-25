<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Pastikan Anda memiliki model Ticket
use PDF; // Buat alias untuk DomPDF
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Carbon\Carbon;


class TicketController extends Controller
{



    public function index($id)
    {
        $tickets = Booking::with('travel_package')->findOrFail($id);
        $kode_booking = $tickets->kode_booking;
        $penumpang = Booking::where('kode_booking', $kode_booking)->get();

        $date = Carbon::parse($tickets->date);

        $tickets->date = $date->locale('id')->translatedFormat('D, d M Y');

        $endDate = $date->copy()->addWeek();
        $formattedEndDate = $endDate->locale('id')->translatedFormat('D, d M Y');

        $tickets->end_date = $formattedEndDate;

        $qrCode = new QrCode($kode_booking);
        $qrCode->setSize(150);
        $qrCode->setMargin(10); // Use setMargin() instead of setPadding()
        $foregroundColor = new Color(0, 0, 0);
        $qrCode->setForegroundColor($foregroundColor);
        $backgroundColor = new Color(255, 255, 255);
        $qrCode->setBackgroundColor($backgroundColor);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $result->saveToFile(public_path('qrcode.png'));

        $qrCodeUrl = asset('qrcode.png');

        return view('tickets.template', compact('tickets', 'penumpang', 'qrCodeUrl'));
    }
}
