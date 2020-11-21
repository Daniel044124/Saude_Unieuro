<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Requests\StoreSubject;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Subject::with('classroom')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSubject $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSubject $request)
    {
        $data = $request->validated();
        $subject = new Subject();
        $subject->fill($data);
        $classroom = Classroom::find($data['classroom']);
        $subject->classroom()->associate($classroom);
        $subject->save();
        return response()->json($subject, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Subject $subject)
    {
        return response()->json($subject, 200);
    }

    public function getSubjectsByClass(Classroom $classroom)
    {
        return $classroom->subjects;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreSubject $request
     * @param \App\Subject $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreSubject $request, Subject $subject)
    {
        $data = $request->validated();
        $subject->fill($data);
        $classroom = Classroom::find($data['classroom']);
        $subject->classroom()->associate($classroom);
        $subject->save();
        return response()->json($subject, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return response()->json([], 204);
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }
}
