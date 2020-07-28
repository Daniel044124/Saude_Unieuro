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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
            'brand' => ['required'],
            'lot.description' => ['required'],
            'lot.expiration' => ['required'],
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
        $item->formula = $request->input('formula');
        $item->molecular_weight = $request->input('molecular_weight');
        $item->concentration = $request->input('concentration');

        $lot = new Lot;
        $lot->description = $request->input('lot.description');
        $lot->expiration = $request->input('lot.expiration');
        $lot->qtd = $request->input('lot.qtd');
        $lot->open = $request->input('lot.open');

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
     * Display the item and the lots related.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getItemLots($id)
    {
        return Item::with('lots')->find($id);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'unit' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ], 400);
            }

            $item = Item::find($id);
            $item->name = $request->input('name');
            $item->unit = $request->input('unit');
            $item->formula = $request->input('formula');
            $item->molecular_weight = $request->input('molecular_weight');
            $item->concentration = $request->input('concentration');
            $item->save();
            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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
        $item = Item::find($id);
        $item->delete();
        return response()->json(null, 204);
    }

}
