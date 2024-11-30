# CLI
## Composer scripts
- `server`: Run server in production mode on port 80
- `server:dev`: Run server in development mode on port 80
- `generate-keys`: Generate APP_KEY for production environment

## Artisan commands
The naming of the commands should follow the next rules:
- All commands should be prefixed with the `app:` namespace
- Classnames should be the same as command names. For example - class [`App\Console\Commands\MakeService`](/app/Console/Commands/MakeService.php) defines a command `app:make:service`

### Available commands
- `app:make:field <field>`: Create a field and a view for it
- `app:make:record <record>`: create a new record in the `app/Records/` folder
- `app:make:service <service>`: create a new service in the `app/Services/` folder
