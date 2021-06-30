<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return Order::where('user_id', auth()->user()['id'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $order = Order::create([
                'total' => $request['total'],
                'user_id' => auth()->user()['id'],
            ]);

            $order_products = $request['order_products'];

            foreach ($order_products as $order_product) {
                $order_product['order_id'] = $order->id;
                OrderProduct::create($order_product);
            }

            DB::commit();
            return ['message'=> 'order Placed'];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['message'=> 'failed'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::where('user_id', auth()->user()['id'])
            ->where('id', $id)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
