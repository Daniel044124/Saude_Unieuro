<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;
use App\Lot;

class ItemsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Item::with(['lots' => function ($query) {
            $query->where('qtd', '>', 0);
        }])->paginate(15);
    }

    public function getAll()
    {
        try {
            return Item::with(['lots' => function ($query) {
                $query->where('qtd', '>', 0);
            }])->get();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'lot.qtd' => ['required'],
            'unit' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $item = new Item;
        $item->name = $request->input('name');
        $item->brand = $request->input('brand');
        $item->unit = $request->input('unit');

        $lot = new Lot;
        $lot->description = $request->input('lot.description');
        $lot->expiration = $request->input('lot.expiration');
        $lot->qtd = $request->input('lot.qtd');

        $item->save();
        $item->lots()->save($lot);
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(null, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'qtd' => ['required'],
            'unity' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $item = Item::find($id);
        $item->name = $request->input('name');
        $item->qtd = $request->input('qtd');
        $item->unity = $request->input('unity');
        $item->save();
        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return response()->json(null, 204);
    }

}
