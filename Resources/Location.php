<?php

namespace App\Lib\EasyStore\Resources;

use App\Lib\EasyStore\Http;

class Location
{

  protected $http;

  public function __construct($config)
  {

    $this->http = new Http($config);

  }

  public function list($params = [])
  {

    $locations = $this->http
                   ->request("GET", "/locations.json", $params)
                   ->asArray();

    return $locations;

  }

  public function get($id, $params = [])
  {

    $location = $this->http
                  ->request("GET", "/locations/$id.json", $params)
                  ->asArray();

    return $location;

  }

}
