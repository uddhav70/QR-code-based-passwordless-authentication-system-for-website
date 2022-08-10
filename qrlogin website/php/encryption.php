<?php
/*Encryption algorithm :crypt() will return a hashed string using the standard Unix DES-based algorithm*/
function aes128_encode($data)
{
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($cipher), MCRYPT_RAND);
    $key = substr(CIPHERKEY, 0, mcrypt_enc_get_key_size($cipher));

    if (mcrypt_generic_init($cipher, $key, $iv) != 1) {
        $cipherData = mcrypt_generic($cipher, $data);

        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);

        $sanitizedCipherData = trim(base64_encode($iv)."_".base64_encode($cipherData));
        return $sanitizedCipherData;
    } else {
        return false;
    }
}
function aes128_decode($data)
{
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
	$key = substr(CIPHERKEY, 0, mcrypt_enc_get_key_size($cipher));
	$parts = explode("_", $data);
	$iv = base64_decode($parts[0]); 
	$cipherData = base64_decode($parts[1]);

	if (mcrypt_generic_init($cipher, $key, $iv) != -1) {
	    $originalData = mdecrypt_generic($cipher, $cipherData);
	    mcrypt_generic_deinit($cipher);
	    mcrypt_module_close($cipher);

	    return $originalData;
	} else {
	    return false;
	}
}