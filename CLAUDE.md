# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- filament/filament (FILAMENT) - v5
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v4
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>

# Project Overview

This is a Technical Support System built with Laravel 13, featuring a dual authentication system with separate user and admin interfaces using Filament v5 for the admin panel.

## Architecture

### Dual Authentication System

The application implements two separate authentication guards:

- **User Authentication**: Standard Laravel authentication for end users accessing the main application
  - Guard: `web`
  - Model: `App\Models\User`
  - Provider: `users`
  - Routes: Standard web routes (`/`)

- **Admin Authentication**: Separate authentication system for administrators accessing Filament admin panel
  - Guard: `admin`
  - Model: `App\Models\Admin`
  - Provider: `admins`
  - Routes: Filament admin panel (`/admin`)

### Filament Admin Panel

The Filament admin panel is configured in `app/Providers/Filament/AdminPanelProvider.php`:

- Panel ID: `admin`
- Path: `/admin`
- Authentication guard: `admin`
- Primary color: Amber
- Resources, pages, and widgets are auto-discovered from `app/Filament/`

### Database Structure

The application uses MySQL with the following key tables:

- `users`: Standard Laravel users table for end-user authentication
- `admins`: Separate table for admin authentication (created via migration)
- Standard Laravel tables: `jobs`, `cache`, `password_reset_tokens`, etc.

## Common Development Commands

### Development Environment

```bash
# Start full development stack (server, queue, logs, vite)
composer run dev

# Start individual services
php artisan serve              # Laravel server
php artisan queue:listen        # Queue worker
php artisan pail                # Log monitoring
npm run dev                      # Vite dev server

# Start dev server with multiple PHP workers
PHP_CLI_SERVER_WORKERS=4 php artisan serve
```

### Testing

```bash
# Run all tests
php artisan test --compact

# Run specific test
php artisan test --compact --filter=testName

# Run tests with Pest
vendor/bin/pest
```

### Database Operations

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (use with caution in development)
php artisan migrate:fresh

# Create new migration
php artisan make:migration create_table_name

# Inspect database schema
php artisan db:show
php artisan db:table users
```

### Code Quality

```bash
# Format PHP code with Pint
vendor/bin/pint --dirty --format agent

# Create new test
php artisan make:test --pest FeatureNameTest
```

### Filament Development

```bash
# Create Filament resource
php artisan make:filament-resource ResourceName

# Create Filament page
php artisan make:filament-page PageName

# Create Filament widget
php artisan make:filament-widget WidgetName
```

### Frontend Development

```bash
# Build assets for production
npm run build

# Start Vite dev server
npm run dev

# Install dependencies
npm install
```

## Project Structure

```
app/
├── Models/
│   ├── User.php           # End-user model (web authentication)
│   └── Admin.php          # Admin model (Filament authentication)
├── Providers/
│   └── Filament/
│       └── AdminPanelProvider.php  # Filament panel configuration
├── Filament/              # Filament resources, pages, widgets (auto-discovered)
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
└── Http/
    └── Controllers/       # Application controllers

database/
├── migrations/            # Database migrations
├── factories/             # Model factories
└── seeders/               # Database seeders

resources/
├── views/                 # Blade templates
├── css/                   # Tailwind CSS (v4)
└── js/                    # JavaScript files

routes/
├── web.php                # Web routes
└── admin.php              # Admin routes (if custom)

tests/
├── Feature/               # Feature tests (Pest)
├── Unit/                  # Unit tests (Pest)
└── Pest.php               # Pest configuration
```

## Authentication & Authorization

### User Authentication

Standard Laravel authentication using session-based auth guard `web`. Users access the main application interface.

### Admin Authentication

Separate authentication system using Filament. Admins authenticate via `/admin` route using the `admin` guard. The `Admin` model implements `FilamentUser` interface with `canAccessPanel()` method.

## Frontend Stack

- **CSS Framework**: Tailwind CSS v4 with Vite integration
- **Build Tool**: Vite with Laravel Vite Plugin
- **Font**: Instrument Sans (via Bunny fonts)
- **Features**: Dark mode support, responsive design

## Key Configuration Files

- `config/auth.php`: Authentication guard configuration for both users and admins
- `vite.config.js`: Frontend build configuration with Tailwind integration
- `boost.json`: Laravel Boost configuration
- `.mcp.json`: MCP server configuration for Laravel Boost

## Testing Philosophy

- Use Pest v4 for all new tests
- Prefer feature tests over unit tests
- Use factories for test data generation
- Tests are organized in `tests/Feature/` and `tests/Unit/`
- Test configuration in `tests/Pest.php`

## Development Workflow

1. Use `composer run dev` for full-stack development
2. Follow Laravel Boost guidelines for all code changes
3. Run Pint formatting before committing PHP changes
4. Write tests for new functionality using Pest
5. Use Filament for admin interface features
6. Keep frontend assets built with Vite for production

## Important Notes

- The application uses dual authentication - always consider which guard/model you're working with
- Filament resources are auto-discovered from `app/Filament/Resources/`
- Use the `fake()` helper in tests, not `$this->faker`
- Database uses MySQL - ensure connection is properly configured in `.env`
- Vite hot module replacement requires `npm run dev` during development
- Filament panel uses Amber as primary color scheme