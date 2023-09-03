<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Money;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function chartGet(Request $request){
        //現在の日時を取得
        $now = Carbon::now();
        $now_year = $now -> year;
        $now_month = $now -> month;

        $data = Money::select('category','price')
        -> where('status',true)
        -> whereYear('buy_date',$now_year)
        -> whereMonth('buy_date',$now_month)
        -> get();

        $chart_data = $data ->toArray();
        return (compact("chart_data"));
    }
}
