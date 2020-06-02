<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OperationType;
use App\Models\Order;
use App\Models\RealtyType;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function ordersList(Request $request, $page = 1) {
        $limit = $request->get('limit', 50);

        $categories = Category::all();
        $realty_types = RealtyType::all();
        $operation_types = OperationType::all();

        $orders = Order::select([
                'orders.*',
                'operation_types.name AS operation_type_name',
                'realty_types.name AS realty_type_name',
                'areas.name AS district_name',
                'areas.type_name AS district_type',

            ])
            ->leftJoin('operation_types', 'orders.advert_type_id', 'operation_types.ext_id')
            ->leftJoin('realty_types', 'orders.realty_type_id', 'realty_types.ext_id')
            ->leftJoin('areas', 'orders.district_id', 'areas.area_id')
            ->offset($limit * ($page - 1))
            ->limit($limit)
            ->orderBy('id', 'DESC')
            ->get()
        ;

        debug($orders->toArray());

        return view('orders.list', [
            'orders' => $orders,
            'realty_types' => $realty_types,
            'categories' => $categories,
            'operation_types' => $operation_types
        ]);
    }
}
