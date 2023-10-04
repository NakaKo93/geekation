<?php
// 引数として数値を渡すと3倍にして返す関数を作ってください。

/**
 * 引数を3倍にして返す
 *
 * @param  int $num     入力する数値
 * @return int          入力値を3倍にした値
 */
function convertThreeTimes($num){
    return $num * 3;
};

echo convertThreeTimes(5);
// 15