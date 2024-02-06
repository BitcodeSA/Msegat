<?php

namespace BitcodeSa\Msegat;

use BitcodeSa\Msegat\Models\Message;
use Illuminate\Http\Client\Response;
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

        $this->createMessage($result, $notifiable, $message, $recever);

        return $result;
    }

    public function createMessage($response, $notifiable, $message, $recever)
    {
        if (config("msegat.model.allow_messages_log")) {
            if ($response instanceof Response) {
                if ($response->successful()) {
                    Message::create([
                        "phone" => $recever,
                        "message" => $message->content,
                        "messageable_type" => get_class($notifiable),
                        "messageable_id" => $notifiable->{$notifiable->getKeyName()},
                        "response_code" => $response->json("code", 0),
                        "response_message" => $response->json("message", "No Response")
                    ]);
                }
            }
        }
    }
}
