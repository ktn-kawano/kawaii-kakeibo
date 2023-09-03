<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>かけいぼトップページ</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>

</head>
<body>
    <header>
        <h1 class="main_title">かわいいかけいぼ</h1>
    </header>
    <div class="content">
        <div class="top_page">
            <div class="left_content">
                <div id="this_month_data center">
                    <h2 class="fit center">今月のデータ</h2>
                    <div id="data_chart" class="chart center">
                        <canvas id="chart" width="500" height="500"></canvas>
                    </div>
                </div>
            </div>

            <div class="right_content">
                <div class="debt_data">
                    <p class="fit center">{{ $borrow_member }}{{ $lent_member }}{{ $debt_price }}{{ $text }}</p>
                </div>

                <div class="repayment_form fit center">
                    <form method="POST" action="/repayment" onsubmit="return repayment();" class="center">
                    @csrf
                        <input name="return_money" type="number" min="1"/>
                        <input name="repayment_member" type="hidden" value="{{ $borrow_mem }}">
                        <label>円</label>
                        <button type="submit" class="button repayment_button">返済する！</button>
                    </form>
                    @error('return_money')
                    <p class="err_message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="operate">
                    <button class="button edit_button" onclick='location.href="/add"'>データを追加する</button>
                    <button class="button edit_button" onclick='location.href="/thisMonth"'>今月のデータ確認・編集</button>
                    <button class="button edit_button" onclick='location.href="/pastMonth"'>過去のデータ確認・編集</button>
                </div>
            </div>
        </div>
    </div>
    <script>

        var label = JSON.parse('<?php echo $label_json; ?>');
        var data = JSON.parse('<?php echo $data_json; ?>');
        var ctx = document.getElementById("chart");
        new Chart(ctx,{
                type:"doughnut",
                data:{
                    labels:label,
                    datasets:[{
                        data:data,
                        backgroundColor:[
                            "#fceff8",
                            "#f6f0fa",
                            "#fef0ef",
                            "#eef9fd"
                        ],
                    }],
                },
                options:{
                    plugins:{
                        legend:{
                            position:"bottom",
                            labels:{
                                padding:50,
                                boxWidth:60,
                                font:{
                                    size:30,
                                    family:"にくまるフォント"
                                }
                            }
                            
                        },
                    },
                
                },
            });

        function repayment(){
            if(confirm('お金渡した？')){
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>