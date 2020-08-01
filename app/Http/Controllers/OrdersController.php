<?php

namespace App\Http\Controllers;

use App\Course;
use App\Item;
use App\Lab;
use App\Order;
use App\User;
use App\Lot;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        switch ($filter) {
            case 'dispatched':
            case 'created':
                return Order::where('dispatched', $filter)->with('items')->get();
            default:
                return Order::with('items')->get();
        }
    }

    /**
     * Return the order by id and the items and lots related.
     *
     * @param $id
     * @return mixed
     */
    public function getOrdersItemsLots($id)
    {
        return Order::with(['items.lots' => function ($query) {
            $query->where('qtd', '>', 0);
        }])->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'due_date' => ['required'],
                'due_time' => ['required'],
                'items' => ['required'],
                'items.*.id' => ['required'],
                'items.*.qtd' => ['required'],
                'lab_id' => ['required'],
                'course_id' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ], 400);
            }

            $checkAvailability = Order::where([
                ['lab_id', $request->input('lab_id')],
                ['due_date', new DateTime($request->input('due_date'))],
                ['due_time', $request->input('due_time')]
            ]);

            if ($checkAvailability->count() > 0) {
                return response()->json(['error' => 'Laboratório não disponível nesta data e horário.'], 400);
            }

            $order = new Order;
            $order->due_date = $request->input('due_date');
            $order->due_time = $request->input('due_time');

            $course = Course::find($request->input('course_id'));
            $lab = Lab::find($request->input('lab_id'));

            $order->course()->associate($course);
            $order->lab()->associate($lab);

            $user = User::find($request->input('user_id'));

            $user->orders()->save($order);

            $items = $request->input('items.*.id');
            $itemsQtd = $request->input('items.*.qtd');

            if (count($items) !== count($itemsQtd)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['É necessário definir quantidades para todos os itens selecionados.'],
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::with(['items', 'lab', 'course', 'user'])->find($id);
        return response()->json($order, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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
            $order = Order::findOrFail($id);
            $order->items()->sync($itemsFormatted);
            return response()->json($order->with(['items', 'courses', 'labs']), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => [$e->getMessage()],
            ], 400);
        }
    }

    /**
     * Set the 'dispatched' table field to true and subtract the lots quantities.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dispatchOrder(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            if ($order->dispatched) {
                throw new \Exception('O pedido já foi liberado.');
            }
            DB::beginTransaction();
            $order->dispatched = true;
            $lotsInformation = $request->input('lotsInformation');
            foreach ($lotsInformation as $lotInformation) {
                $lot = Lot::find($lotInformation['id']);
                if ($lot->qtd < $lotInformation['qtySubtracted']) {
                    throw new \Exception('A quantidade selecionada é maior do que a disponível.');
                }
                $lot->qtd -= $lotInformation['qtySubtracted'];
                $lot->save();
            }
            $order->save();
            DB::commit();
            return response()->json($order, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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
