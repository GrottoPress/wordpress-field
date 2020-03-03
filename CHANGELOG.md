# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased] - 

### Fixed
- Fix media field type not working

## [0.8.4] - 2020-02-08

### Added
- Add support for PHP 7.4

## 0.8.3 - 2019-04-17

### Added
- Add `.gitattributes`

## 0.8.2 - 2019-04-16

### Fixed
- Fix composer dependency resolution failures in travis-ci

## 0.8.1 - 2019-04-16

### Added
- Add PHP 7.3 to travis-ci build matrix

## 0.8.0 - 2018-10-06

### Added
- Add TinyMCE editor field

### Changed
- Rename `LICENSE.md` TO `LICENSE`
- Move `lang/`, `lib/` to a new `src/` directory

## 0.7.1 - 2018-09-12

### Changed
- Update translations template

## 0.7.0 - 2018-09-12

### Added
- Add `.editorconfig`
- Add translations template

### Changed
- Rename `src/` directory to `lib/`

## 0.6.0 - 2018-07-05

### Changed
- Rename media modal field to `media` to avoid clash with native HTML file input field

## 0.5.1 - 2018-06-29

### Fixed
- Wrong class attribute for upload buttons

### Changed
- Use more specific type annotations for arrays in doc blocks

## 0.5.0 - 2018-03-06

### Changed
- Rename attributes from underscore-separated to camel-cased.

## 0.4.0 - 2018-03-02

### Added
- Set up [Travis-CI](https://travis-ci.org/GrottoPress/wordpress-field)
- `.security.txt`
- Shell script for tagging new releases

### Changed
- Update tests to be isolated unit tests

### Removed
- Replace PHPUnit with Codeception for tests

## 0.3.0 - 2017-09-28
### Changed
- Undo camelize render callbacks

## 0.2.0 - 2017-09-13
### Changed
- Code compliant with PSR-1, PSR-2 and PSR-4.

## 0.1.0 - 2017-08-23
### Added
- `Field` class
- Set up test suite with [PHPUnit](https://phpunit.de)
