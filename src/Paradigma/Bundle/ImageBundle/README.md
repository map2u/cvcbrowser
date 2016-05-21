ImageBundle
===========

[![Build Status](https://travis-ci.org/paradigmate/ImageBundle.png?branch=master)](https://travis-ci.org/paradigmate/ImageBundle)

This bundle provides an easy way to resize images in Symfony2. 
This bundle it's based on the resize.php class by Jarrod Oberto.
Requires php >=5.3, GD library and optional EXIF library.

``` php
<?php

class ImageController extends Controller
{
    public function userAction($user, $size) {
        $resize = $this->get('image_resizer')
            ->resize(
                $user->getImageFile(), 
                $user->getImageFile($size), 
                new ImageSize($size, $size), 
                ImageResizer::RESIZE_TYPE_CROP
            );
    }
}
```

## Installation

### Step 1: Install vendors

#### Symfony 2.0.x: `bin/vendors.php` method

If you're using the `bin/vendors.php` method to manage your vendor libraries,
add the following entries to the `deps` in the root of your project file:

```
[ParadigmateImageBundle]
    git=http://github.com/paradigmate/ImageBundle.git
    target=/bundles/Paradigma/Bundle/ImageBundle
```

Next, update your vendors by running:

``` bash
$ ./bin/vendors
```

Finally, add the following entries to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Paradigma'        => __DIR__.'/../vendor/bundles',
));
```

#### Symfony 2.1.x: Composer

[Composer](http://packagist.org/about-composer) is a project dependency manager for PHP. You have to list
your dependencies in a `composer.json` file:

``` json
{
    "require": {
        "paradigmate/image-bundle": "dev-master"
    }
}
```
To actually install ImageBundle in your project, download the composer binary and run it:

``` bash
wget http://getcomposer.org/composer.phar
# or
curl -O http://getcomposer.org/composer.phar

php composer.phar install
```

### Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Paradigma\Bundle\ImageBundle\ParadigmaImageBundle(),
    );
}
```

## Examples

It's possible to resize the images automatically, with corpping or priorizing the size in landscape or portrait.

``` php
<?php
...
$resize = $this->get('image_resizer')
    ->resize($filename, $filename_output, new ImageSize($size, $size), ImageResizer::RESIZE_TYPE_AUTO);
....
$resize = $this->get('image_resizer')
    ->resize($filename, $filename_output, new ImageSize($size, $size), ImageResizer::RESIZE_TYPE_CROP);
...
$resize = $this->get('image_resizer')
    ->resize($filename, $filename_output, new ImageSize($size, $size), ImageResizer::RESIZE_TYPE_EXACT);
...
$resize = $this->get('image_resizer')
    ->resize($filename, $filename_output, new ImageSize($size, $size), ImageResizer::RESIZE_TYPE_LANDSCAPE);
...
$resize = $this->get('image_resizer')
    ->resize($filename, $filename_output, new ImageSize($size, $size), ImageResizer::RESIZE_TYPE_PORTRAIT);
...
```

