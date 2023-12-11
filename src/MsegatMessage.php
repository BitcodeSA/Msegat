<?php

namespace BitcodeSa\Msegat;

class MsegatMessage
{
    const TYPE_SMS = 'sendsms';
    const TYPE_OTP = 'sendOTPCode';
    public $content;
    public $sender;
    public $type = "sendsms";
    public $lang = 'ar';

    public function __construct(string $content = '')
    {
        $this->content($content);
    }

    public function content(string $content): self
    {
        $this->content = str_replace('<br>', ' ', $content);
        return $this;
    }

    public function sender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function lang(string $lang): self
    {
        $this->lang = $lang;
        return $this;
    }
}
