# PHP API Wrapper for tesmart KVM Switches

**Note:** This is **not** an official library, nor is it related to tesmart in any way.

This library implements the HDMI Switch (KVM) communication protocol by tesmart and provides
a simple PHP wrapper to control the switch.

## Tested with

This library has only been tested with the 16x1 tesmart KVM switch.

## Current features

Currently, this library supports the following actions:

| Description              | Method                              |
|--------------------------|-------------------------------------|
| get current active input | `getInput(): int`                   |
| switch to given input    | `setInput(int $input): void`        |
| set LED timeout settings | `setLedTimeout(int $seconds): void` |
| mute/unmute buzzer       | `setBuzzer(bool $enabled): void`    |

## Requirements

The only requirements for this library are **PHP 8.0+** and composer. 

## Usage

See `example.php` for a simple CLI script to get and switch inputs.

1. Add to your project:

```bash
composer require karimgeiger/tesmart-api
```

2. Initialize the client in your project:

```php
$client = new \TesmartApi\Client('192.168.10.10', 5000);
```

3. Use the client:

```php
$client->getInput()
```