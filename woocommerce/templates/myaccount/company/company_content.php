<?php

/**
 * Edit company content form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

// check status
$cdata_status = get_field('content_status', $com_id);
if ($cdata_status == 'publish') {
    $company_map = get_field('company_map', $com_id);
    update_field('company_map_draft', $company_map, $com_id);
    //
    $company_video_id = get_field('company_video_id', $com_id);
    update_field('company_video_id_draft', $company_video_id, $com_id);
    //
    $company_video_bg = get_field('company_video_bg', $com_id);
    update_field('company_video_bg_draft', $company_video_bg, $com_id);
    //
    $company_ad_banner = get_field('company_ad_banner', $com_id);
    update_field('company_ad_banner_draft', $company_ad_banner, $com_id);
    //
    $company_img_gallery = get_field('company_img_gallery', $com_id);
    update_field('company_img_gallery_draft', $company_img_gallery, $com_id);
}
//
if ($cdata_status == 'pending') {
    echo '<div class="account__company-content">';
    echo '<div class="account__company-content-body">';
    //
    echo '<span>
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-content">';
    echo '<div class="account__company-content-header">';
    echo '<h3 class="account__company-content-title">محتوی شرکتی</h3>';
    echo '</div>';
    echo '<div class="account__company-content-body">';
    $formsetting = array(
        'post_id' => $com_id,
        'id' => 'cform',
        'form' => true,
        'new_post' => false,
        'post_title' => false,
        'field_groups' => array('646'),
        'fields' => array(
            'company_map_draft',
            'company_video_id_draft',
            'company_video_bg_draft',
            'company_ad_banner_draft',
            'company_img_gallery_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_64e3bf4f2472e" name="acf[field_64e3bf4f2472e]" value="draft"/>
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
                $('#acf-field_64e3bf4f2472e').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
