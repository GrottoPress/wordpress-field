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

    public function testFileFieldRender()
    {
        $enqueue_media = FunctionMocker::replace('wp_enqueue_media');

        $add_action = FunctionMocker::replace(
            'add_action',
            function (string $hook, callable $callback) {
                \call_user_func($callback);
            }
        );

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
            'type' => 'file',
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

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce(['admin_enqueue_scripts']);
        $enqueue_media->wasCalledOnce();
    }
}
