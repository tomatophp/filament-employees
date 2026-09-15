![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/3x1io-tomato-employees.jpg)

# Filament Employees

[![Tests](https://github.com/tomatophp/filament-employees/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-employees/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-employees/version.svg)](https://packagist.org/packages/tomatophp/filament-employees)
[![License](https://poser.pugx.org/tomatophp/filament-employees/license.svg)](https://packagist.org/packages/tomatophp/filament-employees)
[![Downloads](https://poser.pugx.org/tomatophp/filament-employees/d/total.svg)](https://packagist.org/packages/tomatophp/filament-employees)

Manage your employees, shifts, attendance, payments, requests, payrolls and job applications on top of [Filament Accounts](https://github.com/tomatophp/filament-accounts) for FilamentPHP

## Screenshots

![Employees](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/employees-list-light.png)
![Employees Dark](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/employees-list-dark.png)
![Employee](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/employee-edit-light.png)
![Employee Dark](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/employee-edit-dark.png)
![Applies](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/applies-list-light.png)
![Applies Dark](https://raw.githubusercontent.com/tomatophp/filament-employees/master/arts/applies-list-dark.png)

## Features

- [x] Employees resource (accounts with the `employee` type) with profile, national info, education, CV links, auth, attendance, salary, bank and insurance sections
- [x] Attendance, payments, requests and payrolls relation managers, with delay / overtime calculated from the employee shift and the payroll total from the employee salary
- [x] Shifts resource
- [x] Job applications resource with HR / tech approval
- [x] Settings pages for departments, payment reasons, payment statuses, request statuses and application statuses (powered by [Filament Types](https://github.com/tomatophp/filament-types))

## Compatibility

| Package version | Filament | Laravel    | PHP  |
|-----------------|----------|------------|------|
| 5.x             | 5.x      | 12.x, 13.x | 8.2+ |
| 1.x             | 3.x      | 10.x, 11.x | 8.1+ |

## Installation

```bash
composer require tomatophp/filament-employees:^5.0
```

after install your package please run this command

```bash
php artisan filament-employees:install
```

### Account model

Employees are accounts from [Filament Accounts](https://github.com/tomatophp/filament-accounts), and the employee profile is stored with [Filament Meta](https://github.com/tomatophp/filament-meta). Publish the account model and add the `IsEmployee` trait to it

```bash
php artisan vendor:publish --tag="filament-accounts-model"
php artisan vendor:publish --tag="filament-accounts-config"
```

```php
use TomatoPHP\FilamentEmployees\Traits\IsEmployee;

class Account extends Authenticatable implements HasAvatar, HasMedia
{
    use IsEmployee;
    // ...
}
```

then point the accounts config to your model on `config/filament-accounts.php`

```php
'model' => \App\Models\Account::class,
```

### Register the plugin

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentEmployees\FilamentEmployeesPlugin::make())
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-employees-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-employees-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-employees-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-employees-migrations"
```

## Testing

if you like to run `PEST` testing just use this command

```bash
composer test
```

## Code Style

if you like to fix the code style just use this command

```bash
composer format
```

## PHPStan

if you like to check the code by `PHPStan` just use this command

```bash
composer analyse
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
