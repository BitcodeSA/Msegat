<?php

// config for BitcodeSa/Msegat
return [
    "api_url" => env("MSEGAT_API_URL", "https://www.msegat.com/gw/sendsms.php"),
    "api_key" => env("MSEGAT_API_KEY", ""),
    "username" => env("MSEGAT_USERNAME", ""),
    "sender" => env("MSEGAT_SENDER", ""),
    "unicode" => env("MSEGAT_UNICODE", "UTF8"),
];
