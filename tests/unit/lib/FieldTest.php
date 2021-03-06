<?php
declare (strict_types = 1);

namespace GrottoPress\WordPress\Form;

use tad\FunctionMocker\FunctionMocker;
use DOMDocument;

class FieldTest extends AbstractTestCase
{
    /**
     * @var DOMDocument
     */
    private $dom;

    public function _before()
    {
        $this->dom = new DOMDocument();
    }

    public function testCategoriesDropdown()
    {
        $callable = FunctionMocker::replace(
            'wp_dropdown_categories',
            function (array $args): string {
                return \join(', ', $args);
            }
        );

        $field = new Field([
            'type' => 'wp_dropdown_categories',
            'layout' => 'block',
            'callbackArgs' => [
                [
                    'category',
                ],
            ],
        ]);

        $this->assertSame('<p>category</p>', $field->render());
    }

    public function testMediaFieldRender()
    {
        $get_attachment_url = FunctionMocker::replace(
            'wp_get_attachment_url',
            'http://my.site/att.png'
        );

        $esc = FunctionMocker::replace(
            ['esc_html__', 'esc_attr'],
            function (string $html): string {
                return $html;
            }
        );

        $field = new Field([
            'id' => 'field-id',
            'name' => 'field-name',
            'type' => 'media',
            'value' => '23',
            'meta' => ['class' => 'my-class'],
        ]);

        $this->dom->loadHTML($field->render());
        $ps = $this->dom->getElementsByTagName('p');
        $inputs = $this->dom->getElementsByTagName('input');
        $buttons = $this->dom->getElementsByTagName('button');
        $scripts = $this->dom->getElementsByTagName('script');

        $this->assertCount(1, $ps);
        $this->assertCount(2, $inputs);
        $this->assertCount(2, $buttons);
        $this->assertCount(1, $scripts);

        $this->assertSame(
            'field-id',
            $inputs->item(0)->attributes->getNamedItem('id')->value
        );
        $this->assertSame(
            'field-name',
            $inputs->item(0)->attributes->getNamedItem('name')->value
        );
        $this->assertSame(
            'hidden',
            $inputs->item(0)->attributes->getNamedItem('type')->value
        );
        $this->assertSame(
            '23',
            $inputs->item(0)->attributes->getNamedItem('value')->value
        );
        $this->assertSame(
            'my-class',
            $inputs->item(1)->attributes->getNamedItem('class')->value
        );
    }

    public function testWPEditor()
    {
        $callable = FunctionMocker::replace(
            'wp_editor',
            function (string $content, string $id, array $args): string {
                return true === $args['tinymce'] ? 'true' : 'false';
            }
        );

        $field = new Field([
            'type' => 'wp_editor',
            'label' => 'label',
            'callbackArgs' => [
                'content',
                'id',
                [
                    'tinymce' => true,
                ],
            ],
        ]);

        $this->assertSame('false', $field->render());
    }
}
