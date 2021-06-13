<?php

namespace EasyStore\Resources;

use EasyStore\Http;

class Metafield
{
  protected $http;

  public function __construct($resource_type, $resource_id, $config)
  {
    $this->http          = new Http($config);
    $this->resource_type = $resource_type;
    $this->resource_id   = $resource_id;
  }

  public function list($params = [])
  {

    $metafields = $this->http
      ->request("GET", "/{$this->resource_type}s/{$this->resource_id}/metafields.json", $params)
      ->asArray();

    return $metafields;

  }

  public function create($params)
  {

    $metafield = $this->http
      ->request("POST", "/{$this->resource_type}s/{$this->resource_id}/metafields.json", $params)
      ->asArray();

    return $metafield;

  }

  public function update($id, $params)
  {

    $metafield = $this->http
      ->request("PUT", "/{$this->resource_type}s/{$this->resource_id}/metafields/$id.json", ["metafield" => $params])
      ->asArray();

    return $metafield;
  }

  public function updateOrCreate($params)
  {

    $namespace = @$params['namespace'];
    $key = @$params['key'];

    $response = $this->list([
      'namespace' => $namespace,
      'key' => $key
    ]);

    $metafield = @$response['metafields'][0];

    if ($metafield) {

      $metafield = $this->update($metafield['id'], $params);

      return $metafield;

    }

    $metafield = $this->create($params);

    return $metafield;

  }

  public function get($id, $params = [])
  {

  }
}
