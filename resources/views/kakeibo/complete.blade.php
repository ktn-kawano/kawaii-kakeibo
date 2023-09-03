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
    <div class="content">

        <h2 class="fit center">登録できました！</h2>

        <div class="move_button">
            <button class="button" onclick='location.href="/add"'>データを追加する</button>
            <button class="button" onclick='location.href="/thisMonth"'>今月のデータ確認・編集</button>
            <button class="button" onclick='location.href="/pastMonth"'>過去のデータ確認・編集</button>
            <button class="button" onclick='location.href="/kakeibo"'>TOPに戻る</button>
        </div>
    </div>
</body>
</html>