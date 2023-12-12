<?php

namespace BitcodeSa\Msegat;

use Illuminate\Support\Facades\Http;

class Msegat
{
    protected $api_url;
    protected $username;
    protected $api_key;
    protected $request;
    protected $client;
    protected $numbers;
    protected MsegatMessage $message;
    protected $response;

    public function __construct($username = null)
    {
        $this->setApiUrl();
        $this->setAuthentication();
        $this->setUsername($username);
        $this->setClient();
    }

    public function setApiUrl()
    {
        $this->api_url = config("msegat.api_url");
        return $this;
    }

    public function setAuthentication()
    {
        $this->api_key = config("msegat.api_key");
        return $this;
    }

    public function setUsername($username = null)
    {
        $this->username = $username ?? config("msegat.username");
        return $this;
    }

    public function setClient()
    {
        $this->client = Http::withHeaders([
            "Content-Type" => " application/json",
        ])->acceptJson()->baseUrl($this->api_url);
    }

    public function setRequest()
    {
        $this->request = [
            "userName" => $this->username,
            "userSender" => $this->message->sender,
            "apiKey" => $this->api_key,
            "numbers" => $this->numbers,
            "msgEncoding" => $this->message->unicode,
        ];

        if ($this->message->type == MsegatMessage::TYPE_SMS) {
            $this->request["msg"] = $this->message->content;
        } elseif ($this->message->type == MsegatMessage::TYPE_OTP) {
            $this->request["lang"] = $this->message->lang;
        }

        if ($this->message->timeToSend != "now") {
            $this->request["timeToSend"] = $this->message->time_to_send;
            $this->request["exactTime"] = $this->message->time_to_exec;
        }
    }

    public function setNumbers($numbers)
    {
        if (is_array($numbers)) {
            $numbers = implode(",", $numbers);
        }

        $this->numbers = $numbers;

        return $this;
    }

    public function setMessage(MsegatMessage $message)
    {
        $this->message = $message;
        return $this;
    }

    public function sendMessage($numbers, MsegatMessage $message)
    {
        $this->setNumbers($numbers);
        $this->setMessage($message);
        return $this->sendRequest();
    }

    public function sendRequest()
    {
        $this->setRequest();

        if (config("msegat.log")) {
            logger(http_build_query($this->request));
            return;
        }

        $this->response = $this->client->post("/".$this->message->type.".php", $this->request);

        return $this->response;
    }
}
