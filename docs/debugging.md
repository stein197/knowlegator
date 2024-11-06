# Debugging
There are two ways to debug the application. For this purpose, there is a file [`.vscode/launch.json`](/.vscode/launch.json)

## Via browser
Using the [Xdebug helper for Chrome](https://chromewebstore.google.com/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc)

## Via CLI (Windows)
Set the `XDEBUG_CONFIG` environment variable like this:
```
set XDEBUG_CONFIG="idekey=VSCODE"
```
