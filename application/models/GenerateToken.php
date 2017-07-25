<?php

class GenerateToken extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function rand_alphnum($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min;
        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1;
        $bits = (int)$log + 1;
        $filter = (int)(1 << $bits) - 1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd > $range);
        return $min + $rnd;
    }

    public function getHash($username, $password)
    {
        $randnumb = "";
        $randnumb2 = "";
        $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < rand(12, 32); $i++) {
            $randnumb .= $codeAlphabet[$this->rand_alphnum(0, $max - 1)];
        }

        for ($i = 0; $i < rand(3, 7); $i++) {
            $randnumb2 .= $codeAlphabet[$this->rand_alphnum(0, $max - 1)];
        }

        $hash = base64_encode($randnumb2 . "?" . base64_encode($username . $password) . "!" . $randnumb);
        return $hash;
    }
}