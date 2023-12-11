<?php

namespace BitcodeSa\Msegat;

use Illuminate\Notifications\Notification;

class MsegatChannel
{
    protected Msegat $msegat;

    public function __construct(Msegat $msegat)
    {
        $this->msegat = $msegat;
    }

    public function send($notifiable, Notification $notification): void
    {
        $recever = $notifiable->routeNotificationFor('msegat');

        if (!$recever) {
            $notifiable->routeNotificationFor(MsegatChannel::class);
        }

        if (!$recever) {
            $recever = $notifiable->phone;
        }

        if (!$recever) {
            return;
        }

        $message = $notification->toMsegat($notifiable);

        if (is_string($message)) {
            $message = new MsegatMessage($message);
        }

        $this->msegat->sendMessage($recever, $message->content, $message->sender);
    }
}
