<?php

function decrypt($data,$key){
    $iv=pack("H*" , substr($data,0,16));
    $x =pack("H*" , substr($data,16)); 
    $res = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $x , MCRYPT_MODE_CBC, $iv);
    return $res;
}
 
function encrypt($data,$key){
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_CBC, $iv);
    return bin2hex($iv . $crypttext);
}



?>