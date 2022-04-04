# PHP API Wrapper for TESmart KVM Switches

**Note:** This is **not** an official library, nor is it related to TESmart in any way.

This library implements the HDMI Switch (KVM) communication protocol by TESmart and provides
a simple PHP wrapper to control the switch.

## Tested with

This library has only been tested with the 16x1 TESmart KVM switch.

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
$client = new \TesmartApi\Client('192.168.1.10', 5000);
```

3. Use the client:

```php
$client->getInput()
```