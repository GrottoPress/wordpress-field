<?php

/**
 * WordPress Form Field
 *
 * Renders a field based on given args
 *
 * @package GrottoPress\WordPress\Form
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\WordPress\Form;

use GrottoPress\Form;

/**
 * WordPress Form field
 *
 * @since 0.1.0
 */
class Field extends Form\Field
{
    /**
     * Callable args
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $callback_args Args to supply to a callable type
     */
    protected $callback_args;

    /**
     * Render form field.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Form field html.
     */
    public function render(): string
    {
        if (\in_array($this->type, $this->callables())) {
            return $this->renderStart().
                \call_user_func_array(
                    (string) $this->type,
                    $this->callback_args
                ).$this->renderEnd();
        }

        return parent::render();
    }

    /**
     * Render upload field.
     *
     * @see http://www.webmaster-source.com/2013/02/06/using-the-wordpress-3-5-media-uploader-in-your-plugin-or-theme/
     *
     * @since 0.1.0
     * @access protected
     *
     * @return string Form field html.
     */
    protected function renderFile(): string
    {
        \add_action('admin_enqueue_scripts', function () {
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
            \esc_html__('Select').
        '</button>';

        $html .= ' <button id="'.\esc_attr($this->id).
            '-delete" class="button .submitdelete">'.
            \esc_html__('Delete').
        '</button>';
        
        $html .= '
        <script type="text/javascript">
            jQuery(function($) {
                var grotto_uploader, attachment;';

                $html .= '
                $("#'.\esc_attr($this->id).'-button").click(function(e) {
                    e.preventDefault();';

                    $html .= '
                    if (grotto_uploader) {
                        grotto_uploader.open();
                        return;
                    }';

                    $html .= '
                    grotto_uploader = wp.media.frames.file_frame = wp.media({
                        title: "'.\esc_html__('Upload file').'",
                        button: {
                            text: "'.\esc_html__('Use file').'"
                        },
                        multiple: false
                    });';

                    $html .= '
                    grotto_uploader.on("select", function() {
                        attachment = grotto_uploader.state().get("selection").first().toJSON();
                        $("#'.\esc_attr($this->id).'-url").val(attachment.url);
                        $("#'.\esc_attr($this->id).'").val(attachment.id);
                    });';

                    $html .= '
                    grotto_uploader.open();
                });';

                $html .= '
                $("#'.\esc_attr($this->id).'-delete").click(function(e) {
                    e.preventDefault();';

                    $html .= '
                    $("#'.\esc_attr($this->id).'").val(0);
                    $("#'.\esc_attr($this->id).'-url").val("");
                });
            });
        </script>';

        return $html;
    }

    /**
     * Render color picker.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return string Form field html.
     */
    protected function renderColorPicker(): string
    {
        return '';
    }

    /**
     * Sanitize attributes
     *
     * @since 0.1.0
     * @access protected
     */
    protected function sanitizeAttributes()
    {
        $this->callback_args = (array) $this->callback_args;

        parent::sanitizeAttributes();
    }

    /**
     * Sanitize attributes
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Callables to allow for our field type.
     */
    protected function callables(): array
    {
        return [
            'wp_dropdown_categories',
            'wp_dropdown_pages',
            'wp_dropdown_users',
            'wp_dropdown_roles',
            'wp_dropdown_languages',
        ];
    }
}
