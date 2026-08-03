# CryptoPips

PHP/MySQL foundation for a cryptocurrency paper-trading platform. The first milestone includes a responsive landing page, secure registration and login, role-based user/admin dashboards, a USDT wallet, and immutable-ledger foundations.

## Hostinger setup

1. Copy `.env.example` to `.env` in Hostinger File Manager.
2. Put the private MySQL password in `.env`; never commit `.env` to GitHub.
3. Import `database/schema.sql` using phpMyAdmin.
4. Upload the project contents to `public_html`.
5. Open the temporary domain and register the first account.
6. To make that account an admin, run this once in phpMyAdmin, using the correct email:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

Requires PHP 8.1+ with PDO MySQL and MariaDB/MySQL.

## Current scope

- Account registration and login with `password_hash`
- CSRF protection and hardened session cookies
- Prepared SQL statements
- User and administrator authorization
- USDT wallet created atomically with each account
- Ledger and admin-audit database tables
- No real deposits, withdrawals, or custody

Trading, live prices, leverage, deposits, withdrawals, and approval workflows will be implemented as separate milestones.
