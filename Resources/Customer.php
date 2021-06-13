<?php

namespace EasyStore\Resources;

use EasyStore\Http;

class Customer
{
  protected $http;
  protected $data;

  public function __construct($config)
  {
    $this->http = new Http($config);
    $this->config = $config;
  }

  public function create($params)
  {
    $customer = $this->http
      ->request("POST", "/customers.json", $params)
      ->asArray();

    $metafields = $params["customer"]["metafields"];

    if(isset($customer['customer']) && !empty($metafields)){

      foreach($metafields as $metafield){

        $metafield = $this->metafields()->create($metafield);

        if(isset($metafield["metafield"])){

          $customer['customer']["metafields"][] = $metafield;

        }

      }

    }

    return $customer;
  }

  public function update($idOrCode, $params)
  {
    $customer = $this->http
      ->request("PUT", "/customers/$idOrCode.json", $params)
      ->asArray();

    $this->data = $customer;

    $metafields = $params["customer"]["metafields"];

    if(isset($customer['customer']) && !empty($metafields)){

      foreach($metafields as $metafield) {

        $metafield = $this->metafields()->updateOrCreate($metafield);

        if(isset($metafield["metafield"])){

          $customer['customer']["metafields"][] = $metafield['metafield'];

        }

      }

    }

    return $customer;
  }

  public function updateOrCreate($params)
  {
    $response = $this->get($params["customer"]["code"]);

    if (@$response["customer"]["id"]) {

      $response = $this->update($response["customer"]["id"], $params);

      return $response;

    }

    $response = $this->create($params);

    return $response;
  }

  public function get($idOrCode, $params = [])
  {
    $customer = $this->http
    ->request("GET", "/customers/$idOrCode.json", $params)
    ->asArray();

    $this->data = $customer;

    return $customer;
  }

  public function metafields() {

    if (empty($this->data['customer']['id']))
      return;

    return new Metafield("customer", $this->data['customer']['id'], $this->config);

  }
}
