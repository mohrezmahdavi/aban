# Session Auth Package For Client Microservices

## نصب

برای نصب پکیج ابتدا کد زیر را در فایل composer.json و در بخش require قرار دهید:

```json
"require": {
    "comma/aban": "2.x"
},
```

در مرحله بعد این خط کد را در فایل composer.json و در بخش repositories قرار دهید.

```json
"repositories": [
    {
        "type": "vcs",
        "url":  "https://gitlab.aanplatform.com/comma/aban.git"
    }
],
```

در نهایت پس از اعمال تغییرات در فایل composer.json ، از دستور زیر برای نصب پکیج استفاده کنید.

```bash
composer update
```

یا

```bash
composer install
```

پس از نصب کامل پکیج، با استفاده از دستور زیر فایل های config های پکیج را نصب کنید.

```bash
php artisan vendor:publish
```

نصب پکیج با موفقیت انجام شد.

برای ارسال پیام SSO از طریق کد زیر اقدام میکنیم:

```php
<?php
use Raahin\Aban\Facade\SSOClient;

$response = SSOClient::setApiKeyHttpHeader($apiKey)
    ->registerUserWithMobile($phone_number)
    ->loginGenerateOTPWithMobile($phone_number);

if ($response->status() != 200) {

    throw ValidationException::withMessages([
        'code' => $response->object()?->message,
        ]);
}
```

و سپس برای وریفای کردن کد ارسالی میتوان از طریق کد زیر اقدام کرد :

```php
<?php
use Raahin\Aban\Facade\SSOClient;

$response = SSOClient::setApiKeyHttpHeader($apiKey)
    ->registerUserWithMobile($phone_number)
    ->loginVerifyOTPWithMobile($phone_number , $this->code);

if ($response->status() != 200) {

    throw ValidationException::withMessages([
        'code' => $response->object()?->message,
        ]);
}
```

پس از این مرحله کاربر وریفای شده و میتواند وارد سامانه شود.
