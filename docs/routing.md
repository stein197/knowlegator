# Routing
The routes only exist inside the root locale. Accessing to `/` and `/{locale}` redirects to the main page. There is no trailing slash for routes.
- `/{locale}/login`: login page
- `/{locale}/logout`: logout page
- `/{locale}/settings`: user-related settings
	- `/password`: update password for a user
	- `/delete`: delete account
- `/{locale}/account`: main user data
	- `/entities`: resource route - entities
	- `/etypes`: resource route - entity types
	- `/tags`: resource route - tags

## Route::extendedResource()
A macro that works the same as `Route::resource($prefix, $Controller)` and adds an additional `<prefix>.delete` route.
