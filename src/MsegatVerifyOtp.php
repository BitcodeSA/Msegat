<?php

namespace BitcodeSa\Msegat;

class MsegatVerifyOtp extends Msegat
{
    public $code;
    public $id;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRequest()
    {
        $this->request = [
            "userName" => $this->username,
            "userSender" => $this->sender,
            "apiKey" => $this->api_key,
            "msgEncoding" => $this->unicode,
            "numbers" => $this->numbers,
            "code" => $this->code,
            "id" => $this->id,
            "lang" => $this->message->lang,
        ];
    }
    public function validate($id, $code): bool
    {
        $this->setId($id);
        $this->setCode($code);
        $this->response = $this->client->post("/verifyOTPCode.php", $this->request);

        return $this->response->json("code") == 1;
    }
}
