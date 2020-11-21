<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Course;
use App\Http\Requests\StoreClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return Classroom::with('course')->get();
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClass $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClass $request)
    {
        $data = $request->validated();
        $classRoom = new Classroom();
        $classRoom->fill($data);
        $course = Course::find($data['course']);
        $classRoom->course()->associate($course);
        $classRoom->save();
        return response()->json($classRoom, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Classroom $classroom
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Classroom $classroom)
    {
        return response()->json($classroom, 200);
    }

    public function getClassesByCourse(Course $course)
    {
        return $course->classes;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreClass $request
     * @param Classroom $classroom
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreClass $request, Classroom $classroom)
    {
        $data = $request->validated();
        $classroom->fill($data);
        $course = Course::find($data['course']);
        $classroom->course()->associate($course);
        $classroom->save();
        return response()->json($classroom, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Classroom $classroom
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Classroom $classroom)
    {
        try {
            print $classroom->delete();
            return response()->json([], 200);
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }
}
