<?php

namespace BitcodeSa\Msegat;

class MsegatMessage
{
    public $content;
    public $sender;

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function content(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function sender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }
}
