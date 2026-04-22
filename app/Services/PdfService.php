<?php

namespace App\Services;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate the rental contract PDF and persist it.
     * Returns the relative storage path (e.g. "contracts/WDU-000001.pdf").
     */
    public function generateContract(Reservation $reservation): string
    {
        $reservation->loadMissing(['vehicle', 'user', 'zone']);

        $pdf = Pdf::loadView('pdf.contract', compact('reservation'))
            ->setPaper('a4', 'portrait');

        $filename = 'contracts/' . $reservation->reservation_number . '.pdf';
        Storage::put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Generate the payment receipt PDF and persist it.
     * Returns the relative storage path (e.g. "receipts/WDU-000001.pdf").
     */
    public function generateReceipt(Reservation $reservation): string
    {
        $reservation->loadMissing(['vehicle', 'user', 'zone']);

        $pdf = Pdf::loadView('pdf.receipt', compact('reservation'))
            ->setPaper([0, 0, 595, 842], 'portrait');  // A4

        $filename = 'receipts/' . $reservation->reservation_number . '.pdf';
        Storage::put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Generate both contract and receipt, update the reservation,
     * and return the paths.
     */
    public function generateAll(Reservation $reservation): array
    {
        $contractPath = $this->generateContract($reservation);
        $receiptPath  = $this->generateReceipt($reservation);

        $reservation->update([
            'contract_path' => $contractPath,
            'receipt_path'  => $receiptPath,
        ]);

        return compact('contractPath', 'receiptPath');
    }
}
