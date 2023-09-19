<?php
// 変数に値を代入し、
// その値が50より大きければ
// 「50より大きい」
// 50より小さければ
// 「50より小さい」
// 50と同値であれば
// 「50です」
// という文字列を出力してください。

// また最低限どういう値でテストすればいいか
// 確認したテスト値をコメントアウトですべて示してください。

$testNum = [1,49,50,51,100];

function judge($num){
    if($num < 50){
        return '50より小さい';
    }elseif($num === 50){
        return '50です';
    }elseif($num > 50){
        return '50より大きい';
    }
};

for ($count = 0; $count < count($testNum); $count++){
    $string = judge($testNum[$count]);
    echo $testNum[$count].'は、'.$string."<br/>\n";
};