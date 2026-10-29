# Paystack support for Omnipay

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Paystack support for Omnipay.

Requires PHP 7.2 or later. The test suite runs on PHP 7.2–8.5.

In production, use a supported PHP release that includes the 21 Oct 2026 security fixes for critical
remote code execution flaws (GHSA-w8hw-w9fx-j79w, GHSA-6wmf-4rv5-p3rp): **8.2.35, 8.3.36, 8.4.27,
8.5.12 or later** ([php.net advisory](https://www.php.net/releases/8_2_35.php)). PHP 8.1 and older
no longer receive security fixes.

## Install

Install the gateway using require. Require the `league/omnipay` base package and this gateway.

```bash
$ composer require league/omnipay paystackhq/omnipay-paystack
```

## Usage

The following gateways are provided by this package:

-   Paystack (Offsite Redirect)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/paystackhq/omnipay-paystack/issues),
or better yet, fork the library and submit a pull request.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

-   [Paystack](https://github.com/paystackhq)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
