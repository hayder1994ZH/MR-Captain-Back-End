<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;
use App\Http\Requests\Music\Create;
use App\Http\Requests\Music\Update;
use App\Repositories\MusicRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class MusicController extends Controller
{
    private $MusicRepo;
    public function __construct(MusicRepository $MusicRepo)
    {
        $this->MusicRepo = $MusicRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->MusicRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $music = $request->validated();
        if($request->hasFile('image')){
            $music['image'] = $request->file('image')->store('music-image');
        }
        if($request->hasFile('music')){
            $music['music'] = $request->file('music')->store('musics');
        }
        $response = $this->MusicRepo->create($music);
        return response()->json([
            'success' => true,
            'message' => 'Music created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Music  $Music
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->MusicRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Music  $Music
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $music = $request->validated();
        if($request->hasFile('image')){
            $music['image'] = $request->file('image')->store('music-image');
        }
        if($request->hasFile('music')){
            $music['music'] = $request->file('music')->store('musics');
        }
        $this->MusicRepo->update($id, $music);
        return response()->json([
            'success' => true,
            'message' => 'Music updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Music  $Music
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        $this->MusicRepo->delete($music);
        return response()->json([
            'success' => true,
            'message' => 'Music deleted successfully',
        ], Response::HTTP_OK);
    }
}
