<?php

namespace App\Consts;

class RuleConst{
    const RULES = [
        "new_image" => "image|mimes:jpeg,png",
        "no_image" => "required_without:new_image",
        "date" => "required",
        "shop" => "required",
        "price" => "required",
        "pay_type" => "required",
        "return_money" => "required",
    ];

    const MESSAGE = [
        "required" => "必須項目です",
        "image" => "指定されたファイルが画像ではありません",
        "mimes" => "使用できる拡張子はPNG,JPGのみです",
        "required_without" => "写真、画像なしで登録する場合はチェックをいれてください",
    ];
}