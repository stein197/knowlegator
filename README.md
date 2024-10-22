# Knowlegator

## Installation
1. Clone the repository
2. Install all dependencies by running `composer install`
3. Optionally: run `composer generate-keys`
4. Run PHP server by running `composer server`
5. Open `http://localhost` in a browser

## Project dependencies
**Client:**
- jQuery
- JUnit
- Bootstrap
- Bootstrap Icons
- flag-icons

**Server:**
- Laravel
- CaptainHook

## Frontend structure
- `public/`
	- `index.css`: main styles
	- `index.js`: entry point for main JS code
	- `index.test.js`: QUnit tests. They are included only in testing mode

## Backend structure
- `resources/views/`
	- `components/`: Blade components
	- `page/`: complete page views to be used
	- `template/`: templates to be extended and used by pages

## Composer scripts
- `server`: Run server in production mode on port 80
- `server:dev`: Run server in development mode on port 80
- `server:test`: Run server in test mode on port 80 and include QUnit tests
- `generate-keys`: Generate APP_KEY keys for production and testing environments

## Tests
**Frontend**

Run the project in testing mode (`composer server:test`) and open the browser

**Backend**

Run `php artisan test`

## Commits
The project uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) with [gitmoji](https://gitmoji.dev/)
