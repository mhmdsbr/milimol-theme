<?php

/**
 * Product Request Modify  Form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

if(!in_array('customer', $user_roles) && !in_array('company', $user_roles)) {
    exit;
}
$user_id = $current_user->ID;


$requestId = $_GET['requestId'] ? $_GET['requestId'] : '';

if (!empty($requestId))
{
    $request = get_post( $requestId );

    $user_request_linked = get_field('user_request_linked', $requestId);
    if ($user_request_linked !== $user_id)
    {
        // this product is not yours
        exit(0);
    }
}

// check status
$cdata_status = get_field('request_status', $requestId);
if ($cdata_status == 'publish') {

    $request_title = get_the_title($requestId);
    update_field('request_title_draft', $request_title, $requestId);
    //

    $request_cas_no = wp_get_post_terms($requestId, 'request_cas_no');
    if($request_cas_no)
    {
        $request_cas_no_id = $request_cas_no[0]->term_id;
        update_field('cas_number_draft', $request_cas_no_id, $requestId);
    }
    //

    $request_description = get_field('request_desc', $requestId);
    update_field('request_desc_draft', $request_description, $requestId);
    //

    $request_purity = get_field('request_purity', $requestId);
    update_field('request_purity_draft', $request_purity, $requestId);
    //

    $expire_duration = get_field('expire_duration', $requestId);
    update_field('expire_duration_draft', $expire_duration, $requestId);
    //

    $request_weight = get_field('request_weight', $requestId);
    update_field('request_weight_draft', $request_weight, $requestId);
    //

}

if ($cdata_status == 'pending') {
    echo '<div class="account__company-product-new">';
    echo '<div class="account__company-product-new-content">';
    //
    echo '<span class="account__company-product-new-admin-check">
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-product-new">';
    echo '<div class="account__company-product-new-header">';
    echo '<h3 class="account__company-product-new-title">اطلاعات درخواست</h3>';
    echo '</div>';
    echo '<div class="account__company-product-new-content">';

    if(empty($requestId)) {
        $formsetting = [
            'post_id' => 'new_post',
            'id' => 'cform',
            'form' => true,
            'new_post' => [
                'post_type' => 'request',
                'post_status' => 'publish',
            ],
            'post_title' => false,
            'field_groups' => ['1195'],
            'fields' => array(
                'request_title_draft',
                'cas_number_draft',
                'cas_number_other_draft',
                'request_purity_draft',
                'expire_duration_draft',
                'request_weight_draft',
                'request_desc_draft',

            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="new"/>
            <input type="hidden" id="acf-field_650c0c6a4fd03" name="acf[field_650c0c6a4fd03]" value="draft"/>
            <input type="hidden" name="acf[field_650c093c058e2]" value="' . $user_id . '">
        ',
            'updated_message' => ' اطلاعات با موفقیت ذخیره شد.',
            'submit_value' => __("ذخیره", 'acf'),

        ];
    } else {
        $formsetting = array(
            'post_id' => $requestId,
            'id' => 'cform',
            'form' => true,
            'new_post' => false,
            'post_title' => false,
            'field_groups' => array('1195'),
            'fields' => array(
                'request_title_draft',
                'cas_number_draft',
                'cas_number_other_draft',
                'request_purity_draft',
                'expire_duration_draft',
                'request_weight_draft',
                'request_desc_draft',

            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="edit"/>
            <input type="hidden" id="acf-field_650c0c6a4fd03" name="acf[field_650c0c6a4fd03]" value="draft"/>
        ',
            'updated_message' => ' اطلاعات با موفقیت ذخیره شد.',
            'submit_value' => __("ذخیره", 'acf'),
        );

    }
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
                $('#acf-field_650c0c6a4fd03').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
