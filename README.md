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
- `generate-keys`: Generate APP_KEY for production environment

## Tests
**Frontend**

Run the project in dev mode (`composer server:dev`) and open the browser. Test logs are shown in the console.

**Backend**

Run `php artisan test`

## Commits
The project uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) with [gitmoji](https://gitmoji.dev/)

## TODO
- [ ] Add "Forget Password?" functionality
- [ ] Move theme saving from session to the database
