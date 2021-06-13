<?php

namespace App\Lib\EasyStore;

class Http
{

  protected $host;

  public function __construct($config)
  {

    $this->host   = "https://" . $config["storeUrl"];
    $this->version= "3.0";

    $this->header = ["content-type: application/json; charset=utf-8"];
    array_push($this->header, "EasyStore-Access-Token: " . $config["accessToken"]);

  }


  public function request($method, $endpoint, $payload = [])
  {

    $endpoint = $this->host . "/api/" . $this->version . $endpoint;

    $ch = curl_init();


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    if($method != "GET"){

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    }else{

      $query    = http_build_query($payload);
      $endpoint = $endpoint . "?" . $query;

    }

    curl_setopt($ch, CURLOPT_URL, $endpoint);


    $this->response = curl_exec($ch);

    curl_close($ch);

    return $this;

  }

  public function asArray(){

    $data = json_decode($this->response, true);
    return $data;

    // if(isset($data['Status']) && strtolower($data['Status']) == 'success') return $data['Data'];

    return null;

  }

}
