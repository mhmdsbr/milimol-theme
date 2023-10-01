<?php

/**
 * Edit company catalog form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

// check status
$cdata_status = get_field('catalog_status', $com_id);
if ($cdata_status == 'publish') {
    $company_catalog = get_field('company_catalog', $com_id);
    update_field('company_catalog_draft', $company_catalog, $com_id);
}
//
if ($cdata_status == 'pending') {
    echo '<div class="account__company-catalog">';
    echo '<div class="account__company-catalog-content">';
    //
    echo '<span> 
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-catalog" style="">';
    echo '<div class="account__company-catalog-header" style="">';
    echo '<h3 class="account__company-catalog-title">1کاتالوگ ها</h3>';
    echo '</div>';
    echo '<div class="account__company-catalog-content">';

    $rejection_reason = get_field('rejection_reason_catalog', $com_id);
    if(!empty($rejection_reason)) {
        echo '<div class="account__company-product-reason-rejection">';
        echo $rejection_reason;
        echo '</div>';
    }
    $formsetting = array(
        'post_id' => $com_id,
        'id' => 'cform',
        'form' => true,
        'new_post' => false,
        'post_title' => false,
        'field_groups' => array('646'),
        'fields' => array(
            'company_catalog_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_65084a8e639b0" name="acf[field_65084a8e639b0]" value="draft"/>
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
                $('#acf-field_65084a8e639b0').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
