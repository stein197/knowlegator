# Testing
## Execution
1. If tests are run for the first time, initialize a test database and populate with data: `composer migrate:reseed`
2. Run `artisan test`

## Structure
- Structure of the [`/tests/Feature/`](/tests/Feature/) folder should be compliant to the structure of the [`/app/`](/app/)
- Test files should use Pest style instead of PHPUnit
- If testing routes, description of the test should contain the route in format `<method> <route>`. For example, the description for testing a route `/{locale}/login` should contain a string like "GET /{locale}/login"
- Unauthorized users should be called "guest", authorised ones - "user"
- `test()` function should be used instead of `it()`
- Instead of creating new data for testing, use the data defined in the [`/database/seeders/DatabaseSeeder.php`](/database/seeders/DatabaseSeeder.php)
