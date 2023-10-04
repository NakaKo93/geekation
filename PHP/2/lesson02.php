<?php
// 80点以上なら「優」
// 60点以上なら「良」
// 40点以上なら「可」
// それ以下なら「負」

// という形で区別し、下記のフォーマットで出力するプログラムを作ってください。
// ○○点は「○」です。

$score = [1,39,40,59,60,79,80,100]; //いくつかのケースで動作確認を行ってください。

function judge($num){
    if($num >= 80){
        return '「優」';
    }elseif($num >= 60){
        return '「良」';
    }elseif($num >= 40){
        return '「可」';
    }else{
        return '「不可」';
    }
};

for ($count = 0; $count < count($score); $count++){
    $string = judge($score[$count]);
    echo $score[$count].'点は'.$string.'です。'."<br/>\n";
};