# Changelog

All notable changes to `wasender-extend` will be documented in this file.

## 1.0.8 - 2025-09-26

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.7...v1.0.8

## 1.0.7 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.6...v1.0.7

## 1.0.6 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.5...v1.0.6

## 1.0.5 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.4...v1.0.5

## 1.0.4 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.3...v1.0.4

## 1.0.3 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.2...v1.0.3

## 1.0.2 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.1...v1.0.2

## 1.0.1 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/compare/v1.0.0...v1.0.1

## 1.0.0 - 2025-09-16

**Full Changelog**: https://github.com/aymanalareqi/wasender-extend/commits/v1.0.0

## [1.0.0] - 2024-12-16

### Added

- **WhatsApp Contact Verification API**: Added `/api/misc/on-whatsapp` endpoint to check if a phone number is registered on WhatsApp
  
- **QR Code Generation API**: Added `/api/qr` endpoint to generate QR codes for WhatsApp Web authentication
  
- **Session Management API**: Added `/api/check-session` endpoint to check and manage WhatsApp session status
  
- **Authentication System**: Implemented secure API authentication using `authkey` and `appkey` parameters
  
- **Device Management**: Added functionality to handle WhatsApp device connections and status updates
  
- **Laravel Integration**:
  
  - Service Provider (`WasenderExtendServiceProvider`) for automatic package registration
  - Facade (`WasenderExtend`) for easy access to package functionality
  - Artisan Command (`wasender-extend`) for package operations
  
- **API Rate Limiting**: Integrated Laravel's throttle middleware for API protection
  
- **Error Handling**: Comprehensive error responses for authentication, validation, and device-related errors
  
- **HTTP Client Integration**: Built-in HTTP client for communicating with WhatsApp server instances
  
- **Database Integration**: Support for User, App, and Device models with proper relationships
  

### Features

- **MiscController**: Main API controller handling all WhatsApp-related operations
- **Route Registration**: Automatic API route registration with proper middleware
- **Environment Configuration**: Support for `WA_SERVER_URL` and other environment variables
- **Package Structure**: Well-organized package structure following Laravel best practices
- **Testing Setup**: PHPUnit and Pest testing framework integration
- **Code Quality**: PHPStan static analysis and Laravel Pint code formatting

### Requirements

- PHP 8.4 or higher
- Laravel 11.0 or 12.0
- WhatsApp server instance
- Database tables: users, apps, devices
