# MT-Times

A martial-arts blog with a full **admin panel**, **user roles**, and **permission-based access control** — built in vanilla PHP with a small hand-rolled service container.

This was my first larger project. Routing is done with **query parameters** (`index.php?route=...`) rather than pretty URLs, because at the time I hadn't yet learned how to build a router — something I later solved from scratch in my [Vanilla Core](https://github.com/devalexmuha/vanilla-framework/) framework.

## Features

- **Public blog** — home feed and single-post pages
- **Admin panel** — create, edit, and delete posts, with image uploads
- **Roles & permissions:**
  - **Super admin** — can edit and delete **any** admin's posts
  - **Admin** — can see, edit, and delete **only their own** posts
- **Authentication** — registration, login/logout, `password_hash` / `password_verify`, session fixation protection (`session_regenerate_id`)
- **CSRF protection** on state-changing requests
- Layered architecture — **Controllers → Services → Repositories → Models** with a DI container

## Architecture

```
public/index.php
  → Container         binds and resolves dependencies (PDO, repositories, services, controllers)
  → CsrfHelper        validates the CSRF token on every request
  → route dispatch    ?route=... maps to a controller action
      → AuthService   gates admin routes (log_in_checker, is_super_admin)
      → Controllers   Frontend + Admin
          → Repositories  data access (Users, Pages)
              → Models     typed records
```

A small **service container** (`app/Support/Container.php`) wires everything together with lazy `bind()` / `get()` closures — the same idea I later formalised in Vanilla Core.

## Requirements

- PHP 8.0+ (`pdo_mysql`, `mbstring`)
- MySQL / MariaDB
- Composer

## Setup

```bash
composer install
cp .env-example .env      # fill in DB_HOST, DB_NAME, DB_USER, DB_PASS
```

Import the database schema and seed data:

```bash
mysql -u <user> -p <database> < cms.sql
mysql -u <user> -p <database> < seed.sql
```

Serve the `public/` directory:

```bash
php -S localhost:8000 -t public
```

## Structure

```
├── public/index.php        # front controller + route table
├── app/
│   ├── Frontend/Controller # public blog
│   ├── Admin/Controller     # admin panel
│   ├── Service/AuthService  # auth, roles, permissions
│   ├── Repository/          # data access
│   ├── Model/               # typed records
│   └── Support/             # Container, CsrfHelper, adapters
├── inc/                     # bootstrap, DB connection, image handler
├── cms.sql · seed.sql       # schema + seed data
```

## Notes

The code is a bit rough in places — it's the project where I first wrestled with **roles, permissions, a DI container, CSRF, and secure sessions** at real scale. The query-param routing was the direct motivation for building a proper router later on.
