<?php

namespace BitcodeSa\Msegat;

use BitcodeSa\Msegat\Models\Message;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Messageable
{
    public function messageable(): MorphMany
    {
        return $this->morphMany(Message::class);
    }
}
