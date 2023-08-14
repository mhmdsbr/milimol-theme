<?php
/**
 * General setup for the GravityForms plugin
 */
namespace EXP\ThirdParty;

class GravityForms
{
    public function __construct()
    {
        add_filter('gform_validation_message', [&$this, 'gformValidation'], 10, 2);
        add_filter('gform_submit_button', [&$this, 'formSubmitButton'], 10, 2);
    }

    /**
     * Create custom validation error message
     */
    public function gformValidation($message, $form) {
        if ( gf_upgrade()->get_submissions_block() ) {
            return $message;
        }

        $message = "<div class='custom_validation_error'><p>" . __('Er was een probleem met je inzending. Controleer de onderstaande velden.') . "</p>";
        $message .= '<ol>';

            foreach ( $form['fields'] as $field ) {
                if ( $field->failed_validation ) {
                    $message .= sprintf('<li><a href="#field_' . $field->formId . '_' . $field->id . '" title="' . $field->label . '">' . $field->label . '</a></li>');
                }
            }

        $message .= '</ol></div>';

        return $message;
    }

    /**
     * Create custom button
     */
    public function formSubmitButton($button, $form) {
        return "<button class='button gform_button' id='gform_submit_button_{$form['id']}'
        onclick='gform_{$form['id']}()'><span>" . __('Submit', 'expedition') . "</span></button>";
    }
}
