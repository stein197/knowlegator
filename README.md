# Knowlegator

## Installation
1. Clone the repository
2. Install all dependencies by running `composer install` and `npm install`
3. Compile the frontend by running `npm run build`
4. Run PHP server by running `php artisan serve`
5. Open `http://localhost:8000` in a browser

## Project dependencies
**Client:**
- React
- Bootstrap
- Bootstrap Icons
- flag-icons
- TypeScript
- Webpack

**Server:**
- Laravel
- CaptainHook

## Frontend folder structure
- `resources/js/`:
	- `src/`: all TypeScript source code. All the code within can be imported by using prefix `app/` (for example: `import App from "app/App"`)
		- `view/`: all React components
	- `index.ts`: entry point

## Backed structure
- `resources/views/`
	- `page/`: complete page view to be used
	- `template/`: templates to be extended and used by pages

## NPM scripts
- `build`: build the frontend in the production mode
- `build:dev`: build the frontend in the development mode
- `build:watch`: build the frontend in the development live mode
- `clean`: delete compiled JS files

## Tests
In order to run backend-tests, run `php artisan test`

## Commits
The project uses [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) with [gitmoji](https://gitmoji.dev/)
