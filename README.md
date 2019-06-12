# Wordpress Theme created by [Sulphur](http://sulphur.com.sg) for Imprint Photos 

## Wordpress Dependencies

- [Timber Library](https://wordpress.org/plugins/timber-library/)
- [ACF Pro](https://www.advancedcustomfields.com/)

## Dev Dependencies

- [Node JS](https://nodejs.org/en/)
- [Sass](https://sass-lang.com/) - I recommend `brew install sass/sass/sass`
- Nodemon

## For Dev

Check `Makefile` for list of scripts

## Project Structure

`static/` is where you can keep your static front-end scripts, styles, or images. In other words, your Sass files, JS files, fonts, and SVGs would live here.

`templates/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you'll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. Just an FYI.

## Other Resources

- [Main Timber Wiki](https://github.com/jarednova/timber/wiki) 
- [Twig for Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)

