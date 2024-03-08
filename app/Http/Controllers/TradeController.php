<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInfo;
use App\Models\Series;
use App\Models\Trade;
use App\Models\Picture;
use Carbon\Carbon;


class TradeController extends Controller
{
    public function index()
    {
        return view('trades.index')->with([
            'trades' => Trade::with([
                            'user',
                            'methods',
                            'pictures' => [
                                'series',
                                'member',
                                'type'
                            ]
                        ])->orderBy('updated_at', 'DESC')->paginate(10),
        ]);
    }
    
    public function show(Trade $trade)
    {
        return view('trades.show')->with([
            'trade' => $trade,
            'offers_divided_by_series' => $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 0)->get()->groupBy('series_id'),
            'requests_divided_by_series' => $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 1)->get()->groupBy('series_id'),
        ]);
    }
    
    public function create()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        return view('trades.create')->with([
            'collection_of_eventinfo' => EventInfo::with('event')->whereDate('date', '>=', $today)->get(),
            'series_with_pictures' => Series::has('pictures')->with(['pictures' => ['member', 'type']])->get(),
            'php_series_with_pictures' => json_encode(Series::has('pictures')->get()->pluck('id')->all() ),
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'methods' => ['required'],
            'offers' => ['required'],
            'requests' => ['required'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);
        
        $trade = Trade::create([
            'user_id' => auth()->user()->id,
            'note' => $request->note,
        ]);
        
        //method_tradeテーブルへの保存処理
        foreach($request->methods as $value){
            if($value == 0){
                $trade->methods()->attach(1);
            }else{
                $trade->methods()->attach(2, ['event_info_id' => $value]);
            }
        }
        
        //picture_tradeテーブルへの保存処理
        $offer_pictures = array_unique(array_reduce($request->offers, 'array_merge', []));
        $request_pictures = array_unique(array_reduce($request->requests, 'array_merge', []));
        
        sort($offer_pictures);
        sort($request_pictures);
        
        $trade->pictures()->attach($offer_pictures, ['kind' => 0]);
        $trade->pictures()->attach($request_pictures, ['kind' => 1]);
        
        //リダイレクト
        return redirect('/trades/' . $trade->id);
    }
    
    public function edit(Trade $trade)
    {
        //今日の日付を取得
        $today = Carbon::today()->format('Y-m-d');
        
        //$selected_methodsの定義
        $selected_methods = array();
        foreach($trade->methods as $method){
            if($method->id == 1){
                array_push($selected_methods, 0);
            } else {
                array_push($selected_methods, $method->pivot->event_info_id);
            }
        }
        
        //$selected_offer_seriesの定義
        $selected_offers_divided_by_series = $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 0)->get()->groupBy('series_id');
        $selected_offer_series_ids = $selected_offers_divided_by_series->keys()->all();
        $selected_offer_series = array();
        for($i = 0; $i < count($selected_offer_series_ids); $i++){
            $selected_offer_series['location-' . $i] = $selected_offer_series_ids[$i];
        }
        for($i = count($selected_offer_series_ids); $i < 5; $i++){
            $selected_offer_series['location-' . $i] = null;
        }
        
        //$selected_request_seriesの定義
        $selected_requests_divided_by_series = $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 1)->get()->groupBy('series_id');
        $selected_request_series_ids = $selected_requests_divided_by_series->keys()->all();
        $selected_request_series = array();
        for($i = 0; $i < count($selected_request_series_ids); $i++){
            $selected_request_series['location-' . $i] = $selected_request_series_ids[$i];
        }
        for($i = count($selected_request_series_ids); $i < 5; $i++){
            $selected_request_series['location-' . $i] = null;
        }
        
        //$selected_offersの定義
        $selected_offers = array();
        $x = $selected_offers_divided_by_series->values()->all();
        for($i = 0; $i < count($x); $i++){
            $selected_offers['location-' . $i] = array();
            foreach($x[$i] as $xx){
                array_push($selected_offers['location-' . $i], $xx->id);
            }
        }
        
        //$selected_requestsの定義    
        $selected_requests = array();
        $y = $selected_requests_divided_by_series->values()->all();
        for($i = 0; $i < count($y); $i++){
            $selected_requests['location-' . $i] = array();
            foreach($y[$i] as $yy){
                array_push($selected_requests['location-' . $i], $yy->id);
            }
        }
        
        //viewを返却
        if(auth()->user()->id == $trade->user_id){
            return view('trades.edit')->with([
                'trade' => $trade,
                'collection_of_eventinfo' => EventInfo::with('event')->whereDate('date', '>=', $today)->get(),
                'series_with_pictures' => Series::has('pictures')->with(['pictures' => ['member', 'type']])->get(),
                'php_series_with_pictures' => json_encode(Series::has('pictures')->get()->pluck('id')->all() ),
                'selected_methods' => $selected_methods,
                'selected_offer_series' => $selected_offer_series,
                'selected_request_series' => $selected_request_series,
                'selected_offers' => $selected_offers,
                'selected_requests' => $selected_requests,
            ]);
        } else {
            return redirect('/trades/' . $trade->id)->with('message', '※ 自分以外の投稿を編集することはできません');
        }
    }
    
    public function update(Request $request, Trade $trade)
    {
        if(auth()->user()->id == $trade->user_id){
            $request->validate([
                'methods' => ['required'],
                'offers' => ['required'],
                'requests' => ['required'],
                'note' => ['nullable', 'string', 'max:500'],
            ]);
            
            //tradesテーブルのデータ更新
            $trade->fill(['note' => $request->note])->save();
            
            //method_tradeテーブルのデータ更新
            $trade->methods()->detach();
            
            foreach($request->methods as $value){
                if($value == 0){
                    $trade->methods()->attach(1);
                }else{
                    $trade->methods()->attach(2, ['event_info_id' => $value]);
                }
            }
            
            //picture_tradeテーブルへの保存処理
            $trade->pictures()->detach();
            
            $offer_pictures = array_unique(array_reduce($request->offers, 'array_merge', []));
            $request_pictures = array_unique(array_reduce($request->requests, 'array_merge', []));
            
            sort($offer_pictures);
            sort($request_pictures);
            
            $trade->pictures()->attach($offer_pictures, ['kind' => 0]);
            $trade->pictures()->attach($request_pictures, ['kind' => 1]);
            
            //リダイレクト
            return redirect('/trades/' . $trade->id);
        } else {
            return redirect('/trades/' . $trade->id)->with('message', '※ 自分以外の投稿を編集することはできません');
        }
    }
    
    public function delete(Trade $trade)
    {
        if(auth()->user()->id == $trade->user_id){
            $trade->delete();
            return redirect('/trades');
        } else {
            return redirect('/trades/' . $trade->id)->with('message', '※ 自分以外の投稿を削除することはできません');    
        }
    }
}