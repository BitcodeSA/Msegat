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
    public $unicode = "UTF8";

    public function __construct(string $content = '')
    {
        $this->content($content);
        $this->sender();
    }

    public function content(string $content): self
    {
        $this->content = str_replace('<br>', ' ', $content);
        return $this;
    }

    public function sender(string $sender = null): self
    {
        $this->sender = $sender ?? config("msegat.sender");
        return $this;
    }

    /**
     * Sets the operation type.
     *
     * This method is used to set the operation type. The operation type can be either 'TYPE_SMS' or 'TYPE_OTP'.
     *
     * @param  string  $type  The type of operation. This should be either 'TYPE_SMS' or 'TYPE_OTP'.
     *
     * @return self Returns the current instance (for fluent interface).
     */
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

    public function unicode(string $unicode): self
    {
        $this->unicode = $unicode;
        return $this;
    }
}
