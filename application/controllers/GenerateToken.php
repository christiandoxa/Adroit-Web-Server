<?php

class GenerateToken
{
    public $hashfin = "";

    public function __construct($username, $password)
    {
        $token = "";
        $token2 = "";
        $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < rand(12, 32); $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
        }

        for ($i = 0; $i < rand(3, 7); $i++) {
            $token2 .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
        }

        $hash = $token2 . "?" . hash("sha256", $password . $username, false) . "!" . $token;
        $GLOBALS['hashfin'] = $hash;
    }

    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1; // length in bytes
        $bits = (int)$log + 1; // length in bits
        $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    public function getHash()
    {
        return $GLOBALS['hashfin'];
    }
}