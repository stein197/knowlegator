# Views
The [views folder](/resources/views) have the next structure:
- `components/`: Blade components
- `page/`: complete page views to be used
- `resource/{type}/{action}.blade.php`: templates for resource controllers
- `template/`: templates to be extended and used by pages

## Blade Directives
The next custom Blade directives are defined:
- [`@null`](/app/Providers/AppProvider.php): if-like statement that checks if the passed variable is null
