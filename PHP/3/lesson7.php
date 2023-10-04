<?php
// 以下はランダムな数字を格納した配列を表示するプログラムです。
// 配列内の隣合う数字を比較して左側から小さい順に表示されるよう配列の中身を並び替えてください。
// 並び替えはfor文を使用すること
// (sort関数などを使用すれば実装は可能ですが、for文を使って一つ一つの値を比較・操作して並べ替えを実装してみてください。)

$arr = [99, 3, 12, 45, 60, 100, 31, 7, 28];

// 例）
// 4, 3, 1, 2
// ↓
// 3, 4, 1, 2
// ↓
// 3, 1, 4, 2
// ↓
// 3, 1, 2, 4
// ↓
// 1, 3, 2, 4
// ↓
// 1, 2, 3, 4　←これが画面に表示される

$arr = [99, 3, 12, 45, 60, 100, 31, 7, 28];

$score = 0;
$arr_sort = [];
$print = '';

// ここで並び替え処理
for($num = 0; $num < count($arr); $num++){
    for($num_sort = 0; $num_sort < count($arr_sort); $num_sort++){
        if($arr[$num] > $arr_sort[$num_sort]){
            $score++;
        };
    };
    array_splice($arr_sort, $score, 0, $arr[$num]);
    $score = 0;
};

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>数字並び替えプログラム</title>
</head>
<body>
    <!-- ここに並び替え後を表示 -->
    <?php
    for($num = 0; $num < (count($arr_sort) - 1); $num++){
        $print .= $arr_sort[$num].', ';
    };
    $print .= end($arr_sort);
    
    echo $print;
    ?>
</body>
</html>
