<?php

// config for BitcodeSa/Msegat
return [
    "api_url" => env("MSEGAT_API_URL", "https://www.msegat.com/gw"),
    "api_key" => env("MSEGAT_API_KEY", ""),
    "username" => env("MSEGAT_USERNAME", ""),
    "sender" => env("MSEGAT_SENDER", ""),
    "unicode" => env("MSEGAT_UNICODE", "UTF8"),
    "receiver" => env("MSEGAT_RECEIVER","phone"),
    "log" => env("MSEGAT_LOG", false),
];
