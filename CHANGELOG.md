# Changelog

### Version 2.1.0

- add message model to log message send.
- you can link message with any notifiable model to get its messages.

### Version 2.0.1:

- remove unused code (logger,command,view,migration).
- fix :bug: in `MsegatChannel.php`.
- add recevier key name to config.php .

### Version 2.0.0:

- Add ability to request otp.
- update to the Msegat class structure.
- add `log` config that allow you to send sms to log directly to use it you should add it to `env`
  as `MSEGAT_LOG = true`.
- relocate `unicode` and `sender` from `Msegat` class into `MsegatMessage` object.
- you can specify the time to send the message by calling `timeToExec("YYYY-MM-DD HH:i:ss")` method.
- request balance check from you account.

## 2.3.0 - 2024-10-29

### What's Changed

* Update composer.json by @Abather in https://github.com/BitcodeSA/Msegat/pull/2

### New Contributors

* @Abather made their first contribution in https://github.com/BitcodeSA/Msegat/pull/2

**Full Changelog**: https://github.com/BitcodeSA/Msegat/compare/2.2.0...2.3.0

## 2.2.0 - 2024-05-15

**Full Changelog**: https://github.com/BitcodeSA/Msegat/compare/2.1.1...2.2.0

## 2.1.1 - 2024-05-15

**Full Changelog**: https://github.com/BitcodeSA/Msegat/compare/2.1.0...2.1.1

## 2.1.0 - 2024-02-06

2.1.0
