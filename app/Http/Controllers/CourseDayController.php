<?php

namespace App\Http\Controllers;

use App\Models\CourseDay;
use App\Helpers\Utilities;
use App\Http\Requests\CourseDay\Create;
use App\Http\Requests\CourseDay\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\CourseDayRepository;
use Symfony\Component\HttpFoundation\Response;

class CourseDayController extends Controller
{
    private $CourseDayRepo;
    public function __construct(CourseDayRepository $CourseDayRepo)
    {
        $this->CourseDayRepo = $CourseDayRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CourseDayRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym CourseDays.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymCourseDayes(Pagination $request)
    {
        $request->validated();
        return $this->CourseDayRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $CourseDay = $request->validated();
        $CourseDay['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->CourseDayRepo->create($CourseDay);
        return response()->json([
            'success' => true,
            'message' => 'Course and Day created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseDay  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CourseDayRepo->show($id)->muscles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseDay  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $CourseDay = $request->validated();
        $this->CourseDayRepo->update($id, $CourseDay);
        return response()->json([
            'success' => true,
            'message' => 'Course and Day updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseDay  $CourseDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseDay $day)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->CourseDayRepo->delete($day);
        return response()->json([
            'success' => true,
            'message' => 'Course and Day deleted successfully',
        ], Response::HTTP_OK);
    }
}
