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
}
