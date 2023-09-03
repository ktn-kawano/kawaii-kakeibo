<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>過去のデータ</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body>
    <header>
        <h1 class="main_title">かわいいかけいぼ</h1>
    </header>
    <div class="content data_content">
        <form method="POST" action="/date_set" class="select_month fit center">
        @csrf
            <input type="number" name="year" min="2023" max="2024" value="{{ $set_year }}">
            <label for="year">年</label>
            <input type="number" name="month" min="1" max="12" value="{{ $set_month }}">
            <label for="month">月</label>
            <h2>のデータ</h2>
            <button type="submit" class="button">表示</button>
        </form>



        <div class="pay_table fit center">
        @php
            if(!empty($array_past_month)){
        @endphp
            <table class="pay_data">
                <tr>
                    <th>日付</th>
                    <th>店名</th>
                    <th>カテゴリー</th>
                    <th>買った人</th>
                    <th>金額</th>
                    <th>分割</th>
                    <th>詳細・編集・削除</th>
                </tr>
                <div>
                @foreach($array_past_month as $data)
                    <tr class="group{{ $counter%2 }}">
                        <td class="date">{{ $data['buy_date'] }}</td>
                        <td class="shop">{{ $data['shop'] }}</td>
                        <td class="category">{{ $data['category'] }}</td>
                        <td class="bought_member">{{ $data['paid_member'] }}</td>
                        <td class="price">{{ $data['price'] }}</td>
                        <td class="pay_type">A {{ $data['percentage_a'] }} : {{ $data['percentage_b'] }} B</td>
                        <td class="detail">
                            <div class="wrap">
                                <form method="get" action="/kakeibo/{{ $data['id'] }}/edit">
                                @csrf
                                    <button type="submit" class="button detail_button">詳細</button>
                                </form>
                                
                                <form method="POST" action="/kakeibo/{{ $data['id'] }}" onsubmit="return deleteData();">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="delete_button">削除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </table>
        @php } else { @endphp
        <h2 class="fit center">データはありません</h2>
        @php } @endphp
        </div>

        <button class="button return_button center" onclick='location.href="/kakeibo"'>TOPに戻る</button>
    </div>
    <script>
        function deleteData(){
            if(confirm('本当に削除しますか？')){
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>