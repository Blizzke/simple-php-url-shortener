# Simple PHP URL shortener

## Installation

1. Download the source code as located within this repository, and upload it to your web server.
2. Use `database.sql` to create the `redirect` table in a database of choice.
3. Rename `config.php.production` to `config.php`
4. Edit `config.php` and enter your database credentials.

## Features

* Redirect to your Twitter account when `@` is used as a slug, e.g. `http://mths.be/@` → `http://twitter.com/mathias`.
* Redirect to your main website when no slug is entered, e.g. `http://mths.be/` → `http://mathiasbynens.be/`.
* Ignores weird trailing characters (`!`, `"`, `#`, `$`, `%`, `&`, `'`, `(`, `)`, `*`, `+`, `,`, `-`, `.`, `/`, `@`, `:`, `;`, `<`, `=`, `>`, `[`, `\`, `]`, `^`, `_`, `{`, `|`, `}`, `~`) in slugs — useful when your short URL is run through a crappy link parser, e.g. `http://mths.be/aaa)` → same effect as visiting `http://mths.be/aaa`.
* Doesn’t create multiple short URLs when you try to shorten the same URL. In this case, the script will simply return the existing short URL for that long URL.
* DRY, minimal code.
* Correct, semantic use of the available HTTP status codes.
* Can be used with Twitter for iPhone. Just go to _Settings_ › _Services_ › _URL Shortening_ › _Custom…_ and enter `http://yourshortener.ext/shorten?url=%@`.

## Favelets / Bookmarklets

### Prompt

``` js
javascript:(function(){var%20q=prompt('URL:');if(q){document.location='http://yourshortener.ext/s/'+encodeURIComponent(q)}}());
```

### Shorten this URL

``` js
javascript:(function(){document.location='http://yourshortener.ext/s/'+encodeURIComponent(location.href)}());
````

## Fork Author
* [zeyus](http://zeyus.com/)

## Original Author

* [Mathias Bynens](http://mathiasbynens.be/)

## Original Contributors

* [Peter Beverloo](http://peter.sh/)
* [Tomislav Biscan](https://github.com/B-Scan)