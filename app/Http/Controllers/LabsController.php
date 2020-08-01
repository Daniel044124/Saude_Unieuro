<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lab;
use Illuminate\Support\Facades\Validator;

class LabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Lab[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return Lab::all();
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
                'comment' => ['nullable']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $lab = new Lab;
            $lab->description = $request->input('description');
            $lab->comment = $request->input('comment');
            $lab->save();
            return response()->json($lab, 201);
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
            return Lab::find($id);
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
                'comment' => ['nullable']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $lab = Lab::find($id);
            $lab->description = $request->input('description');
            $lab->comment = $request->input('comment');
            $lab->save();
            return response()->json($lab, 200);
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
            $lab = Lab::find($id);
            $lab->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

    private function error(\Exception $e)
    {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
