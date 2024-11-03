# Routing
The routes only exist inside the root locale. Accessing to `/` and `/{locale}` redirects to main page. There is no trailing slash for routes.
- `/{locale}/login`: login page
- `/{locale}/logout`: logout page
- `/{locale}/settings`: user-related settings
- `/{locale}/account`: main user data

In order to show routes in the menu, those routes should be named. The name should be compliant with [translations](/docs/localization.md) `page.{page}.title`. For example, there is a settings menu and in order to show theme page in the menu, one needs to:
1. Name the corresponding menu with `settings.theme`. The nesting level should be equal to 2.
2. Define the correspoding translation with the key `page.settings.theme.title`.
