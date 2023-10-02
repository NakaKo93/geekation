<?php
// 以下をそれぞれ表示してください。（すべて改行を行って出力すること)
// 現在時刻を自動的に取得するPHPの関数があるので調べて実装してみて下さい。
// 実行するとその都度現在の日本の日時に合わせて出力されるされるようになればOKです。
// 日時がおかしい場合、PHPのタイムゾーン設定を確認して下さい。

$week = array( "日", "月", "火", "水", "木", "金", "土" );
$dayOfWeek = "(".$week[date("w")]."曜日)";

echo "・現在日時(".date("Y年n月j日").$dayOfWeek.")<br>";
echo "・現在日時から３日後(".date("Y年n月j日 G時i分s秒",strtotime( "+3 day")).")<br>";
echo "・現在日時から１２時間前(".date("Y年n月j日 G時i分s秒",strtotime( "-12 hour")).")<br>";

$date_1 = new DateTime("2020-00-00");
$date_2 = new DateTime();
echo $date_1->diff($date_2)->format('・2020年元旦から現在までの経過日数 ( %a 日)');