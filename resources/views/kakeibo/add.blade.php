<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ追加ページ</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <header>
        <h1 class="main_title">かわいいかけいぼ</h1>
    </header>

    <div class="edit_content">
        <h2 class="fit center data_add_titile">データを追加する</h2>

        <form method="POST" action="/store" class="image_add_form" enctype="multipart/form-data" >
        @csrf
            <div class="data_add_page">
                <div class="left_content">
                    <p>写真や画像データをアップロードします</p>
                    <div class="preview">
                        <img id="preview" class="preview_image" src="{{ asset('/img/no_image.png') }}">
                    </div>

                    <input type="file" id="new_image" name="new_image" accept="image/*" class="block">
                        @error('new_image')
                        <p class="err_message">{{ $message }}</p>
                        @enderror
                    <input type="checkbox" name="no_image" id="no_image">
                    <label for="no_image">写真・画像なしで登録する</label>
                        @error('no_image')
                        <p class="err_message">{{ $message }}</p>
                        @enderror
                </div>

                <div class="right_content">
                    <ul class="data_input">
                        <li>日付
                            <input name="date" type="date">
                            @error('date')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>

                        <li>店名
                            <input name="shop" type="text">
                            @error('shop')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>

                        <li>カテゴリー
                            <select name="category" id="category">
                                <option value="食費">食費</option>
                                <option value="お酒">お酒</option>
                                <option value="日用品">日用品</option>
                                <option value="その他">その他</option>
                            </select>
                        </li>

                        <li>買った人
                            <select name="bought_member" id="bought_member">
                                <option value="a">A</option>
                                <option value="b">B</option>
                            </select>
                        </li>

                        <li>金額
                            <input name="price" type="number" min="0">
                            @error('price')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                            <label for="">円を...</label>
                            <div class='pay_type_choice'>
                                
                                    <input type="radio" name="pay_type" id="pay_half" class="pay_half" value="5">
                                    <label for="pay_half">均等に割る！</label>
                                
                                    <input type="radio" name="pay_type" id="pay_full" class="pay_full" value="10">
                                    <label for="pay_full">✨おごる✨</label>
                                
                            </div>
                            @error('pay_type')
                            <p class="err_message">{{ $message }}</p>
                            @enderror
                        </li>
                    </ul>

                    <div class="transition_button">
                        <button type="button" class="button return_button" onclick='location.href="/kakeibo"'>やっぱりやめる</button>
                        <button type="submit" class="button data_add_button">登録する</button>
                    </div>
                </div>
            </div>
        </form>

            


    </div>
</body>
<script>
    $("#new_image").on('change', function(e){
        const reader = new FileReader();

        const FileName = e.target.files[0].name;

        reader.onload = function(e){
            $("#preview").attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    })

</script>
</html>