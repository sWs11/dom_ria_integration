<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OperationType;
use App\Models\Order;
use App\Models\RealtyType;
//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function ordersList(Request $request, $page = 1) {
        $limit = $request->get('limit', 50);

        $categories = Category::all();
        $realty_types = RealtyType::all();
        $operation_types = OperationType::all();


        $orders_query = Order::select([
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
        ;

//        dd(get_class($orders_query));

        if(!empty($request->query())){
            $this->buildFilterQuery($request->query(), $orders_query);
        }

        $orders = $orders_query->get();

        debug($orders->toArray());

        return view('orders.list', [
            'orders' => $orders,
            'realty_types' => $realty_types,
            'categories' => $categories,
            'operation_types' => $operation_types
        ]);
    }

    private function buildFilterQuery(array $filter_params, Builder $query) {
        $available_filter_fields = [
            'realty_type_id' => 'orders.realty_type_id',
            'advert_type_id' => 'orders.advert_type_id',
        ];

        foreach ($filter_params as $key => $value) {
            if(array_key_exists($key, $available_filter_fields)) {
                $query->where($available_filter_fields[$key], $value);
            }
        }
    }
}
