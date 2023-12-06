<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
{
    public function collection()
    {
        // Retrieve sales data based on your logic
        $salesData = Order::where('status', 'delivered')->get();

        // Format the data for export
        $exportData = collect([
            ['Order ID', 'Customer Name', 'Total', 'Created At'],
        ]);

        foreach ($salesData as $order) {
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
