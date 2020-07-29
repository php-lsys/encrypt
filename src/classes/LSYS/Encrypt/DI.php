<?php
namespace LSYS\Encrypt;
/**
 * @method \LSYS\Encrypt encrypt()
 */
class DI extends \LSYS\DI{
    /**
     *
     * @var string default config
     */
    public static $config = 'encrypt.default';
    /**
     * @return static
     */
    public static function get($key=null){
        $di=parent::get();
        !isset($di->encrypt)&&$di->encrypt(new \LSYS\DI\ShareCallback(function($config=null){
            return $config?$config:self::$config;
        },function($config=null){
            $config=\LSYS\Config\DI::get()->config($config?$config:self::$config);
            return new \LSYS\Encrypt($config);
        }));
        return $di;
    }
}