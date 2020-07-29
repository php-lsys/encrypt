<?php
namespace LSYS;
use PHPUnit\Framework\TestCase;
final class ConfigTest extends TestCase
{
    public function testFile()
    {
        $encrypt=\LSYS\Encrypt\DI::get()->encrypt();
        $data='11';
        $_data=$encrypt->encode($data);
        $this->assertNotEmpty($_data);
        $__data=$encrypt->decode($_data);
        $this->assertEquals($data, $__data);
    }
}