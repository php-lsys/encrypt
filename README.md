字符串加密解密
===

[![Build Status](https://travis-ci.com/php-lsys/encrypt.svg?branch=master)](https://travis-ci.com/php-lsys/encrypt)
[![Coverage Status](https://coveralls.io/repos/github/php-lsys/encrypt/badge.svg?branch=master)](https://coveralls.io/github/php-lsys/encrypt?branch=master)

> 对字符串进行加解密操作

使用示例:
```
//$key 默认随机生成,每次生成只能当次解密
//需要加密解密分离,请添加配置文件 参见 /dome 目录
$en=LSYS\Encrypt\DI::get()->encrypt();
//加密
$encode=$en->encode("ddd");
//解密
var_dump($en->decode($encode));
```