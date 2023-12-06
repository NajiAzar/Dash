<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CancelledordersExport implements FromCollection
{
    public function collection()
    {
        // Retrieve sales data based on your logic
        $cancelledordersData = Order::where('status', 'cancelled')->get();

        // Format the data for export
        $exportData = collect([
            ['Order ID', 'Customer Name', 'Total', 'Created At'],
        ]);

        foreach ($cancelledordersData as $order) {
            $exportData->push([
                $order->id,
                $order->shippingAddress->first_name . ' ' . $order->shippingAddress->last_name,
                $order->total,
                $order->created_at,
            ]);
        }

        return $exportData;
    }
}
