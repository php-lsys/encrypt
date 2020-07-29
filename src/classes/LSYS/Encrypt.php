<?php 
/**
 * lsys Encrypt
 *
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
class Encrypt {
    /**
     * create key
     * @return string
     */
    public static function keygen(){
        return base64_encode(sodium_crypto_secretbox_keygen());
    }
    protected $_key;
	/**
	 * Creates a new mcrypt wrapper.
	 */
	public function __construct(Config $config=null)
	{
	    if ($config
	        &&$key=$config->get("key")
	        ){ $key=base64_decode($key);
	            if(strlen($key)==SODIUM_CRYPTO_SECRETBOX_KEYBYTES){
                    $this->_key=$key;
	            }
	    }
	    if($this->_key==null) $this->_key=sodium_crypto_secretbox_keygen();
	}
	/**
	 * Encrypts a string and returns an encrypted string that can be decoded.
	 *
	 *     $data = $encrypt->encode($data);
	 *
	 * The encrypted binary data is encoded using [base64](http://php.net/base64_encode)
	 * to convert it to a string. This string can be stored in a database,
	 * displayed, and passed using most other means without corruption.
	 *
	 * @param   string  $data   data to be encrypted
	 * @return  string
	 */
	public function encode($data)
	{
	    $key=$this->_key;
	    $nonce = random_bytes(
	        SODIUM_CRYPTO_SECRETBOX_NONCEBYTES
	        );
	    
	    $cipher = base64_encode(
	        $nonce.
	        sodium_crypto_secretbox(
	            $data,
	            $nonce,
	            $key
	            )
	        );
	    sodium_memzero($data);
	    sodium_memzero($key);
	    return $cipher;
	}

	/**
	 * Decrypts an encoded string back to its original value.
	 *
	 *     $data = $encrypt->decode($data);
	 *
	 * @param   string  $data   encoded string to be decrypted
	 * @return  FALSE   if decryption fails
	 * @return  string
	 */
	public function decode($data)
	{
	    $key=$this->_key;
	    $decoded = base64_decode($data);
	    if ($decoded === false) {
	        throw new Exception('Scream bloody murder, the encoding failed');
	    }
	    if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
	        throw new Exception('Scream bloody murder, the message was truncated');
	    }
	    $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
	    $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
	    $plain = sodium_crypto_secretbox_open(
	        $ciphertext,
	        $nonce,
	        $key
	        );
	    if ($plain === false) {
	        throw new Exception('the message was tampered with in transit');
	    }
	    sodium_memzero($ciphertext);
	    sodium_memzero($key);
	    return $plain;
	}

}
