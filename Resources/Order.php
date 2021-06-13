<?php

namespace App\Lib\EasyStore\Resources;

use App\Lib\EasyStore\Http;

class Order
{
  protected $http;

  public function __construct($config)
  {

    $this->http = new Http($config);

  }

  public function create($params){

    $order = $this->http
      ->request("POST", "/orders.json", $params)
      ->asArray();

    $metafields = $params["order"]["metafields"];

    if(isset($order['order']) && !empty($metafields)){

      foreach($metafields as $metafield){

        $metafield = $this->http
          ->request("POST", "/orders/" . $order['order']['id'] . "/metafields.json", [ "metafield" => $metafield ])
          ->asArray();

        if(isset($metafield["metafield"])){

          $order['order']["metafields"][] = $metafield;

        }

      }

    }

    return $order;

  }

  public function update($id, $params){

    $order = $this->http
      ->request("PUT", "/orders/$id.json", $params)
      ->asArray();

    $metafields = $params["order"]["metafields"];

    if(isset($order['order']) && !empty($metafields)){

      foreach($metafields as $metafield){

        $metafield = $this->http
          ->request("POST", "/orders/" . $order['order']['id'] . "/metafields.json", [ "metafield" => $metafield ])
          ->asArray();

        if(isset($metafield["metafield"])){

          $order['order']["metafields"][] = $metafield;

        }

      }

    }

    return $order;

  }

  public function list($params = [])
  {

    $orders = $this->http
      ->request("GET", "/orders.json", $params)
      ->asArray();

    return $orders;

  }

  public function get($id, $params = [])
  {

    $order = $this->http
      ->request("GET", "/orders/$id.json", $params)
      ->asArray();

    return $order;

  }

}
