# Sessions & Login Audit for LaveroAdmin

View active admin sessions, revoke sessions remotely, and inspect login history.

## Requirements

- PHP >= 8.1
- `laveroadmin/laveroadmin`: `^1.0`

## Installation

```bash
composer require laveroadmin/sessions
php artisan migrate
php artisan admin:import sessions
```

## Features

- Automatically logs admin login, logout, and failed login attempts (`admin_login_logs` table)
- View active sessions with IP, User-Agent, and last activity
- Remote session revocation when using `SESSION_DRIVER=database`
- Full English and Russian localization

## License

The MIT License (MIT). See [LICENSE](LICENSE).
