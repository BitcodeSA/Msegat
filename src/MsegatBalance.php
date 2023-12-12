<?php

namespace BitcodeSa\Msegat;

use Illuminate\Support\Facades\Cache;

class MsegatBalance extends Msegat
{
    protected $end_point = "Credits.php";

    public function __construct($username = null)
    {
        $this->setApiUrl();
        $this->setAuthentication();
        $this->setUsername($username);
        $this->setClient();
    }

    public function setRequest()
    {
        $this->request = [
            "userName" => $this->username,
            "apiKey" => $this->api_key,
            "msgEncoding" => "UTF8"
        ];
    }

    public function balance()
    {
        $this->setRequest();
        $this->response = $this->client->post("/".$this->end_point, $this->request);
        return $this->response;
    }
}
