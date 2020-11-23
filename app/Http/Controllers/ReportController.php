<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function itemsByClassrooms(Request $request)
    {
        $fields = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'classroom' => 'required',
        ]);

        $orders = Order::with(['items', 'subject.classroom' => function ($query) use ($fields) {
            $query->where('id', $fields['classroom']);
        }])
            ->where('created_at', '>=', $fields['start_date'])
            ->where('created_at', '<=', $fields['end_date'])
//            ->where('dispatched', 'dispatched')
            ->get();

        $items = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if (key_exists($item->id, $items)) {
                    $items[$item->id]['qtd'] += $item->pivot->qtd;
                    continue;
                }
                $items[$item->id] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'brand' => $item->brand,
                    'unit' => $item->unit,
                    'qtd' => $item->pivot->qtd,
                ];
            }
        }

        return response()->json(collect($items)->values()->all(), 200);
    }
}
