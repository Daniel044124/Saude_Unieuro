<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Lot;
use App\Item;

class LotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Lot[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return Lot::all();
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Return all lots for a given Item ID.
     *
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByItems($itemId) {
        try {
            return Lot::where('item_id', $itemId)->get();
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'description' => ['required'],
                'expiration' => ['nullable', 'after_or_equal:today'],
                'qtd' => ['required'],
                'item_id' => ['required']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $lot = new Lot;
            $lot->description = $request->input('description');
            $lot->expiration = $request->input('expiration');
            $lot->qtd = $request->input('qtd');
            $item = Item::find($request->input('item_id'));
            $item->lots()->save($lot);
            return response()->json($lot, 201);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            return Lot::find($id);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'description' => ['required'],
                'expiration' => ['nullable', 'after_or_equal:today'],
                'qtd' => ['required'],
                'item_id' => ['required']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $lot = Lot::find($id);
            $lot->description = $request->input('description');
            $lot->expiration = $request->input('expiration');
            $lot->qtd = $request->input('qtd');
            $lot->save();
            return response()->json($lot, 200);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $lot = Lot::find($id);
            $lot->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    private function error(\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
