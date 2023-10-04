<?php
// 以下配列の中身をfor文を使用して表示してください。
// 表が縦横に伸びてもある程度対応できるように柔軟な作りを目指してください。
// 表示はHTMLの<table>タグを使用すること

/**
 * 表示イメージ
 *  _________________________
 *  |_____|_c1|_c2|_c3|横合計|
 *  |___r1|_10|__5|_20|___35|
 *  |___r2|__7|__8|_12|___27|
 *  |___r3|_25|__9|130|__164|
 *  |縦合計|_42|_22|162|__226|
 *  ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 */

$arr = [
    'r1' => ['c1' => 10, 'c2' => 5, 'c3' => 20],
    'r2' => ['c1' => 7, 'c2' => 8, 'c3' => 12],
    'r3' => ['c1' => 25, 'c2' => 9, 'c3' => 130]
];

$arrKey_r = array_keys($arr);
$arrKey_c = array_keys($arr[$arrKey_r[0]]);

$print = "";
$num = 0;
$total = 0;
$total_all = 0;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>テーブル表示</title>
<style>
table {
    border:1px solid #000;
    border-collapse: collapse;
}
th, td {
    border:1px solid #000;
}
</style>
</head>
<body>
<?php
//上枠部分
$width = 11 + count($arrKey_c) * 4;
echo "<table>".str_repeat("_", $width)."</table>";

//一段目
$print = "|".str_repeat("_", 5);
foreach($arrKey_c AS $key_c){
    $print .= "|".str_repeat("_", 3 - strlen($key_c)).$key_c;
};
$print .= "|横合計|";
echo "<table>".$print."</table>";

//二段目以降
foreach($arrKey_r AS $key_r){
    $print = "|".str_repeat("_", 5 - strlen($key_r)).$key_r;
    foreach($arrKey_c AS $key_c){
        $num = $arr[$key_r][$key_c];
        $total += $num;
        $print .= "|".str_repeat("_", 3 - strlen($num)).$num;
    };
    $print .= "|".str_repeat("_", 5 - strlen($total)).$total."|";
    $total = 0;
    echo "<table>".$print."</table>";
};

//最後の段落
$print = "|縦合計";
foreach($arrKey_c AS $key_c){
    foreach($arrKey_r AS $key_r){
        $num = $arr[$key_r][$key_c];
        $total += $num;
    };
    $print .= "|".str_repeat("_", 3 - strlen($total)).$total;
    $total_all += $total;
    $total = 0;
};
$print .= "|".str_repeat("_", 5 - strlen($total_all)).$total_all."|";
echo "<table>".$print."</table>";

//下枠部分
echo "<table>".str_repeat("‾", $width)."</table>";

?>    
</body>
</html>