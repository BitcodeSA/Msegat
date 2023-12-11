<?php

namespace BitcodeSa\Msegat;

use Illuminate\Support\Facades\Http;

class Msegat
{
    protected $api_url;
    protected $username;
    protected $sender;
    protected $api_key;
    protected $unicode;
    protected $request;
    protected $client;
    protected $numbers;
    protected MsegatMessage $message;
    protected $response;

    public function __construct($username = null, $sender = null, $unicode = null)
    {
        $this->setApiUrl();
        $this->setAuthentication();
        $this->setUsername($username);
        $this->setSender($sender);
        $this->setUnicode($unicode);
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

    public function setSender($sender = null)
    {
        if (!is_null($sender)) {
            $this->sender = $sender;
        } elseif (!is_null($this->message)) {
            $this->sender = $this->message->sender;
        } else {
            $this->sender = config("msegat.sender");
        }
        return $this;
    }

    public function setUnicode($unicode = null)
    {
        $this->unicode = $unicode ?? config("msegat.unicode");
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
            "userSender" => $this->sender,
            "apiKey" => $this->api_key,
            "msgEncoding" => $this->unicode,
            "numbers" => $this->numbers,
            "msg" => $this->message->content,
            "lang" => $this->message->lang,
        ];
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
        $this->setSender();
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
