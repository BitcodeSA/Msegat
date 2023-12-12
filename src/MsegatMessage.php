<?php

namespace BitcodeSa\Msegat;

class MsegatMessage
{
    const TYPE_SMS = 'sendsms';
    const TYPE_OTP = 'sendOTPCode';
    const TIME_TO_SEND_NOW = 'now';
    const TIME_TO_SEND_LATER = 'later';
    public $content;
    public $sender;
    public $type = self::TYPE_SMS;
    public $lang = 'ar';
    public $unicode = "UTF8";
    public $time_to_send = self::TIME_TO_SEND_NOW;
    public $time_to_exec;

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

    /**
     * Sets the operation time.
     *
     * This method is used to set the operation time. The operation type can be either 'now' or 'later'.
     *
     * @param  string  $time_to_send  The type of operation. This should be either 'now' or 'later'.
     *
     * @return self Returns the current instance (for fluent interface).
     */
    public function timeToSend(string $time_to_send = self::TIME_TO_SEND_NOW): self
    {
        $this->time_to_send = $time_to_send;
        return $this;
    }

    /**
     * Set the execution time of the current instance.
     * This method is a part of a fluent interface and returns the current instance
     * to support method chaining.
     *
     * @param  string  $timestamp  Time to execute in "yyyy-MM-dd HH:mm:ss" format.
     *
     * @return self Returns the current instance.
     *
     * Details: This method first calls the `timeToSend()` function with the
     * parameter as 'later', then sets the `$time_to_exec` property to the passed `$timestamp`.
     * It can be used when there's a need to specify the execution time of a task.
     *
     * Usage:
     * $instance = new ClassName();
     * $instance->timeToExec("2023-12-01 17:30:00")->otherMethod();
     *
     * Note: Please replace `ClassName` with the actual class name.
     */
    public function timeToExec($timestamp): self
    {
        $this->timeToSend(self::TIME_TO_SEND_LATER);
        $this->time_to_exec = $timestamp;
        return $this;
    }
}
