# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [2.1.0] - 2025-03-21
### Added
- Support for PHP 8.4

## [2.0.0] - 2020-12-03
### Added
- Support for PHP 8

### Removed
- Support for PHP 7.0 and 7.1

## [1.1.1] - 2018-08-10
### Fixed
- [#2] Re-throw exception that does not have a response

## [1.1.0] - 2018-08-04
### Added
- PSR-17 support

## [1.0.0] - 2018-01-27
### Added
- Improved testing and added code coverage reporting
- Added tests for PHP 7.2

### Changed
- Upgraded to the final version of PSR-15 `psr/http-server-middleware`

### Fixed
- Updated license year

## [0.3.0] - 2017-11-13
### Changed
- Replaced `http-interop/http-middleware` with  `http-interop/http-server-middleware`.

### Removed
- Removed support for PHP 5.x.

## [0.2.0] - 2017-09-21
### Changed
- Append `.dist` suffix to phpcs.xml and phpunit.xml files
- Changed the configuration of phpcs and php_cs
- Upgraded phpunit to the latest version and improved its config file
- Updated to `http-interop/http-middleware#0.5`

## 0.1.0 - 2017-04-08
First version

[#2]: https://github.com/middlewares/proxy/issues/2

[2.1.0]: https://github.com/middlewares/proxy/compare/v2.0.0...v2.1.0
[2.0.0]: https://github.com/middlewares/proxy/compare/v1.1.1...v2.0.0
[1.1.1]: https://github.com/middlewares/proxy/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/middlewares/proxy/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/middlewares/proxy/compare/v0.3.0...v1.0.0
[0.3.0]: https://github.com/middlewares/proxy/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/middlewares/proxy/compare/v0.1.0...v0.2.0
