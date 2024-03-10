<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInfo;
use App\Models\Series;
use App\Models\Trade;
use App\Models\TradeComment;
use App\Models\Picture;
use Carbon\Carbon;


class TradeController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $offer_series = array();
        $request_series = array();
        for($i = 0; $i < 5; $i++){
            $offer_series['location-' . $i] = NULL;
            $request_series['location-' . $i] = NULL;
        }
        
        return view('trades.index')->with([
            'collection_of_eventinfo' => EventInfo::with('event')->whereDate('date', '>=', $today)->get(),
            'series_with_pictures' => Series::has('pictures')->with(['pictures' => ['member', 'type']])->get(),
            'php_series_with_pictures' => json_encode(Series::has('pictures')->get()->pluck('id')->all() ),
            'trades' => Trade::with(['user', 'methods', 'pictures' => ['series', 'member', 'type']])->orderBy('updated_at', 'DESC')->paginate(10),
            'offer_series' => $offer_series,
            'request_series' => $request_series,
        ]);
    }
    
    public function search(Request $request){
        
        //$offer_pictures, $request_picturesを定義
        $offer_pictures = NULL;
        $request_pictures = NULL;
        if(isset($request->offers)){
            $offer_pictures = array_unique(array_reduce($request->offers, 'array_merge', []));
        }
        if(isset($request->requests)){
            $request_pictures = array_unique(array_reduce($request->requests, 'array_merge', []));
        }
        
        //$methodsを定義
        $methods = $request->methods;
        
        //条件検索
        $trades = Trade::with(['user', 'methods', 'pictures' => ['series', 'member', 'type']])
                    ->when($methods, function ($query) use ($methods){
                        
                        //$method_mail, $method_realを定義
                        $method_mail = array();
                        $method_real = $methods;
                        if(in_array(0, $methods)){
                        	array_push($method_mail, 1);
                        	$method_real = array_diff($method_real, array(0));
                        }
                        
                        //methodに関する条件を記述
                        return $query->where(function ($q) use ($method_mail, $method_real){
                            $q->whereHas('methods', function($qq) use($method_mail){
                                    $qq->whereIn('method_trade.method_id', $method_mail);
                                })
                            ->orWhereHas('methods', function($qq) use($method_real){
                                    $qq->where('method_trade.method_id', 2)->whereIn('method_trade.event_info_id', $method_real);  
                                });
                        });
                    })
                    ->when($offer_pictures, function ($query) use ($offer_pictures){
                        return $query->whereHas('pictures', function ($q) use ($offer_pictures){
                            $q->where('picture_trade.kind', 1)->whereIn('picture_trade.picture_id', $offer_pictures);
                        });
                    })
                    ->when($request_pictures, function ($query) use ($request_pictures){
                        return $query->whereHas('pictures', function ($q) use ($request_pictures){
                             $q->where('picture_trade.kind', 0)->whereIn('picture_trade.picture_id', $request_pictures);
                        });
                    })
                    ->orderBy('updated_at', 'DESC')->paginate(10);
        
        //viewを返却
        $today = Carbon::today()->format('Y-m-d');
        
        return view('trades.index')->with([
            'collection_of_eventinfo' => EventInfo::with('event')->whereDate('date', '>=', $today)->get(),
            'series_with_pictures' => Series::has('pictures')->with(['pictures' => ['member', 'type']])->get(),
            'php_series_with_pictures' => json_encode(Series::has('pictures')->get()->pluck('id')->all() ),
            'trades' => $trades,
            'methods' => $request->methods, 
            'offer_series' => $request->offer_series,
            'request_series' => $request->request_series,
            'offers' => $request->offers,
            'requests' => $request->requests,
        ]);
    }
    
    public function show(Trade $trade)
    {
        return view('trades.show')->with([
            'trade' => $trade,
            'offers_divided_by_series' => $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 0)->get()->groupBy('series_id'),
            'requests_divided_by_series' => $trade->pictures()->with(['series', 'member', 'type'])->where('kind', 1)->get()->groupBy('series_id'),
            'comments' => $trade->trade_comments()->with('user')->orderBy('created_at', 'DESC')->paginate(10),
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
    
    public function comment(Request $request, Trade $trade)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:300'],
        ]);
        
        TradeComment::create([
            'user_id' => auth()->user()->id,
            'trade_id' => $trade->id,
            'comment' => $request->comment,
        ]);
        
        return redirect('/trades/' . $trade->id);
    }
    
    public function commentDelete(TradeComment $comment)
    {
        if(auth()->user()->id == $comment->user_id){
            $comment->delete();
            return redirect('/trades/' . $comment->trade_id);
        } else {
            return redirect('/trades/' . $comment->trade_id)->with('message', '※ 自分以外のコメントを削除することはできません');
        }
    }
}