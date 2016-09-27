# PHP Pure's Themer

A template, the converts markdown `.md` files into well static html page, depending on the theme you will use.

## Index
- [The Factory](#the-factory)
- [Themes](#themes)
- [Test](#test)
- [Writing your own Theme](#writing-your-own-theme)

# <a href="#the-factory" name="the-factory">The Factory</a>

We have a factory that handles combines all the processes and calls the themes you need.

### $map

Just a map for our markdowns.

```php
$map = [
    'Prologue' => [
        'Setup' => __DIR__.'/docs/prologue/setup.md',
        'Change Log' => __DIR__.'/docs/prologue/change_log.md',
    ],
];
```

### $view_variables

You can freely pass a variable in the factory. Please take a note that this variables will be over-written/added a new variable when you will be using a different theme.

```php
$view_variables = [
    'uri' => 'http://example.com',
    'title' => 'My Documentation',
    // and so on ...
];
```

Finally to call the factory, Please take a note that the below code is still incomplete, that we still need to review how the theme works.

```php
<?php

$map = [...];
$view_variables = [...];

$factory = new PhpPure\Themer\Factory($map, $theme_variables, $view_variables);
```

# <a href="#themes" name="themes">Themes</a>

We're using <a target="_blank" href="https://laravel.com/docs/blade">Laravel's Blade Component</a> to handle the views.

PHP Pure has a theme that we could use for documentation, and that is the `basic` template that we added in the core.

```php
$basic = new PhpPure\Themer\Themes\Basic\Basic;
$basic->setViewsDir(__DIR__.'/views');
$basic->setCacheDir(__DIR__.'/views/.cache');
```

The above code, we instantiated the `Basic` class, we set the `views` folder, and also the `cache` folder.

The `Basic` Theme requires us to inject a theme variables in the factory, we must inject the `extension` and `landing_page`.

```php
$theme_variables = [
    'extension' => 'html',
    'landing_page' => $map['Prologue']['Setup'],
];
```

To finalize the factory, check code below.

```php
...

$factory->theme($basic);
$factory->generate('public/'); // the folder to generate with
```

# <a href="#test" name="test">Test</a>

We have a sample tests that your could try out or mimic.

# <a href="#writing-your-own-theme" name="writing-your-own-theme">Writing your own Theme</a>

I can't write everything here, so maybe let's move on to our [wiki](https://github.com/php-pure/themer/wiki).
