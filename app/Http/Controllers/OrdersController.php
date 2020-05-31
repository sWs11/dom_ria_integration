<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function ordersList(Request $request, $page = 1) {
        $limit = $request->get('limit', 50);

        $orders = Order::select('*')
            ->offset($limit*$page)
            ->limit($limit)
            ->get()
        ;

        debug($orders->toArray());

        return view('orders.list', ['orders' => $orders]);
    }
}
