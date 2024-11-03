# Knowlegator

## Installation
1. Clone the repository
2. Install all dependencies by running `composer install`
3. Optionally: run `composer generate-keys`
4. Run PHP server by running `composer server`
5. Open `http://localhost` in a browser

## Project dependencies
**Client:**
- Bootstrap
- Bootstrap Icons
- flag-icons

**Server:**
- Laravel

## Composer scripts
- `server`: Run server in production mode on port 80
- `server:dev`: Run server in development mode on port 80
- `generate-keys`: Generate APP_KEY for production environment

## Testing
Run `php artisan test`

## Commits
The project uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) with [gitmoji](https://gitmoji.dev/)

## Documentation
- [Localization](/docs/localization.md)
- [Routing](/docs/routing.md)
- [Views](/docs/views.md)
