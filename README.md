# Notification Channel For Msegate msegat.com

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bitcodesa/msegat.svg?style=flat-square)](https://packagist.org/packages/bitcodesa/msegat)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bitcodesa/msegat/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bitcodesa/msegat/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bitcodesa/msegat.svg?style=flat-square)](https://packagist.org/packages/bitcodesa/msegat)

## Laravel Msegat Notification Channel

This package provides a Laravel notification channel for sending SMS messages using the msegat.com SMS provider.

## Installation

1. **Install the package:**

```bash
composer require bitcodesa/msegat
```

2. **Publish the config file:**

```bash
php artisan vendor:publish --tag="msegat-config"
```

3. **Configure the package:**

Edit the published config file (`config/msegat.php`) with your Msegat credentials:

```php
return [
    "api_url" => env("MSEGAT_API_URL", "https://www.msegat.com/gw/sendsms.php"),
    "api_key" => env("MSEGAT_API_KEY", ""),
    "username" => env("MSEGAT_USERNAME", ""),
    "sender" => env("MSEGAT_SENDER", ""),
    "unicode" => env("MSEGAT_UNICODE", "UTF8"),
];
```

4. **Configure Msegat service:**

* **Get your credentials:**
    1. Create an account at msegat.com.
    2. Go to your dashboard.
    3. Obtain your API Key, Username, and Sender ID.
* **Set environment variables:**
    1. Open your `.env` file.
    2. Add the following lines, replacing the placeholder values with your credentials:

```php
# Msegat credentials
MSEGAT_API_KEY="xxxxxxxxxxxxxxxxxxxxxxxxx"
MSEGAT_USERNAME="BITCODE"
MSEGAT_SENDER="BITCODE"
```

## Usage

1. **Add the Msegat channel to your notification class:**

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
                    MsegatChannel::class,
                    // Other notification channels
                ];
    }

    public function toMsegat()
    {
        return new MsegatMessage($this->reservation->title);
    }
    // Other notification methods
}
```

Available Method for `MsegatMessage` object:

- `timeToExec("YYYY-MM-DD HH:i:SS")` allow you to specify the time that the message should be sent.
- `unicode("UTF8")` specify unicode for the message by default it is ***"UTF8"***.
- `type("TYPE_SMS")` specify message type you can choose between SMS or OTP.
- `sender($sender)` specify sender name.
- `lang("ar")` specify OTP language by defualt it is ***"ar"***

2. **Send the sms notification:**

```php
$user = User::find(1);
$user->notify(new Reservation($reservation));
```

3. **Send otp notification:**

***NOTE:This feature not working from the source `msegat.com`***

```php
$user = User::find(1);
$user->notify(new SendOtp($reservation));
```

`SendOtp` Class:

```php
class SendOtp extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return [MsegatChannel::class];
    }

    public function toMsegat()
    {
        return (new MsegatMessage())
            ->type(MsegatMessage::TYPE_OTP)
            ->lang("en");
    }
}
```

***NOTE:This feature not working from the source `msegat.com`***

### **Validate OTP:**

```php
$user = \App\Models\User::first();
$otp = new \BitcodeSa\Msegat\MsegatVerifyOtp();
$otp->validate($user, $code);
```

***NOTE:This feature not working from the source `msegat.com`***

## Notifiable Identifier

By default, the Msegat notification channel uses the `phone` property on the notifiable model to identify the recipient.
If your model uses a different attribute for phone numbers, you can override the default behavior by implementing
the `routeNotificationForMsegat()` method on your notifiable model:

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

This instructs the package to use the `mobile` attribute instead of `phone` to find the recipient's phone number.

## Additional Notes

* The package supports unicode messages.
* The package allows you to customize the sender name displayed on the recipient's phone.

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
