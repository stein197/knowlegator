# Knowlegator

## Installation
1. Clone the repository
2. Install all dependencies by running `composer install` and `npm install`
3. Compile the frontend by running `npm run build`
4. Run PHP server by running `php artisan serve`
5. Open `http://localhost:8000` in a browser

## Frontend folder structure
The whole frontend is located in `resources/js`:
- `src/`: all TS source code. All the code within can be imported by using prefix `app/` (for example: `import App from "app/App"`)
- `index.ts`: entry point

## NPM scripts
- `build`: build frontend
- `build:watch`: build frontend in live mode
