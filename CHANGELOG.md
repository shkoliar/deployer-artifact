# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.2] - 2024-04-05
### Fixed
-  Fix php 8.2 deprecation notice: using ${var}

## [0.2.1] - 2022-06-09
### Fixed
- Remove an existing remote artifact to force a re-download, because the wget -c (continue) option doesn't handle 
properly a situation where the S3 file is completely different but with the same filename.
- Remove version from composer.json

## [0.2.0] - 2022-05-12
### Added
- Add recipe for downloading artifacts from S3
### Changed
- Major BC breaks as the underlying artifact deployment framework was refactored into multiple recipes.

## [0.1.0] - 2022-05-02
Initial release