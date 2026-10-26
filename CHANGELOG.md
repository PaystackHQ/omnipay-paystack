# Changelog

All Notable changes to `omnipay-paystack` will be documented in this file

## NEXT - YYYY-MM-DD

### Added

-   PHP 8 support (`"php": "^7.2 || ^8.0"`), so the package installs on the PHP releases from the 21 Oct 2026 security update (GHSA-w8hw-w9fx-j79w, GHSA-6wmf-4rv5-p3rp): 8.2.35, 8.3.36, 8.4.27, 8.5.12
-   GitHub Actions test matrix for PHP 7.2–8.5, failing on PHP deprecations, warnings and notices on PHPUnit 10+
-   Tests for `completePurchase()` (success, declined, unknown reference, partial payload) and for failed purchase and refund responses

### Deprecated

-   Nothing

### Fixed

-   Implicitly nullable `$data` parameter in `AbstractRequest::sendRequest()`, which is deprecated in PHP 8.4
-   "Undefined array key" warnings on PHP 8 when the Paystack API returns an error or partial payload. Return values are unchanged
-   Passing `null` to `rawurlencode()` when `completePurchase()` is sent without a transaction reference (deprecated in PHP 8.1)

### Removed

-   Travis CI config (`.travis.yml`), replaced by GitHub Actions
-   `phpro/grumphp` dev dependency and `grumphp.yml`: version 0.14 only installs with Composer 1, and current versions require PHP 8.2+
-   PHP 7.0 and 7.1 support: the nullable type in `sendRequest()` and the test tools need PHP 7.2+. Composer keeps those projects on the previous release
-   Scrutinizer `external_code_coverage`: coverage was uploaded from Travis CI, which is removed

### Security

-   Nothing
