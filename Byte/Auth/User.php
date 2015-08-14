<?php
namespace Byte\Auth;
class User
{
  public function __construct($apiKey, $url = NULL)
  {
    if($url==NULL)
    {
      $this->url = "http://auth.byte.gs/api";
    }
    else {
      $this->url = $url;
    }
    $this->apiKey = $apiKey;
    $this->curl = new \Curl;
    $this->curl->headers["X-Auth-Token"] = $apiKey;
  }
  public function ping()
  {
    $res = $this->curl->get($this->url."/ping");
    if($res->body=="pong")
    {
      return true;
    }
    return false;
  }
  public function register($mail, $password)
  {
    $res = $this->curl->post($this->url."/user/", ["mail"=>$mail, "password"=>$password]);
    $ret = json_decode($res->body, true);
    return $ret;
  }
  public function activate($id, $mailHash)
  {
    $res = $this->curl->post($this->url."/user/".(int)$id."/activate", ["mailHash"=>$mailHash]);
    $ret = json_decode($res->body, true);
    return $ret;
  }
  public function login($mail, $password)
  {
    $res = $this->curl->post($this->url."/user/login", ["mail"=>$mail, "password"=>$password]);
    $ret = json_decode($res->body, true);
    return $ret;
  }
  public function get($id)
  {
    $res = $this->curl->get($this->url."/user/".(int)$id);
    $ret = json_decode($res->body, true);
    return $ret;
  }
  public function listUser($limit = 20, $page = 0)
  {
    $res = $this->curl->get($this->url."/user/?limit=".(int)$limit."&page=".(int)$page);
    $ret = json_decode($res->body, true);
    return $ret;
  }
  public function update($id, $data = [])
  {
    $res = $this->curl->post($this->url."/user/".(int)$id, $data);
    $ret = json_decode($res->body, true);
    return $ret;
  }
}
