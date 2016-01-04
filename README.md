Jade for Slim framework
=======================

<https://travis-ci.org/jlndk/slim-jade>

This is a helper for the Slim framework, that allows the use of jade-php,
together with Slim

Install
-------

Via [Composer](<https://getcomposer.org/>)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ composer require jlndk/slim-jade
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Requires Slim Framework 3 and PHP 5.4.0 or newer.

In order to use this specific fork, you'll need to update your composer.json
file manually at the repositories and the require section.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/urshofer/slim-jade"
  }
  ...
]

"require": {
  ...
  "jlndk/slim-jade": "dev-master"
  ...
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

### How to use

##### [The Jade Syntax Reference](<https://github.com/visionmedia/jade#readme>)

##### [Jade-php](<https://github.com/kylekatarnls/jade-php#whats-new->)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php
require 'vendor/autoload.php';

// Set up Slim

$settings = [
  'view' => [
    'template_path' => __DIR__ . '/../templates/',
    'cache_path' => __DIR__ . '/../cache/',
  ]
];
$app = new \Slim\Slim($settings);

// Configure Container

$container = $app->getContainer();

// View Renderer

$container['view'] = function ($c) {
  $settings = $c->get('settings')['view'];
  $view = new \Slim\Views\Jade(
    $settings['template_path'], 
    ['cache' => $settings['cache_path']]
  );
  return $view;
};

// Route rendering the index.jade file

$app->get('/', function ($request, $response, $args) {
  // Render index view
  $this->view->render($response, 'index.jade', $args);
});
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Contributing
------------

Please see [CONTRIBUTING](<CONTRIBUTING.md>) for details.

Credits
-------

-   [Jlndk](<https://github.com/jlndk>)

License
-------

The MIT License (MIT). Please see [License File](<LICENSE.md>) for more
information.
