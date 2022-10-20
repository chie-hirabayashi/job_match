<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\JobOfferView;
use App\Models\Occupation;
use Illuminate\Http\Request;
use App\Http\Requests\JobOfferRequest;
use Illuminate\Support\Facades\Auth;

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
     * @param  \App\Http\Requests\JobOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobOfferRequest $request)
    {
        $job_offer = new JobOffer($request->all());
        $job_offer->company_id = $request->user()->company->id;

        try {
            // 登録
            $job_offer->save();
        } catch (\Exception $e) {
            // logger($e); // storage>logs>laravel.logにエラー登録
            return back()->withInput()
                ->withErrors('求人情報登録処理でエラーが発生しました');
        }

        return redirect()
            ->route('job_offers.show', $job_offer)
            ->with('notice', '求人情報を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function show(JobOffer $job_offer)
    {
        JobOfferView::updateOrCreate([
            'job_offer_id' => $job_offer->id,
            'user_id' => Auth::user()->id,
        ]);
        return view('job_offers.show')->with(compact('job_offer'));
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
     * @param  \App\Http\Requests\JobOfferRequest  $request
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function update(jobOfferRequest $request, JobOffer $job_offer)
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
