# 🧩 Laravel Prodege MR API Package

A Laravel package for seamless integration with the **Prodege MR API**, featuring secure request signing, time offset handling, and robust response management — all wrapped in a clean, facade-based interface.

---

## 🚀 Features

- ✅ Signed API requests with SHA-256 HMAC
- 🕒 Time offset handling via `/lookup-request-time-offset`
- 🧱 Laravel Facade support (`ProdegeApi::post(...)`)
- 🧠 Smart response handling with automatic message normalization
- 🔧 Null implementation (`NullProdegeService`) for local/testing environments

---

## 📦 Installation

Install via [Packagist](https://packagist.org/):

```bash
composer require surender/prodege-api
```

## ⚙️ Configuration

```bash
php artisan vendor:publish --tag=prodege-config
```

## Set up your .env:

PRODEGE_API_KEY=your_api_key
PRODEGE_SECRET=your_secret
PRODEGE_BASE_URL=https://api.prodegemr.com

## ✅ Usage

```php

use Surender\ProdegeApi\Facades\ProdegeApi;

$response = ProdegeApi::post('project-create', [
    'project_id' => 1234001,
    'project_type_id' => 1,
    'project_name' => 'Test Project',
    'loi' => 60,
    'country_id' => 1,
    'project_url' => 'http://www.google.com/?tr_id=%transid%',
    'cpi' => 2.25,
    'mobile_optimized' => 'true',
    'sample_size' => 100,
    'expected_ir' => 90
]);

if ($response->isSuccess()) {
    return response()->json([
        'message' => $response->getMessage(),
        'response' => $response->toArray(),
    ]);
}

return response()->json([
    'message' => $response->getMessage(),
    'errors' => $response->getErrorCodes(),
    'response' => $response->toArray(),
], 422);

```

## 🧰 Utilities

Generate Signed URL

```php
$url = ProdegeApi::generateSignedUrl('target-endpoint', ['key' => 'value']);
```

Generate Signed Params

```php
$params = ProdegeApi::generateSignedParams(['key' => 'value']);
```

## 🧪 Testing in Local Environment

Prevent real API calls using the NullProdegeService:

```php
use Surender\ProdegeApi\Contracts\ProdegeApiInterface;
use Surender\ProdegeApi\Services\NullProdegeService;

$this->app->bind(ProdegeApiInterface::class, NullProdegeService::class);
```

## 🔍 ResponseHandler Methods

Method Description

- isSuccess() Returns true if status_id is 1
- getMessage() Gets first message (handles string or array)
- getMessages() Gets all messages as array
- getErrorCodes() Returns any error codes
- toArray() Returns the raw API response

## 📄 License

- MIT License. See LICENSE file.

## 🙌 Contributing

- Pull requests and issues are welcome! If you're planning a big change, open an issue first to discuss.

Let me know if you want a sample Laravel controller, targeting payload format, or if you'd like me to generate a GitHub Actions workflow for automatic testing and tag-based version release 🚀
