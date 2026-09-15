# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (Livewire 4, PHP 8.2+); requires tomatophp/filament-accounts, filament-types and filament-meta ^5.0.
- The employee profile is stored with tomatophp/filament-meta: the `IsEmployee` trait now includes `HasMeta` (the account meta relation was removed from filament-accounts 2.3).
- Creating an employee always sets a username (email, then phone, then the name).
- Attendance: works for employees without a shift or a department, and saves who wrote the notes.
- Payroll: the total uses the configured account model and the salary from the employee profile.
- The users and accounts models come from the auth / filament-accounts config instead of `App\Models\*`.
- The payment reasons and payment status menu items no longer share an action name.
- `DatePicker` class name and account column labels fixed.
- The install command no longer runs `yarn install` / `yarn build` in the host app.
- The attendances and applies migrations drop the right table on rollback.
- New Pest test suite (every resource, page, relation manager and the install command), phpstan level 0 config and CI for Laravel 12/13 on PHP 8.3/8.4.
