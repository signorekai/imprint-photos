# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WordPress theme for Imprint Photos, built on [Timber](https://github.com/jarednova/timber/wiki) (Twig templating for WordPress). Requires the **Timber Library** and **ACF Pro** plugins.

## Commands

- **Compile SCSS (watch mode):** `make css` — uses nodemon + sass to watch `scss/` and output to `static/css/main.css`
- **Install PHP deps:** `composer install`
- **Run tests:** `phpunit` (requires WordPress test suite; see `bin/install-wp-tests.sh` for setup)
- **Deploy:** `make production` — pushes, merges develop→master, updates the `latest` tag

## Architecture

- **PHP templates** follow the WordPress template hierarchy (`page-home.php`, `single-portfolio.php`, etc.). Each calls `Timber::render()` passing context to a corresponding Twig file.
- **Twig templates** live in `templates/`. `base.twig` is the layout; partials are in `templates/partial/`.
- **`functions.php`** contains the `StarterSite` class which registers a custom `portfolio` post type (slug: `work`) with ACF fields (main_description, projects repeater with name/description/photos gallery). It also registers scripts, nav menus, custom image sizes (`gallery` 1200px, `hd` 1920×1080), and Twig filters (`slugify`).
- **`inc/customizer.php`** defines theme customizer settings (footer text/bg, SEO description/photo).
- **SCSS** in `scss/` compiles to `static/css/main.css`. Variables in `_vars.scss`, component styles in `scss/components/`.
- **Static assets** (JS, fonts, images) in `static/`. Key JS: `static/scripts/site.js` (barba.js page transitions), `static/scripts/f.js` (utilities).
- **Vendor JS** (masonry, rallax, barba, lightbox, modernizr) in `vendor/`.
