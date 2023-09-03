<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ編集ページ</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <header>
        <h1 class="main_title">かわいいかけいぼ</h1>
    </header>

    <div class="content update_content">
        <h2 class="fit center data_update_titile">データの詳細を確認・変更する</h2>

        <form method="POST" action="/kakeibo/{{ $id }}" class="fit center image_update_form" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
            <div class="data_update_page">
                <div class="left_content">
                    <p>写真や画像の変更</p>
                    <div class="preview" id="edit_preview">
                        <img id="preview" class="preview_image" src="{{ asset( $result ) }}">
                    </div>

                    <input type="file" id="update_image" name="update_image" accept="image/*" class="block">
                        @error('new_image')
                        <p class="err_message">{{ $message }}</p>
                        @enderror
                    <input type="checkbox" name="no_image" id="no_image">
                    <label for="no_image">写真・画像なしに変更する</label>
                        @error('no_image')
                        <p class="err_message">{{ $message }}</p>
                        @enderror
                </div>

                <div class="right_content">
                    <ul class="data_update">
                        <li>日付
                            <input name="date" type="date" value="{{ $date }}">
                            @error('date')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>

                        <li>店名
                            <input name="shop" type="text" value="{{ $store }}">
                            @error('shop')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>

                        <li>カテゴリー
                            <select name="category" id="category">
                                <option value="食費" @php if($category == '食費'){ @endphp selected @php } @endphp>食費</option>
                                <option value="お酒" @php if($category == 'お酒'){ @endphp selected @php } @endphp>お酒</option>
                                <option value="日用品" @php if($category == '日用品'){ @endphp selected @php } @endphp>日用品</option>
                                <option value="その他" @php if($category == 'その他'){ @endphp selected @php } @endphp>その他</option>
                            </select>
                        </li>

                        <li>買った人
                            <select name="bought_member" id="bought_member">
                                <option value="a" @php if($member == 'a'){ @endphp selected @php } @endphp>A</option>
                                <option value="b" @php if($member == 'b'){ @endphp selected @php } @endphp>B</option>
                            </select>
                        </li>

                        <li>金額
                            <input name="price" type="number" min="0" value="{{ $price }}">
                            @error('price')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                            <label for="">円を...</label>
                            <div class='pay_type_choice'>
                                
                                    <input type="radio" name="pay_type" id="pay_half" class="pay_half" value="5" @php if($per_a == '5'){ @endphp checked @php } @endphp>
                                    <label for="pay_half">均等に割る！</label>
                                
                                    <input type="radio" name="pay_type" id="pay_full" class="pay_full" value="10" @php if($per_a == '10' || $per_b == '10'){ @endphp checked @php } @endphp>
                                    <label for="pay_full">✨おごる✨</label>
                                
                            </div>
                            @error('pay_type')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>
                    </ul>

                    <div class="transition_button">
                        <button type="button" class="button return_button" onclick='history.back();'>戻る</button>
                        <button type="submit" class="button data_update_button">更新する</button>
                    </div>
                </div>
            </div>
        </form>
        <form method="POST" action="/kakeibo/{{ $id }}" onsubmit="return deleteData();" class="delete_form">
        @csrf
        @method('DELETE')
            <button type="submit" class="button delete_button">このデータを消す</button>
        </form>
    </div>
</body>
<script>
    $("#update_image").on('change', function(e){
        if($("#no_image").prop("checked")){
            $("#no_image").prop("checked",false);
        }
        const reader = new FileReader();

        const FileName = e.target.files[0].name;

        reader.onload = function(e){
            $("#preview").attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);

    })

    $("#no_image").on('change', function(){
        const file = "{{ asset('/img/no_image.png') }}";
        $("#edit_preview").html(
            '<img id="preview" class="preview_image" src="{{ asset('/img/no_image.png') }}">'
        )
    })


    function deleteData(){
        console.log('aaa');
        if(confirm('本当に削除しますか？')){
            return true;
        } else {
            return false;
        }
    }
</script>
</html>