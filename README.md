# SHOP – Digital Account Service Website

Native PHP + PostgreSQL MVC stack for selling digital accounts/services without online payments.

## Requirements

- PHP 8.1+
- PostgreSQL 14+
- Composer (optional for helpers)

## Installation

1. Clone repo and install dependencies (none required).
2. Copy `.env.example` to `.env` (or set environment variables).
3. Create database and run migrations:
   ```bash
   psql -U postgres -d shop -f database/schema.sql
   ```
4. Configure web server document root to `public/` and enable URL rewriting.
5. Update `config/database.php` with credentials or use env vars.

## Features

- Three-level catalog with variants and option groups
- Bootstrap 5 responsive frontend with light/dark mode + popup logic
- Cart stored in DB without checkout, Buy Now redirects to contact
- Blog, reviews (anti-spam), footer/contact settings, popup/banner CMS
- Custom admin dashboard with OTP-only login, CSRF protection, prepared queries

## Structure

```
app/
  controllers/
  models/
  views/
core/
  Router.php, Model.php, Security.php, ...
public/
  index.php, assets/
database/
  schema.sql, migrations/
```

## Testing

- Lint PHP scripts with `php -l`
- Add PHPUnit tests inside `tests/`

## Security Notes

- Sessions use HTTP-only cookies, CSRF tokens on all forms
- OTP login only, no passwords stored
- Input sanitized via `Security::sanitize`, queries via PDO prepared statements

## Roadmap

- File upload handling
- Advanced logging and queue for OTP delivery

