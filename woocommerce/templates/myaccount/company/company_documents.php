<?php

/**
 * Edit company customers form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

// check status
$cdata_status = get_field('documents_status', $com_id);
if ($cdata_status == 'publish') {
    $company_documents = get_field('company_documents', $com_id);
    update_field('company_documents_draft', $company_documents, $com_id);
}
//
if ($cdata_status == 'pending') {
    echo '<div class="account__company-documents">';
    echo '<div class="account__company-documents-content">';
    //
    echo '<span>
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-documents">';
    echo '<div class="account__company-documents-header">';
    echo '<h3 class="account__company-documents-title">مستندات</h3>';
    echo '</div>';
    echo '<div class="account__company-documents-content">';
    $formsetting = array(
        'post_id' => $com_id,
        'id' => 'cform',
        'form' => true,
        'new_post' => false,
        'post_title' => false,
        'field_groups' => array('646'),
        'fields' => array(
            'company_documents_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_65084ac7639b1" name="acf[field_65084ac7639b1]" value="draft"/>
        ',
        'updated_message' => 'اظلاعات با موفقیت ذخیره شد.',
        'submit_value' => __("ذخیره", 'acf'),
    );
    acf_form($formsetting);
    echo '</div>';  //end of body
    echo '</div>';  // end of section
}
?>

<script>
    jQuery(document).ready(function($) {
        jQuery(".acf-form-submit").append('<input type="submit" id="btnsend" name="btnsend" value="ارسال برای تایید و انتشار"/>');
        $('#btnsend').on('click', function() {
            if (!confirm("آیا مطمئن هستید؟ (بعد از تایید اطلاعات این فرم جهت بازبینی و انتشار در سایت برای مدیر ارسال خواهد شد.)")) {
                event.preventDefault();
            } else {
                event.preventDefault();
                $('#acf-field_65084ac7639b1``').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
