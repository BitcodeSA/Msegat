<?php

namespace BitcodeSa\Msegat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    protected $fillable = [
        'phone',
        'message',
        'response_code',
        'response_message',
        'messageable_type',
        'messageable_id',
    ];

    public function getTable()
    {
        return config('msegat.model.table_name', parent::getTable());
    }

    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }
}
