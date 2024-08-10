<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Pastikan Anda memiliki model Ticket
use PDF; // Buat alias untuk DomPDF
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeEnlarge;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;


class TicketController extends Controller
{

    public function index($id)
    {
        $ticket = Booking::with('travel_package')->findOrFail($id);
    
        // Convert the date from a string to a Carbon instance
        $date = Carbon::parse($ticket->date); // Ensure $ticket->date is in a standard format, e.g., 'Y-m-d H:i:s'
    
        // Format the date for display
        $ticket->date = $date->locale('id')->translatedFormat('D, d M Y');
    
        // Calculate end date (one week later) and format it for display
        $endDate = $date->copy()->addWeek();
        $formattedEndDate = $endDate->locale('id')->translatedFormat('D, d M Y');
    
        // Add the formatted end date to the ticket
        $ticket->end_date = $formattedEndDate;
    
        return view('tickets.template', compact('ticket'));
    }


    public function download($id)
    {
        $ticket = Booking::with('travel_package')->findOrFail($id);

        // Pastikan QR Code di-set sebelumnya
        if (is_null($ticket->qrCode)) {
            // Mengatur nilai default misalnya ID tiket atau informasi unik lainnya sebagai QR Code
            $ticket->qrCode = 'ticket-' . $ticket->id;
        }

        // atau sesuaikan dengan cara Anda mengambil order

        // Generate QR code
        try {
            // Use the PngWriter to create a QR Code image
            $qrCode = QrCode::create($ticket->qrCode)
                ->setSize(300)
                ->setMargin(10);

            $writer = new PngWriter();
            $qrCodeImg = $writer->write($qrCode)->getString(); // Get the PNG image as a string
        } catch (\Exception $e) {
            // Tangani error jika ada
            return response()->json(['error' => 'Tidak dapat menghasilkan QR Code: ' . $e->getMessage()], 500);
        }

        // Encode the QR code image to base64
        $qrCodeImgBase64 = base64_encode($qrCodeImg);

        // Simpan QR code ke dalam data tiket
        $ticket->qrCode = 'data:image/png;base64,' . $qrCodeImgBase64;

        $pdf = PDF::loadView('tickets.template', compact('ticket')); // Galeri tiket Anda
        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }
}
