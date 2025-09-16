# Wasender Extend

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alareqi/wasender-extend.svg?style=flat-square)](https://packagist.org/packages/alareqi/wasender-extend)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/alareqi/wasender-extend/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/alareqi/wasender-extend/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/alareqi/wasender-extend/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/alareqi/wasender-extend/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alareqi/wasender-extend.svg?style=flat-square)](https://packagist.org/packages/alareqi/wasender-extend)

**Wasender Extend** is a Laravel package that provides extended functionality for the Wasender WhatsApp messaging platform. This package adds essential API endpoints for WhatsApp session management, QR code generation, and contact verification, making it easier to integrate WhatsApp functionality into your Laravel applications.

## Features

- **WhatsApp Contact Verification**: Check if a phone number is registered on WhatsApp
- **QR Code Generation**: Generate QR codes for WhatsApp Web authentication
- **Session Management**: Check and manage WhatsApp session status
- **Device Management**: Handle WhatsApp device connections and status
- **API Authentication**: Secure API endpoints with user authentication and app key validation
- **Laravel Integration**: Seamless integration with Laravel applications using service providers and facades

## Requirements

- PHP 8.4 or higher
- Laravel 11.0 or 12.0
- A running WhatsApp server instance (WA_SERVER_URL environment variable)

## Installation

You can install the package via Composer:

```bash
composer require alareqi/wasender-extend
```

The package will automatically register its service provider and facade.

### Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="wasender-extend-config"
```

This will publish the configuration file to `config/wasender-extend.php`. Currently, the package uses environment variables for configuration.

### Environment Variables

Add the following environment variables to your `.env` file:

```env
# WhatsApp Server URL (required)
WA_SERVER_URL=http://your-whatsapp-server-url

# Optional: API rate limiting settings
# The package uses Laravel's built-in throttle middleware
```

### Database Requirements

The package expects the following database tables to exist in your application:

- `users` table with columns: `id`, `status`, `will_expire`, `authkey`
- `apps` table with columns: `id`, `key`, `status` and relationship to `devices`
- `devices` table with columns: `id`, `status`, `user_name`, `phone`, `qr`

These tables should be part of your main Wasender application.

## Usage

The package provides three main API endpoints for WhatsApp functionality. All endpoints require authentication via `authkey` and `appkey` parameters.

### Authentication

All API requests must include:

- `authkey`: User authentication key
- `appkey`: Application key associated with a WhatsApp device

### Available Endpoints

#### 1. Check if Number is on WhatsApp

**Endpoint:** `POST /api/misc/on-whatsapp`

Check if a phone number is registered on WhatsApp.

**Request:**

```json
{
    "authkey": "your-auth-key",
    "appkey": "your-app-key",
    "whatsapp_id": "1234567890"
}
```

**Response:**

```json
{
    "status": true,
    "message": "Number is on WhatsApp"
}
```

#### 2. Generate QR Code

**Endpoint:** `POST /api/qr`

Generate a QR code for WhatsApp Web authentication.

**Request:**

```json
{
    "authkey": "your-auth-key",
    "appkey": "your-app-key"
}
```

**Response:**

```json
{
    "qr": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...",
    "message": "QR code generated successfully"
}
```

#### 3. Check Session Status

**Endpoint:** `POST /api/check-session`

Check the current WhatsApp session status for a device.

**Request:**

```json
{
    "authkey": "your-auth-key",
    "appkey": "your-app-key"
}
```

**Response:**

```json
{
    "message": "Device Connected Successfully",
    "connected": true,
    "phone": "1234567890"
}
```

### Error Responses

All endpoints may return the following error responses:

**401 Unauthorized - Invalid Authentication:**

```json
{
    "error": "Invalid Auth and AppKey"
}
```

**401 Validation Error:**

```json
{
    "message": "Validation error",
    "errors": {
        "whatsapp_id": ["The whatsapp id field is required."]
    }
}
```

**404 Device Not Found:**

```json
{
    "message": "Device not found"
}
```

### Using the Facade

You can also use the package facade in your Laravel application:

```php
use Alareqi\WasenderExtend\Facades\WasenderExtend;

// The facade is available but the main functionality
// is provided through the API endpoints
```

### Using the Command

The package includes a basic Artisan command:

```bash
php artisan wasender-extend
```

## Testing

```bash
composer test
```

Run code analysis:

```bash
composer analyse
```

Format code:

```bash
composer format
```

## Package Structure

```
src/
├── Commands/
│   └── WasenderExtendCommand.php     # Artisan command
├── Facades/
│   └── WasenderExtend.php            # Package facade
├── Http/
│   └── Controllers/
│       └── Api/
│           └── MiscController.php    # Main API controller
├── WasenderExtend.php                # Main package class
└── WasenderExtendServiceProvider.php # Service provider
```

## Configuration

The package uses Laravel's service container and is configured through environment variables. The main configuration points are:

- **WA_SERVER_URL**: The URL of your WhatsApp server instance
- **Database Models**: The package expects `User`, `App`, and `Device` models to exist in your application
- **Middleware**: Uses Laravel's built-in `throttle:api` middleware for rate limiting

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ayman Alareqi](https://github.com/aymanalareqi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
