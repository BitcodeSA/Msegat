<?php

namespace BitcodeSa\Msegat;

use Illuminate\Support\Facades\Cache;

class MsegatVerifyOtp extends Msegat
{
    public function __construct($username = null)
    {
        $this->setApiUrl();
        $this->setAuthentication();
        $this->setUsername($username);
        $this->setClient();
    }

    public $code;
    public $id;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setId($notifiable)
    {
        $this->id = Cache::get(class_basename(get_class($notifiable)).":".$notifiable->id);
    }

    public function setSender()
    {
        $this->sender = config("msegat.sender");
        return $this;
    }

    public function setRequest()
    {
        $this->request = [
            "userName" => $this->username,
            "userSender" => $this->sender,
            "apiKey" => $this->api_key,
            "code" => $this->code,
            "id" => $this->id,
        ];
    }

    public function validate($notifiable, $code): bool
    {
        $this->setId($notifiable);
        $this->setCode($code);
        $this->setRequest();
        $this->response = $this->client->post("/verifyOTPCode.php", $this->request);

        return $this->response->json("code") == 1;
    }
}
