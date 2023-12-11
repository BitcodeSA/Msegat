# Notification Channel For Msegate msegat.com

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bitcodesa/msegat.svg?style=flat-square)](https://packagist.org/packages/bitcodesa/msegat)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bitcodesa/msegat/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bitcodesa/msegat/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bitcodesa/msegat.svg?style=flat-square)](https://packagist.org/packages/bitcodesa/msegat)

This package can be use to send SMS message using msegat.com provider.

## Installation

You can install the package via composer:

```bash
composer require bitcodesa/msegat
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="msegat-config"
```

This is the contents of the published config file:

```php
return [
    "api_url" => env("MSEGAT_API_URL", "https://www.msegat.com/gw/sendsms.php"),
    "api_key" => env("MSEGAT_API_KEY", ""),
    "username" => env("MSEGAT_USERNAME", ""),
    "sender" => env("MSEGAT_SENDER", ""),
    "unicode" => env("MSEGAT_UNICODE", "UTF8"),
];

```

## Setting up Msegat Service:

you have to get API Key, sender, and username from the provider you can get it by going to your dashboard at msegat.com.
add the provided data into env file:

```php
//other env configuration
MSEGAT_API_KEY="xxxxxxxxxxxxxxxxxxxxxxxxx"
MSEGAT_USERNAME="BITCODE"
MSEGAT_SENDER="BITCODE"
//other env configuration
```

## Usage

you can use channel by adding `BitcodeSa\Msegat\MsegatChannel::class` into `via()` method of you notification class.
You need to add `toMsegat()` method which should return `MsegatMessage()` object.

```php
<?php

namespace App\Notifications\ReservationNotifications;

use App\Models\Reservation;
use BitcodeSa\Msegat\MsegatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use BitcodeSa\Msegat\MsegatChannel;

class Reservation extends Notification
{
    use Queueable;
    protected Reservation $reservation;
    
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
    public function via(object $notifiable): array
    {
        return [
                    //Other Channels
                    MsegatChannel::class
                ];
    }

    public function toMsegat()
    {
        return new MsegatMessage($this->reservation->title);
    }
    //Other Channels and functions
}
```

### Notifiable Identifier:
The main identifier for the notifiable model is `phone`, to change it you have to add
`routeNotificationForMsegat()` to you notifiable model.

```php
class User extends Authenticatable 
{
    use Notifiable;
    
    public function routeNotificationForMsegat()
    {
        return $this->mobile;
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Abather](https://github.com/Abather)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
