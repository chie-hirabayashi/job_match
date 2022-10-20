<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Occupation;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $occupations = Occupation::all();
        return view('job_offers.create')->with(compact('occupations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function show(JobOffer $job_offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOffer $job_offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOffer $job_offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $job_offer)
    {
        //
    }
}
