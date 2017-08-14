<?php

/**
 * Pagination Tests
 *
 * @package GrottoPress\WordPress\Form
 * @subpackage GrottoPress\WordPress\Form\Tests
 *
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\WordPress\Form\Tests;

use GrottoPress\WordPress\Form\Field;

/**
 * Page test case
 *
 * @since 0.1.0
 */
class Field_Test extends \WP_UnitTestCase {
    private $dom;

    public function setUp() {
        $this->dom = new \DOMDocument();

        \register_post_type( 'tutorial', [
            'public' => true,
            'has_archive' => true,
            'rewrite' => [ 'slug' => 'tutorials', 'with_front' => false ],
            'taxonomy' => [ 'level' ],
        ] );

        \register_taxonomy( 'level', [ 'tutorial' ], [
            'rewrite' => [ 'with_front' => false ],
            'hierarchical' => true,
        ] );

        \wp_insert_term( 'basic', 'level' );

        $this->page_ids = $this->factory->post->create_many( 3, [
            'post_type' => 'page',
            'post_status' => 'publish',
        ] );

        parent::setUp();
    }

    public function test_categories_dropdown() {
        $field = new Field( [
            'type' => 'wp_dropdown_categories',
            'layout' => 'block',
            'callback_args' => [
                [ 
                    'show_option_none' => '--',
                    'echo' => 0,
                    'selected' => 1,
                    'name' => 'field-name',
                    'id' => 'field-id',
                    'taxonomy' => 'category',
                ],
            ],
        ] );

        $this->dom->loadHTML( $field->render() );
        $ps = $this->dom->getElementsByTagName( 'p' );
        $selects = $this->dom->getElementsByTagName( 'select' );
        $options = $this->dom->getElementsByTagName( 'option' );

        $this->assertCount( 1, $ps );
        $this->assertCount( 1, $selects );
        $this->assertTrue( count( $options ) > 0 );

        $this->assertSame( 'field-id', $selects->item( 0 )->attributes->getNamedItem( 'id' )->value );
        $this->assertSame( 'field-name', $selects->item( 0 )->attributes->getNamedItem( 'name' )->value );
    }

    public function test_tax_dropdown() {
        $field = new Field( [
            'type' => 'wp_dropdown_categories',
            'layout' => 'block',
            'callback_args' => [
                [ 
                    'show_option_none' => '--',
                    'echo' => 0,
                    'selected' => 1,
                    'name' => 'field-name',
                    'id' => 'field-id',
                    'taxonomy' => 'level',
                ],
            ],
        ] );

        $this->dom->loadHTML( $field->render() );
        $ps = $this->dom->getElementsByTagName( 'p' );
        $selects = $this->dom->getElementsByTagName( 'select' );
        $options = $this->dom->getElementsByTagName( 'option' );

        $this->assertCount( 1, $ps );
        $this->assertCount( 1, $selects );
        $this->assertTrue( count( $options ) > 0 );

        $this->assertSame( 'field-id', $selects->item( 0 )->attributes->getNamedItem( 'id' )->value );
        $this->assertSame( 'field-name', $selects->item( 0 )->attributes->getNamedItem( 'name' )->value );
    }

    public function test_pages_dropdown() {
        $field = new Field( [
            'type' => 'wp_dropdown_pages',
            'layout' => 'block',
            'callback_args' => [
                [ 
                    'show_option_none' => '--',
                    'echo' => 0,
                    'selected' => 1,
                    'name' => 'field-name',
                    'id' => 'field-id',
                ],
            ],
        ] );

        $this->dom->loadHTML( $field->render() );
        $ps = $this->dom->getElementsByTagName( 'p' );
        $selects = $this->dom->getElementsByTagName( 'select' );
        $options = $this->dom->getElementsByTagName( 'option' );

        $this->assertCount( 1, $ps );
        $this->assertCount( 1, $selects );
        $this->assertTrue( count( $options ) > 0 );

        $this->assertSame( 'field-id', $selects->item( 0 )->attributes->getNamedItem( 'id' )->value );
        $this->assertSame( 'field-name', $selects->item( 0 )->attributes->getNamedItem( 'name' )->value );
    }

    public function test_file_field_render() {
        $field = new Field( [
            'id' => 'field-id',
            'name' => 'field-name',
            'type' => 'file',
            'value' => '23',
            'meta' => [ 'class' => 'my-class' ],
        ] );

        $this->dom->loadHTML( $field->render() );
        $ps = $this->dom->getElementsByTagName( 'p' );
        $inputs = $this->dom->getElementsByTagName( 'input' );
        $buttons = $this->dom->getElementsByTagName( 'button' );
        $scripts = $this->dom->getElementsByTagName( 'script' );

        $this->assertCount( 1, $ps );
        $this->assertCount( 2, $inputs );
        $this->assertCount( 2, $buttons );
        $this->assertCount( 1, $scripts );

        $this->assertSame( 'field-id', $inputs->item( 0 )->attributes->getNamedItem( 'id' )->value );
        $this->assertSame( 'field-name', $inputs->item( 0 )->attributes->getNamedItem( 'name' )->value );
        $this->assertSame( 'hidden', $inputs->item( 0 )->attributes->getNamedItem( 'type' )->value );
        $this->assertSame( '23', $inputs->item( 0 )->attributes->getNamedItem( 'value' )->value );
        $this->assertSame( 'my-class', $inputs->item( 1 )->attributes->getNamedItem( 'class' )->value );
    }
}
