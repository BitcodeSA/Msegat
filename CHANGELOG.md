# Changelog

### Version 2.0.1:
- remove unused code (logger,command,view,migration).
- fix :bug: in ```MsegatChannel.php```.
- add recevier key name to config.php .

### Version 2.0.0:

- Add ability to request otp.
- update to the Msegat class structure.
- add `log` config that allow you to send sms to log directly to use it you should add it to `env`
  as `MSEGAT_LOG = true`.
- relocate `unicode` and `sender` from `Msegat` class into `MsegatMessage` object.
- you can specify the time to send the message by calling `timeToExec("YYYY-MM-DD HH:i:ss")` method.
- request balance check from you account.
