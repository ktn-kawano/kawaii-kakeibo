<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>今月のデータ</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body>
    <header>
        <h1 class="main_title">かわいいかけいぼ</h1>
    </header>
    <div class="content data_content">
        <h2 class="fit center">{{ $now_year }}/{{ $now_month }}のデータ</h2>

        <div class="pay_table fit center">
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
                @foreach($array_this_month as $data)
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