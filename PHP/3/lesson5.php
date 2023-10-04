<?php
// 以下をfor文を使用して表示してください。
// ヒント: forの中でforを３回使用

// ********1
// *******121
// ******12321
// *****1234321
// ****123454321
// ***12345654321
// **1234567654321
// *123456787654321
// 12345678987654321

$input = 9;

for($num = 1; $num <= $input; $num++){
    $string = '';
    $stringA = '';

    for($asterisk = 1; $asterisk <= ($input - $num); $asterisk++){
        $stringA .= '*';
    };

    for($arrayNum = 1; $arrayNum < $num; $arrayNum++){
        $string .= $arrayNum;
    };

    echo $stringA.$string.$num.strrev($string)."<br/>\n";
};