<?php

namespace BitcodeSa\Msegat;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class MsegatChannel
{
    protected Msegat $msegat;

    public function __construct(Msegat $msegat)
    {
        $this->msegat = $msegat;
    }

    public function send($notifiable, Notification $notification)
    {
        $recever = $notifiable->routeNotificationFor('msegat');

        if (!$recever) {
            $recever = $notifiable->routeNotificationFor(MsegatChannel::class);
        }

        if (!$recever) {
            $recever = $notifiable->{config("msegat.receiver")};
        }

        if (!$recever) {
            return;
        }

        $message = $notification->toMsegat($notifiable);

        if (is_string($message)) {
            $message = new MsegatMessage($message);
        }
        $this->msegat->setNotifiable($notifiable);
        $result = $this->msegat->sendMessage($recever, $message);
        return $result;
    }
}
