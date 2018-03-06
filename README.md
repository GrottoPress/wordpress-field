# WordPress Field

## Description

*WordPress Field* is a simple library to render form fields in WordPress.

## Usage

Install via composer:

`composer require grottopress/wordpress-field`

Instantiate and use thus:

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
