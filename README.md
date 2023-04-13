# WordPress Field

## Description

*WordPress Field* is a simple library to render form fields in WordPress.

## Installation

Install via composer: `composer require grottopress/wordpress-field`

## Usage

```php
<?php

use GrottoPress\WordPress\Form\Field;

// Text field
$text = new Field([
    'id' => 'field-id',
    'name' => 'field-name',
    'type' => 'text',
    'value' => 'My awesome text field',
    'label' => 'My text field',
]);

// Render text field
echo $text->render();

// Radio buttons
$radio = new Field([
    'id' => 'field-id',
    'name' => 'field-name',
    'type' => 'radio',
    'value' => 'my-choice',
    'choices' => [
        'one' => 'One',
        'my-choice' => 'My Choice',
        'two' => 'Two',
    ],
]);

// Render radio field
echo $radio->render();

// Dropdown
$dropdown = new Field([
    'id' => 'field-id',
    'name' => 'field-name',
    'type' => 'select',
    'value' => 'my-choice',
    'choices' => [
        'one' => 'One',
        'my-choice' => 'My Choice',
        'two' => 'Two',
    ],
]);

// Render dropdown field
echo $dropdown->render();

// Multi-select dropdown
$mdrop = new Field([
    'id' => 'field-id',
    'name' => 'field-name',
    'type' => 'radio',
    'value' => 'my-choice',
    'choices' => [
        'one' => 'One',
        'my-choice' => 'My Choice',
        'two' => 'Two',
    ],
    'meta' => [
        'multiple' => 'multiple',
    ],
]);

// Render multi-select dropdown
echo $mdrop->render();

// Categories dropdown
$catsdrop = new Field([
    'type' => 'wp_dropdown_categories', // callable WP function
    'callbackArgs' => [ // Args to pass to callable function
        [ // @see https://developer.wordpress.org/reference/functions/wp_dropdown_categories/
            'show_option_none'   => '--',
            'echo'               => 0,
            'selected'           => 22,
            'name'               => 'field-name',
            'id'                 => 'field-id',
            'taxonomy'           => 'category',
        ],
    ],
]);

// Render categories dropdown
echo $catsdrop->render();
```

## Development

Run tests with `composer run test`.

## Contributing

1. [Fork it](https://github.com/GrottoPress/wordpress-field/fork)
1. Switch to the `master` branch: `git checkout master`
1. Create your feature branch: `git checkout -b my-new-feature`
1. Make your changes, updating changelog and documentation as appropriate.
1. Commit your changes: `git commit`
1. Push to the branch: `git push origin my-new-feature`
1. Submit a new *Pull Request* against the `GrottoPress:master` branch.
