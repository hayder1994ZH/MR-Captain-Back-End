<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\Course\Create;
use App\Http\Requests\Course\Update;
use App\Repositories\CourseRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    private $CourseRepo;
    public function __construct(CourseRepository $CourseRepo)
    {
        $this->CourseRepo = $CourseRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CourseRepo->getList($request->take, $request->player_id);
    }

    /**
     * Display a listing of my gym courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymCourses(Pagination $request)
    {
        $request->validated();
        return $this->CourseRepo->getListMyGym($request->take);
    }

    /**
     * Display a listing of my gym courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyCourses(Pagination $request)
    {
        $request->validated();
        return $this->CourseRepo->myCourse($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $course = $request->validated();
        $course['captain_id'] = auth()->user()->id;
        $course['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->CourseRepo->create($course);
        return response()->json([
            'success' => true,
            'message' => 'course created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $debt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CourseRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $course = $request->validated();
        $this->CourseRepo->update($id, $course);
        return response()->json([
            'success' => true,
            'message' => 'course updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $debt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $this->CourseRepo->delete($course);
        return response()->json([
            'success' => true,
            'message' => 'course deleted successfully',
        ], Response::HTTP_OK);
    }
}
