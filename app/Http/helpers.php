<?php

use Illuminate\Support\Facades\Http;

function getUser($id)
{
  $url = env('URL_SERVICE_USERS') . 'users/' . $id; // ? http://localhost:5000/users/{id} => GET USER
  try {
    $response = Http::timeout(10)->get($url);
    $data = $response->json();
    $data['http_code'] = $response->getStatusCode();
    return $data;
  } catch (\Throwable $th) {
    return serviceNotAvailable();
  }
}

function getUserByIds($ids = [])
{
  $url = env('URL_SERVICE_USERS') . 'users/'; // ? http://localhost:5000/users => GET USERS
  try {
    if (count($ids) === 0) {
      return [
        'status' => 'success',
        'http_code' => 200,
        'data' => []
      ];
    }
    $response = Http::timeout(10)->get($url, ['user_ids[]' => $ids]); // ! http://localhost:5000/users/?user_ids=4&user_ids=3 => GET USER berdasarkan param query array user_ids
    $data = $response->json();
    $data['http_code'] = $response->getStatusCode();
    return $data;
  } catch (\Throwable $th) {
    return serviceNotAvailable();
  }
}

function createOrder($params)
{
  $url = env('URL_SERVICE_ORDERS_PAYMENTS') . 'api/orders';
  try {
    $response = Http::post($url, $params);
    $data = $response->json();
    $data['http_code'] = $response->getStatusCode();
    return $data;
  } catch (\Throwable $th) {
    return [
      'status' => 'error',
      'http_code' => 500,
      'message' => 'service order payment not available'
    ];
  }
}

function serviceNotAvailable()
{
  return [
    'status' => 'error',
    'http_code' => 500,
    'message' => 'service user not available'
  ];
}
