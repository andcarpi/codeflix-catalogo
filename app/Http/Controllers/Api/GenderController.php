<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenderRequest;
use App\Models\Gender;
use Illuminate\Http\Response;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Gender[]|Response
     */
    public function index()
    {
        return Gender::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Gender|Response
     */
    public function store(GenderRequest $request)
    {
        return Gender::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return Gender|Response
     */
    public function show(Gender $gender)
    {
        return $gender;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return Gender|Response
     */
    public function update(GenderRequest $request, Gender $gender)
    {
        $gender->update($request->validated());
        return $gender;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gender  $gender
     * @return Response
     */
    public function destroy(Gender $gender)
    {
        $gender->delete();
        return response()->noContent();
    }
}
