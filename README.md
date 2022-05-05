# Backpack\SongsCRUD

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An admin panel for news articles on Laravel 5-9, using [Backpack\CRUD](https://github.com/Laravel-Backpack/crud). Write articles, with categories and tags.


> ### Security updates and breaking changes
> Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.



## Requirements

This package requires both `backpack/crud` but also `backpack/pro` (the paid addon). If you do NOT have access to `backpack/pro` you can [purchase it here](https://backpackforlaravel.com/pricing). Alternatively, you can use the installation method (A), then:
- remove all PRO features;
- replace PRO fields with FREE fields;


## Installation

Since SongsCRUD is just a Backpack\CRUD example, you can choose to install it one of two ways.

** Download and place files in your application** (recommended; remember to also ```composer require cviebrock/eloquent-sluggable```)

1) In your terminal, run:

``` bash
composer require sequelone/songs-crud
```

2) Publish the migration:

```
php artisan vendor:publish --provider="SequelONE\SongsCRUD\SongsCRUDServiceProvider"
```

3) Run the migration to have the database table we need:

```
php artisan migrate
```

4) [optional] Add a menu item for it in `resources/views/vendor/backpack/base/inc/sidebar.blade.php` or `menu.blade.php`:

```html
<!-- Songs -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-diamond"></i>{{ trans('songs-crud::songscrud.music') }}</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs/releases') }}"><i class="nav-icon la la-microphone"></i> {{ trans('songs-crud::songscrud.releases') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs/labels') }}"><i class="nav-icon la la-star"></i> {{ trans('songs-crud::songscrud.labels') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs/artists') }}"><i class="nav-icon la la-users"></i> {{ trans('songs-crud::songscrud.artists') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs/types') }}"><i class="nav-icon la la-check-square-o"></i> {{ trans('songs-crud::songscrud.types') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs/genres') }}"><i class="nav-icon la la-list-ul"></i> {{ trans('songs-crud::songscrud.genres') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('songs') }}"><i class="nav-icon la la-music"></i> {{ trans('songs-crud::songscrud.tracks') }}</a></li>
    </ul>
</li>
```

5) [optional] If you need the browse field to upload images, please install [Laravel-Backpack/FileManager](https://github.com/Laravel-Backpack/FileManager#installation).

## Extra Field Type

### Shortlink

Generates short links by click. You can add a new field type.

```
$this->crud->addField([
    'name' => 'shortlink',
    'label' => 'Shortlink (URL)',
    'type' => 'shortlink',
    'generate' => 'small_alphanumeric',
    'length' => 4,
    'hint' => 'Will be automatically generated from your name, if left empty.',
]);
```

The `length` parameter is responsible for the length of the generated short link. 

Example:
```
'generate' => 'small_alphanumeric',
'length' => 4,
```

Output:

```
d2f8
```

Available options for the `generate` parameter.

| **#** | **Variable**       | **Type**                                                                 |
|-------|--------------------|--------------------------------------------------------------------------|
| 1     | global             | 0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ |
| 2     | numeric            | 0123456789                                                               |
| 3     | small              | abcdefghijklmnopqrstuvwxyz                                               |
| 4     | small_alphanumeric | 0123456789abcdefghijklmnopqrstuvwxyz                                     |
| 5     | big                | ABCDEFGHIJKLMNOPQRSTUVWXYZ                                               |
| 6     | big_alphanumeric   | 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ                                     |
| 7     | special            | !@#$%^&*()                                                               |

### Upload Tracks

```
$this->crud->addField([
    'name' => 'shortlink',
    'label' => 'Shortlink (URL)',
    'type' => 'shortlink',
    'generate' => 'small_alphanumeric',
    'length' => 4,
    'hint' => 'Will be automatically generated from your name, if left empty.',
]);
```

Add in `/config/filesystems.php`

```
        'uploads' => [
            'driver' => 'local',
            'root'   => storage_path('uploads'), // that's where your backups are stored by default: storage/uploads
        ],

        'tracks' => [
            'driver' => 'local',
            'root'   => storage_path('uploads/tracks'), // that's where your backups are stored by default: storage/uploads
        ],

        'covers' => [
            'driver' => 'local',
            'root'   => storage_path('uploads/tracks/covers'), // that's where your backups are stored by default: storage/uploads
        ],
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Overwriting functionality

If you need to modify how this works in a project: 
- create a ```routes/backpack/songscrud.php``` file; the package will see that, and load _your_ routes file, instead of the one in the package; 
- create controllers/models that extend the ones in the package, and use those in your new routes file;
- modify anything you'd like in the new controllers/models;

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email tabacitu@backpackforlaravel.com instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://backpackforlaravel.com/newsletter)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

## Credits

- [Andrej Kopp][link-author]
- [All Contributors][link-contributors]

## License

Backpack is free for non-commercial use and Backpack PRO 69€/project for commercial use. Please see [License File](LICENSE.md) and [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

## Hire us

We've spend more than 10.000 hours creating, polishing and maintaining administration panels on Laravel. We've developed e-Commerce, e-Learning, ERPs, social networks, payment gateways and much more. We've worked on admin panels _so much_, that we've created one of the most popular software in its niche - just from making public what was repetitive in our projects.

If you are looking for a developer/team to help you build an admin panel on Laravel, look no further. You'll have a difficult time finding someone with more experience & enthusiasm for this. This is _what we do_. [Contact us - let's see if we can work together](https://backpackforlaravel.com/need-freelancer-or-development-team).


[ico-version]: https://img.shields.io/packagist/v/sequelone/SongsCRUD.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-dual-blue?style=flat-square
[ico-travis]: https://img.shields.io/travis/Laravel-Backpack/sequelone/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sequelone/SongsCRUD.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sequelone/SongsCRUD.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sequelone/SongsCRUD.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sequelone/SongsCRUD
[link-travis]: https://travis-ci.org/sequelone/SongsCRUD
[link-scrutinizer]: https://scrutinizer-ci.com/g/sequelone/SongsCRUD/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sequelone/SongsCRUD
[link-downloads]: https://packagist.org/packages/sequelone/SongsCRUD
[link-author]: https://github.com/SequelONE
[link-contributors]: ../../contributors
