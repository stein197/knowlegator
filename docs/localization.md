# Localization
There are three currently supported locales in the application: English, German and Russian. All localization files are located in the folder [`lang/`](/lang/) in JSON format. The localization can be changed in the dropdown menu in the header. The locale is defined in the URL.

## Rules and structure
Translation keys define categories separated by a dot. The next categories are available:
- `locale.*`: locale-related values
- `page.{page}`: translations depending on every page
- `page.{page}.title`: title and H1 for a page
- `resource.{resource}.{action}`: translations for resources
- `menu.{menu}.*`: menu-related translations
- `form.*`: form-related translations
- `form.field.{field}`: translations for fields
- `form.button.{button}`: translations for buttons
- `form.message.{field}.*`: error messages for fields
- `form.tooltip.{field}`: tooltips for form fields
- `table.*`: HTML table translations
- `table.{name}.caption`: table caption
- `table.{name}.col.{col}`: table column name
- `theme.{theme}`: theme-related translations
- `message.*`: messages that are shown in the template [`resources/views/page/message.blade.php`](/resources/views/page/message.blade.php)
- `rule.{rule}`: messages related to the validation rules in the [`App\Rules`](/app/Rules). The rule name should be the same as the class name.

## Testing
There is a test [`tests/Unit/LangTest.php`](/tests/Unit/LangTest.php). It tests the following:
- The folder exists
- A file with the defaul locale is defined
- All translation keys are defined in all locale files
- There are no hanging placeholders
- Function `__()` with a string literal as the first argument use existent translation
