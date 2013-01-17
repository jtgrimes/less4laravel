Less4Laravel
============

Allows you to use [Less](http://lesscss.org//) in [Laravel 4](http://laravel.com/) with
no fuss, no muss.

Installation
============

Add `jtgrimes\less4laravel` as a requirement to composer.json:

```javascript
{
    "require": {
        "jtgrimes/less4laravel": "0.1.*"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

Once Composer has installed or updated your packages you need to register 
Less4Laravel with Laravel itself. Open up `app/config/app.php` and 
find the providers key towards the bottom and add:

```php
'jtgrimes\Less4laravel\LessServiceProvider'
```

In the aliases section, add:

```php
'Less'	=>	'jtgrimes\Less4laravel\LessFacade'
```

Configuration
=============

In order to work with the configuration file, you're best off publishing a copy
with Artisan:

```
$ php artisan config:publish jtgrimes/less4laravel
```

The defaults are:
* Recompile whenever the .less file is updated.  (Recompilation only happens when the
named file is changed.  If other files are imported, changing them will *not* trigger
a recompile.)
* Store .less files in app/less
* Store generated .css files in public/css
* Link to /css/filename.css

All of these defaults can be changed in `/app/config/packages/jtgrimes/less4laravel.php`.

Additionally you can (and probably should) have different configurations for development 
and production.  Specifically, you probably don't want to be generating css files on
your production server, since it will slow down your site.


Usage
=====

In your view file, just call `Less:css('file')` to compile the .less file (if needed)
and generate a link to the output css file.



Artisan Commands
================

They're not implemented yet, but compiling .less files from Artisan is on the to-do 
list.



Credits
=======

Less4Laravel doesn't exist without Leaf Corcoran's [lessphp](http://leafo.net/lessphp/).  lessphp doesn't exist without 
[LESS](http://lesscss.org/). Less4Laravel also requires [Laravel](http://laravel.com/). The readme is largely boosted from
Rob Crowe's readme for (the very awesome) [TwigBridge](https://github.com/rcrowe/TwigBridge).
