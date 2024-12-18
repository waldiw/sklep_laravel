<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class CsfController extends Controller
{
    public function exportCSV()
    {
        $filename = 'zamówienia.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, [
                iconv( "UTF-8", "Windows-1250", 'Nr zamówienia' ),
                iconv( "UTF-8", "Windows-1250", 'Nazwa' ),
                iconv( "UTF-8", "Windows-1250", 'Adres' ),
                iconv( "UTF-8", "Windows-1250", 'E-mail' ),
                iconv( "UTF-8", "Windows-1250", 'Telefon' ),
                iconv( "UTF-8", "Windows-1250", 'Status' ),
                iconv( "UTF-8", "Windows-1250", 'Wartość' ),
                iconv( "UTF-8", "Windows-1250", 'Wysyłka' ),
                iconv( "UTF-8", "Windows-1250", 'Data' ),
            ], ';');
            //iconv( "UTF-8", "Windows-1250", $order->adress )
            // Fetch and process data in chunks
            Orders::chunk(25, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    //$totalOrder = numberFormat(totalOrder($order->carts));
                    // Extract data from each employee.
                    $data = [
                        isset($order->id)? iconv( "UTF-8", "Windows-1250", $order->id ) : '',
                        isset($order->name)? iconv( "UTF-8", "Windows-1250", $order->name ) : '',
                        isset($order->adress)? iconv( "UTF-8", "Windows-1250", $order->adress ) : '',
                        isset($order->email)? iconv( "UTF-8", "Windows-1250", $order->email ) : '',
                        isset($order->phone)? iconv( "UTF-8", "Windows-1250", $order->phone ) : '',
                        isset($order->status)? iconv( "UTF-8", "Windows-1250", $order->status ) : '',
                        numberFormat(totalOrder($order->carts)),
                        numberFormat($order->shipping->shipping),
                        isset($order->created_at)? iconv( "UTF-8", "Windows-1250", $order->created_at ) : ''
                    ];

                    // Write data to a CSV file.
                    fputcsv($handle, $data, ';');
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }

    public function exportAllCSV()
    {
        $filename = 'zamówienia_szczegóły.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, [
                iconv( "UTF-8", "Windows-1250", 'Nr zamówienia' ),
                iconv( "UTF-8", "Windows-1250", 'Nazwa' ),
                iconv( "UTF-8", "Windows-1250", 'Adres' ),
                iconv( "UTF-8", "Windows-1250", 'E-mail' ),
                iconv( "UTF-8", "Windows-1250", 'Telefon' ),
                iconv( "UTF-8", "Windows-1250", 'Status' ),
                iconv( "UTF-8", "Windows-1250", 'Towar' ),
                iconv( "UTF-8", "Windows-1250", 'Ilość' ),
                iconv( "UTF-8", "Windows-1250", 'Cena' ),
                iconv( "UTF-8", "Windows-1250", 'Data' ),
            ], ';');
            //iconv( "UTF-8", "Windows-1250", $order->adress )
            // Fetch and process data in chunks
            Orders::chunk(25, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    // Extract data from each employee.
                    foreach ($order->carts as $item) {
                        $data = [
                            isset($order->id)? iconv( "UTF-8", "Windows-1250", $order->id ) : '',
                            isset($order->name)? iconv( "UTF-8", "Windows-1250", $order->name ) : '',
                            isset($order->adress)? iconv( "UTF-8", "Windows-1250", $order->adress ) : '',
                            isset($order->email)? iconv( "UTF-8", "Windows-1250", $order->email ) : '',
                            isset($order->phone)? iconv( "UTF-8", "Windows-1250", $order->phone ) : '',
                            isset($order->status)? iconv( "UTF-8", "Windows-1250", $order->status ) : '',
                            isset($item->name)? iconv( "UTF-8", "Windows-1250", $item->name ) : '',
                            isset($item->quantity)? iconv( "UTF-8", "Windows-1250", $item->quantity ) : '',
                            isset($item->price)? iconv( "UTF-8", "Windows-1250", numberFormat($item->price )) : '',
                            isset($order->created_at)? iconv( "UTF-8", "Windows-1250", $order->created_at ) : ''
                        ];
                        // Write data to a CSV file.
                        fputcsv($handle, $data, ';');
                    }
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);

    }
}
