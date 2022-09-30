# Rate Page

## A Kirby rating plugin with webmention support

![GitHub release](https://img.shields.io/github/release/mauricerenck/rate-page.svg?maxAge=1800) ![License](https://img.shields.io/github/license/mashape/apistatus.svg) ![Kirby Version](https://img.shields.io/badge/Kirby-3%2B-black.svg)

**I am looking for somebody taking over the development of this plugin as I don not have enough time anymore**

A Page Rating Plugin. Working without page reload and can also receive webmentions. Comes with a nice panel overview of all the ratings.

![panel view](doc-assets/panel.png)

If you like something without javascript and webmentions, please do have a look at https://getkirby.com/plugins/medienbaecker/likes

## Installation

- `composer require mauricerenck/ratepage`
- unzip [master.zip](https://github.com/mauricerenck/rate-page/releases/latest) to `site/plugins/ratepage`
- `git submodule add https://github.com/mauricerenck/rate-page.git site/plugins/ratepage`

## Config

Add your own emoji or html code in the config.php

```
[
    'thumb-up-symbol' => '👍',
    'thumb-down-symbol' => '👎',
    'enable-webmention-support' => false,
    'stars.symbol-empty' => '🌑',
    'stars.round' => true,
    'stars.showAvg' => true,
]
```

**Please make sure to prefix all the options with `mauricerenck.ratePage.`**. For example the debug option should be set in your `config.php` like so: `'mauricerenck.komments.debug' => true`

You can enable webmention support in the config. When doing so, you also have to install my webmention plugin (https://github.com/mauricerenck/tratschtante). You can then use a service like brid.gy/ to connect your twitter or mastodon account to webmentions.io. When someone likes you related tweed the like will be also added as a positive page rating.

## Usage

### five star rating

In your template, just load the snippet:

`<?php snippet('star-rating'); ?>`

Use this in your `<head />` to use the plugin css or write your own.
`<?php echo css('/media/plugins/mauricerenck/ratePage/stars.css'); ?>`

To style the stars, have a look at `assets/stars.css`. You can overwrite the following lines in your own css to add your own styling:

```
.rate-page__stars .rating > span.checked:before {
  content: "🌕";
}

.rate-page__stars .rating > span.half:before {
  content: "🌗";
}

.rate-page__stars .rating > span.fquarter:before {
  content: "🌘";
}

.rate-page__stars .rating > span.lquarter:before {
  content: "🌖";
}

.rate-page__stars .rating > span.user:before {
  content: "🌎";
}

.rate-page__stars .rating > span:hover:before,
.rate-page__stars .rating > span:hover ~ span:before {
  content: "🌎";
}
```

### thumb up/down

In your template, just load the snippet:

`<?php snippet('thumb-rating'); ?>`

Use this in your `<head />` to use the plugin css or write your own.
`<?php echo css('/media/plugins/mauricerenck/ratePage/thumbs.css'); ?>`

## Future Plans

- json-ld output
- panel fields
