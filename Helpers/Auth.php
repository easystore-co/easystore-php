<?php

namespace App\Lib\EasyStore\Helpers;

use App\Lib\EasyStore\Http;

class Auth
{

  public function __construct($config)
  {
    $this->http = new Http($config);
    $this->config = $config;
  }

  public function verifyRequest($params){

    $data = $params['data'];
    $data = json_encode($data, JSON_UNESCAPED_SLASHES|JSON_PRESERVE_ZERO_FRACTION);

    $calculated = hash_hmac('sha256', $data, $this->config['clientSecret']);

    return $calculated === $params['hmac'];

  }

}
