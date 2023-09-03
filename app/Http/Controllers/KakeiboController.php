<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Money;
use App\Models\Debt;
use Carbon\Carbon;
use App\Consts\RuleConst;
use Illuminate\Support\Facades\Validator;

class KakeiboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kakeibo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request -> all(), RuleConst::RULES, RuleConst::MESSAGE) -> Validate();

        //支払割合の設定
        $bought_member = $request->input('bought_member');
        $per_a = $_POST['pay_type'];
        $per_b = $_POST['pay_type'];
        if($per_a != '5'){
            if($bought_member == "a"){
                $per_a = 10;
                $per_b = 0;
            } else {
                $per_a = 0;
                $per_b = 10;
            }
        }

        //moneyテーブルへの保存操作
        $input_data = new Money;

        $input_data -> buy_date = $request -> input('date');
        $input_data -> price = $request -> input('price');
        $input_data -> shop = $request -> input('shop');
        $input_data -> category = $request -> input('category');
        $input_data -> paid_member = $bought_member;
        $input_data -> percentage_a = $per_a;
        $input_data -> percentage_b = $per_b;
        $input_data -> save();

        //debtテーブルへの保存操作
        $debt_data = new Debt;
        if($per_a == "5"){
            if($bought_member == "a"){
                $debt_data -> buy_date = $request -> input('date');
                $debt_data -> price = $request -> input('price') /2;
                $debt_data -> debt_member = 'b';
            } else {
                $debt_data -> buy_date = $request -> input('date');
                $debt_data -> price = $request -> input('price') /2;
                $debt_data -> debt_member = 'a';
            }
        } else {
            $debt_data -> buy_date = $request -> input('date');
            $debt_data -> price = 0;
            $debt_data -> debt_member = 'b';
        }
        
        $debt_data -> save();

        

        //ファイル保存の操作
        if(!is_null($request -> file('new_image'))){
            $mimetype = $request -> file('new_image') -> getMimeType(); //ファイルのmimetypeを取得
            $mime = "";
    
            if($mimetype == "image/png"){
                $mime = ".png";
            } else if ($mimetype == 'image/jpeg'){
                $mime = ".jpeg";
            }

            $dir = "img" ; //保存するディレクトリ名
            $file_name = $input_data -> id . $mime;
            $request -> file('new_image') -> storeAs('public/' . $dir , $file_name);
        };


        return redirect('/complete');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $money_id = Money::find($id);
        $money_data = $money_id -> toArray();
        $dir = "storage/img/".$money_data['id'].".*";
        foreach(glob($dir, GLOB_BRACE) as $file){
            $result = $file;
        }
        $id = $money_data['id'];
        $date = $money_data['buy_date'];
        $shop = $money_data['shop'];
        $category = $money_data['category'];
        $member = $money_data['paid_member'];
        $price = $money_data['price'];
        $per_a = $money_data['percentage_a'];
        $per_b = $money_data['percentage_b'];

        if(!empty($result)){
            $result = "$file";
        } else {
            $result = '/img/no_image.png';
        }

        
        return view('kakeibo.edit',compact('id','date','shop','category','member','price','per_a','per_b','result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $delete_money = Money::find($id);
        $delete_debt = Debt::find($id);

        $delete_money -> status = false;
        $delete_debt -> status = false;

        $delete_money -> save();
        $delete_debt -> save();

        //支払割合の設定
        $bought_member = $request->input('bought_member');
        $per_a = $_POST['pay_type'];
        $per_b = $_POST['pay_type'];
        if($per_a != '5'){
            if($bought_member == "a"){
                $per_a = 10;
                $per_b = 0;
            } else {
                $per_a = 0;
                $per_b = 10;
            }
        }

        //moneyテーブルへの保存操作
        $input_data = new Money;

        $input_data -> buy_date = $request -> input('date');
        $input_data -> price = $request -> input('price');
        $input_data -> shop = $request -> input('shop');
        $input_data -> category = $request -> input('category');
        $input_data -> paid_member = $bought_member;
        $input_data -> percentage_a = $per_a;
        $input_data -> percentage_b = $per_b;
        $input_data -> save();

        //debtテーブルへの保存操作
        $debt_data = new Debt;
        if($per_a == "5"){
            if($bought_member == "a"){
                $debt_data -> buy_date = $request -> input('date');
                $debt_data -> price = $request -> input('price') /2;
                $debt_data -> debt_member = 'b';
            } else {
                $debt_data -> buy_date = $request -> input('date');
                $debt_data -> price = $request -> input('price') /2;
                $debt_data -> debt_member = 'a';
            }
        } else {
            $debt_data -> buy_date = $request -> input('date');
            $debt_data -> price = 0;
            $debt_data -> debt_member = 'b';
        }
        
        $debt_data -> save();

        //ファイル保存の操作
        if(!is_null($request -> file('new_image'))){
            $mimetype = $request -> file('new_image') -> getMimeType(); //ファイルのmimetypeを取得
            $mime = "";
    
            if($mimetype == "image/png"){
                $mime = ".png";
            } else if ($mimetype == 'image/jpeg'){
                $mime = ".jpeg";
            }

            $dir = "img" ; //保存するディレクトリ名
            $file_name = $input_data -> id . $mime;
            $request -> file('new_image') -> storeAs('public/' . $dir , $file_name);
        };

        return redirect('/complete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_money = Money::find($id);
        $delete_debt = Debt::find($id);

        $delete_money -> status = false;
        $delete_debt -> status = false;

        $delete_money -> save();
        $delete_debt -> save();

        return redirect('/thisMonth'); //分岐したいな～　ルーティングわけるしかない？
    }

    
    /**
     * Create a new user instance after a valid registration
     * 
     * @param array $data
     * @return \App\Models\User
    */

    public function upload(Request $request){

    }
    public function calc_debt(){

        //現在の日時を取得
        $now = Carbon::now();
        $now_year = $now -> year;
        $now_month = $now -> month;

        $data = Money::groupBy('category')
        -> where('status',true)
        -> select('category',Money::raw('sum(price) as total_price'))
        -> get();
        $chart_data = $data ->toArray();
        
        $array_label = array_column($chart_data,'category');
        $array_data = array_column($chart_data,'total_price');
        $label_json = json_encode($array_label);
        $data_json = json_encode($array_data);
        

        //借金額の計算
        $debt_a = Debt::select('price') -> where('debt_member','a')
        -> where('status',true)
        -> get();
        $array_a = $debt_a -> toArray();

        $result_a = 0;
        foreach($array_a as $data){
            $result_a += $data['price'];
        }

        $debt_b = Debt::select('price') -> where('debt_member','b')
        -> where('status',true)
        -> get();
        $array_b = $debt_b -> toArray();

        $result_b = 0;
        foreach($array_b as $data){
            $result_b += $data['price'];
        }

        if($result_a < $result_b){
            $borrow_mem = 'b';
            $borrow_member = "Bは";
            $lent_member = "Aに";
            $debt_price = ($result_b - $result_a);
            $text = "円の借金があります";
        } else if($result_a > $result_b) {
            $borrow_mem = 'a';
            $borrow_member = "Aは";
            $lent_member = "Bに";
            $debt_price = ($result_a - $result_b);
            $text = "円の借金があります";
        } else {
            $borrow_member = "";
            $lent_member = "";
            $debt_price = "";
            $text = "💰借金はありません💰";
        }
        return view('kakeibo.index',compact(
            "label_json","data_json","borrow_mem","borrow_member",'lent_member','debt_price','text'
        ));
    }

    public function this_month(){
        //現在の日時を取得
        $now = Carbon::now();
        $now_year = $now -> year;
        $now_month = $now -> month;

        //DBの情報を取得
        $this_month_data = Money::select(
            'id','buy_date','price','shop','category','paid_member','percentage_a','percentage_b'
        )
        -> where('status',true)
        -> whereYear('buy_date',$now_year)
        -> whereMonth('buy_date',$now_month)
        -> orderBy('buy_date','asc')
        -> get();

        $array_this_month = $this_month_data -> toArray();
        $counter = 0;

        return view('kakeibo.thisMonth',compact("now_year","now_month","array_this_month","counter"));
    }

    public function past_month(){
        //現在の日時を取得
        $now = Carbon::now();
        $set_year = $now -> year;
        $set_month = $now -> month;

        //DBの情報を取得
        $past_month_data = Money::select(
            'id','buy_date','price','shop','category','paid_member','percentage_a','percentage_b')
        -> where('status',true)
        -> whereYear('buy_date',$set_year)
        -> whereMonth('buy_date',$set_month)
        -> orderBy('buy_date','asc')
        -> get();

        $array_past_month = $past_month_data -> toArray();
        $counter = 0;

        return view('kakeibo.pastMonth',compact("set_year","set_month","array_past_month","counter"));
    }

    public function date_set(Request $request){
        $set_year = $request -> input('year');
        $set_month = $request -> input('month');

        $past_month_data = Money::select(
            'id','buy_date','price','shop','category','paid_member','percentage_a','percentage_b')
        -> where('status',true)
        -> whereYear('buy_date',$set_year)
        -> whereMonth('buy_date',$set_month)
        -> orderBy('buy_date','asc')
        -> get();

        $array_past_month = $past_month_data -> toArray();
        $counter = 0;

        return view('kakeibo.pastMonth',compact("set_year","set_month","array_past_month","counter"));
    }

    public function repayment(Request $request){
        Validator::make($request -> all(), RuleConst::RULES, RuleConst::MESSAGE) -> Validate();

        $today = new Carbon('today');

        //moneyテーブルへの保存操作
        $input_data = new Money;

        $input_data -> buy_date = $today;
        $input_data -> price = -($request -> input('return_money'));
        $input_data -> shop = "返済";
        $input_data -> category = "返済";
        $input_data -> paid_member = $request -> input('repayment_member');
        $input_data -> percentage_a = 0;
        $input_data -> percentage_b = 0;
        $input_data -> status = false;
        $input_data -> save();

        //debtテーブルへの保存操作
        $debt_data = new Debt;

        $debt_data -> buy_date = $today;
        $debt_data -> price = -($request -> input('return_money'));
        $debt_data -> debt_member = $request -> input('repayment_member');
        $debt_data -> save();

        return redirect('/complete');
    }


}
