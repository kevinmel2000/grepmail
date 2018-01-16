<?php

/**
 * Tool: Grep Mail Tool
 * Date: 25 Desember 2017
 * Author: X'1n73ct
 * Runing: php grepmail.php file.txt
 */

ini_set("memory_limit", -1);


function write($file, $text)
{
    $fp = fopen($file, 'a');
    fwrite($fp, $text);
    fclose($fp);
}

function grepmail($pattern, $input, $flags = 0)
{
    return array_merge(
        array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags))),
        preg_grep($pattern, $input, $flags)
    );
}


//header
echo "+-------------------------------------+".PHP_EOL;
echo "| Tool  : Grep Mail Tool              |".PHP_EOL;
echo "| Author: X'1n73ct                    |".PHP_EOL;
echo "| Runing: php grepmail.php file.txt   |".PHP_EOL;
echo "+-------------------------------------+".PHP_EOL; 

if(!empty($argv[1]) && file_exists($argv[1])){

echo "[i] Membaca data di {$argv[1]}" . PHP_EOL;
$array = array_unique(file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

echo "[i] Data terbaca sebanyak " . number_format(count($array)) . " email" . PHP_EOL;


echo "[i] Mengumpulkan list Hotmail" . PHP_EOL;
$hotmail_grab = grepmail("~(@hotmail|@outlook|@live|@msn)~i", $array);

$array = array_diff($array, $hotmail_grab);

echo "[i] Mengumpulkan list AOL" . PHP_EOL;
$aol_grab = grepmail("~(@aol)~i", $array);

$array = array_diff($array, $aol_grab);

echo "[i] Mengumpulkan list Yahoo" . PHP_EOL;
$yahoo_grab = grepmail("~(@yahoo|@ymail|@rocketmail)~i", $array);

$array = array_diff($array, $yahoo_grab);

echo "[i] Mengumpulkan list Gmail" . PHP_EOL;
$gmail_grab = grepmail("~(@gmail|@googlemail)~i", $array);

echo "[i] Mengumpulkan list Other" . PHP_EOL;
$other_grab = array_diff($array, $gmail_grab);

echo "[i] Create File" . PHP_EOL;

if (!is_dir("hasil")) {
    mkdir('hasil');
}

    $file_hotmail = "hotmail_" . count($hotmail_grab) . ".txt";
    $file_aol     = "aol_" . count($aol_grab) . ".txt";
    $file_yahoo   = "yahoo_" . count($yahoo_grab) . ".txt";
    $file_gmail   = "gmail_" . count($gmail_grab) . ".txt";
    $file_other   = "other_" . count($other_grab) . ".txt";

    echo "[i] Create File in Folder hasil" . PHP_EOL;
    echo $file_hotmail . PHP_EOL;
    echo $file_hotmail . PHP_EOL;
    echo $file_hotmail . PHP_EOL;
    echo $file_hotmail . PHP_EOL;
    echo $file_hotmail . PHP_EOL;

    write("hasil/" . $file_hotmail, implode(PHP_EOL, $hotmail_grab));
    write("hasil/" . $file_aol, implode(PHP_EOL, $aol_grab));
    write("hasil/" . $file_yahoo, implode(PHP_EOL, $yahoo_grab));
    write("hasil/" . $file_gmail, implode(PHP_EOL, $gmail_grab));
    write("hasil/" . $file_other, implode(PHP_EOL, $other_grab));

}else{

echo "[i] File tak terdeteksi" . PHP_EOL;

}
