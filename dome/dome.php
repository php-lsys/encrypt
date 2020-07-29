<?php
include_once __DIR__."/Bootstarp.php";
//$key 默认随机生成,如果你加密后需要存储,需要把key存起来
$en=LSYS\Encrypt\DI::get()->encrypt();


$encode=$en->encode("ddd");

echo $encode;

var_dump($en->decode($encode));