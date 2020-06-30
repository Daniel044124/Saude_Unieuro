<?php

namespace App\Http\Controllers;

use App\Item;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::with('items')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(null, 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'items' => ['required'],
            'items.*.id' => ['required'],
            'items.*.qtd' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $order = new Order;
        $user = User::find($request->input('user_id'));

        $user->orders()->save($order);

        $items = $request->input('items.*.id');
        $itemsQtd = $request->input('items.*.qtd');

        if (count($items) !== count($itemsQtd)) {
            return response()->json([
                'success' => false,
                'errors' => ['É necessário definir quantidades para todos os itens.'],
            ], 400);
        }

        /**
         * Para cada item da lista, adicionar a relação da tabela 'pivot',
         * junto com a quantidade solicitada.
         */
        for ($i = 0; $i < count($items); $i++) {
            $order->items()->attach($items[$i], ['qtd' => $itemsQtd[$i]]);
        }
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('items')->find($id);
        return response()->json($order, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(null, 404);
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
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'items' => ['required'],
            'items.*.id' => ['required'],
            'items.*.qtd' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $items = $request->input('items');
        $itemsFormatted = [];
        foreach ($items as $item) {
            $itemsFormatted[$item['id']] = ['qtd' => $item['qtd']];
        }

        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $order->items()->detach();
            $order->items()->attach($itemsFormatted);
            $order->save();
            DB::commit();
            $order->items;
            return response()->json($order, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::find($id);
            DB::beginTransaction();
            $order->items()->detach();
            $order->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 400);
        }
    }
}
