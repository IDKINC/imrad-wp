# Blank2
## Speed Up WordPress Development. Make More Money.

Blank2 is a blank wordpress to start off with. It includes Gulp functions to handle JS, SASS, BrowserSync, and more. 

## Gulp Functions

Make sure to sent the environment variables in the `gulpfile.js` to match your environment.

### gulp
Runs `gulp sass`, then `gulp js`, then finally `gulp serve`.

Use to start up development.

### gulp sass
Compiles the SASS from the `sassFiles` var, source maps it, and puts it in the `sassDest` folder;

Adds the standard Wordpress Header Comment to the top of `style.css` with Theme Name, Version, Repo Link, etc pulled from the `package.json` file. 

```
Don't add the header comment to style.scss
```

### gulp js
Pulls all the files from `jsFiles`, adds the source map, concats it down to `theme.js` and minifies it. Places output in `jsDest` folder.

### gulp watch
Watches both `watchSassFiles` and `watchJsFiles` and runs `gulp sass` and `gulp js` respectively.

### gulp serve
Starts browserSync proxying through `browserSyncProxy`.

Watches both `watchSassFiles` and `watchJsFiles` and runs `gulp sass` and `gulp js` respectively.

Reloads the page on `watchPhpFiles` change.

Reloads the page on `theme.js` change.


## Like the Theme? Wanna Buy Us A Beer?

If you like this Blank Wordpress Theme and would like to by us a beer, We'd be flattered.

| Paypal | Bitcoin | Litecoin |
|------------------------------------------------------------------------------------------------------------------|------------------------------------|------------------------------------|
| [![](assets/img/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3U4LLKF93P22J) | 1K5D3v1J36hQ3f25S3YYHVd9YpgKtUADfH | LSpqVw3gDwWgBcrBarX663TwZdGZrXfmQ7 |