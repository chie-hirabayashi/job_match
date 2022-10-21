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
    public function index(Request $request)
    {
        // クエリパラメータ(urlパラメータとも言う。urlに?で入ってくる検索条件など)取得
        $params = $request->query();
        $job_offers = JobOffer::search($params)
            ->with(['company', 'occupation'])
            ->published()
            // ->latest()
            ->order($params)
            ->paginate(5);
        $job_offers->appends($params);
        $occupations = Occupation::all();

        return view('job_offers.index')->with(compact('job_offers', 'occupations', 'params'));
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
        $occupations = Occupation::all();
        return view('job_offers.edit')
            ->with(compact('job_offer', 'occupations'));
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
        if (Auth::user()->cannot('update', $job_offer)) {
            return redirect()->route('job_offers.show', $job_offer)
                ->withErrors('自分の求人情報以外は更新できません');
        }
        $job_offer->fill($request->all());
        try {
            $job_offer->save();
        } catch (\Exception $e) {
            logger($e);
            return back()->withInput()
                ->withErrors('求人情報更新処理でエラーが発生しました');
        }
        return redirect()->route('job_offers.show', $job_offer)
            ->with('notice', '求人情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $job_offer)
    {
        if (Auth::user()->cannot('delete', $job_offer)) {
            return redirect()->route('job_offers.show', $job_offer)
                ->withErrors('自分の求人情報以外は削除できません');
        }

        try {
            $job_offer->delete();
        } catch (\Exception $e) {
            logger($e);
            return back()->withInput()
                ->withErrors('求人情報削除処理でエラーが発生しました');
        }

        return redirect()->route('job_offers.index')
            ->with('notice', '求人情報を削除しました');
    }
}
