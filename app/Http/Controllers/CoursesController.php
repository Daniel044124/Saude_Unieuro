<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return Course::all();
        } catch (\Exception $e) {
            $this->error($e);
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
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $course = new Course();
            $course->description = $request->input('description');
            $course->save();
            return response()->json($course, 201);
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
            return Course::find($id);
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
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->getMessageBag()->toArray()
                ], 400);
            }
            $course = Course::find($id);
            $course->description = $request->input('description');
            $course->save();
            return response()->json($course, 200);
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
            $course = Course::find($id);
            $course->delete();
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
