<?php
declare (strict_types = 1);

namespace GrottoPress\WordPress\Form;

use GrottoPress\Form\Field as FormField;

class Field extends FormField
{
    /**
     * @var mixed[int]
     */
    protected $callbackArgs;

    /**
     * @param mixed[string] $args
     */
    public function __construct(array $args = [])
    {
        parent::__construct($args);

        $this->callbackArgs = (array)$this->callbackArgs;

        if ('wp_editor' === $this->type) {
            $this->wrap = '';
            $this->label = '';
            $this->callbackArgs[2]['tinymce'] = false;
        }
    }

    public function render(): string
    {
        if (\in_array($this->type, $this->callables())) {
            $function = $this->type;

            return $this->startRender().
                $function(...$this->callbackArgs).
                $this->endRender();
        }

        return parent::render();
    }

    /**
     * Called if $this->type === 'media'
     */
    protected function render_media(): string
    {
        \add_action('admin_enqueue_scripts', function (string $page) {
            \wp_enqueue_media();
        });

        $this->meta['disabled'] = 'disabled';

        $html = '<input id="'.\esc_attr($this->id).'" type="hidden" name="'.\esc_attr($this->name).'" value="'.
            \esc_attr($this->value).'" />';

        $html .= '<input '.$this->metaString().' id="'.
            \esc_attr($this->id).'-url" type="text" name="" value="'.
            \esc_attr(\wp_get_attachment_url($this->value)).'" />';

        $html .= ' <button id="'.
            \esc_attr($this->id).'-button" class="button">'.
            \esc_html__('Select', 'grotto-wp-field').
        '</button>';

        $html .= ' <button id="'.\esc_attr($this->id).
            '-delete" class="button submitdelete">'.
            \esc_html__('Delete', 'grotto-wp-field').
        '</button>';

        $html .= '
        <script type="text/javascript">
            (function(_j, _w) {
                var uploader, attachment;';

                $html .= '
                _j("#'.\esc_attr($this->id).'-button").click(function(e) {
                    e.preventDefault();';

                    $html .= '
                    if (uploader) {
                        uploader.open();
                        return;
                    }';

                    $html .= '
                    uploader = _wp.media.frames.file_frame = _wp.media({
                        title: "'.\esc_html__('Upload file', 'grotto-wp-field').'",
                        button: {
                            text: "'.\esc_html__('Use file', 'grotto-wp-field').'"
                        },
                        multiple: false
                    });';

                    $html .= '
                    uploader.on("select", function() {
                        attachment = uploader.state().get("selection").first().toJSON();
                        _j("#'.\esc_attr($this->id).'-url").val(attachment.url);
                        _j("#'.\esc_attr($this->id).'").val(attachment.id);
                    });';

                    $html .= '
                    uploader.open();
                });';

                $html .= '
                _j("#'.\esc_attr($this->id).'-delete").click(function(e) {
                    e.preventDefault();';

                    $html .= '
                    _j("#'.\esc_attr($this->id).'").val(0);
                    _j("#'.\esc_attr($this->id).'-url").val("");
                });
            })(jQuery, wp);
        </script>';

        return $html;
    }

    /**
     * @todo
     */
    protected function render_color_picker(): string
    {
        return '';
    }

    /**
     * Callables to allow for our field type
     *
     * @return string[int]
     */
    protected function callables(): array
    {
        return [
            'wp_dropdown_categories',
            'wp_dropdown_pages',
            'wp_dropdown_users',
            'wp_dropdown_roles',
            'wp_dropdown_languages',
            'wp_editor',
        ];
    }
}
