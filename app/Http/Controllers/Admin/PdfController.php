<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('can:isAdministrator');
    }
    public function generatePdf(string $id)
    {
        $order = Orders::findOrFail($id);
        $totalOrder = totalOrder($order->carts);

        $data = [
            'totalOrder' => $totalOrder,
            'order' => $order
        ];

        $pdf = Pdf::loadView('pdf.generate-pdf', $data);
        return $pdf->download('zamówienie' . $id . '.pdf');
    }
}
