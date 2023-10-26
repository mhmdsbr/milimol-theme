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
    global $wpdb;
    $result = $wpdb->get_results( "SELECT * FROM `wp_postmeta` WHERE post_id = '{$com_id}' AND meta_key = 'company_map';");
    $serializedData = $result[0]->meta_value;
    $unserializedData = unserialize($serializedData);
    update_post_meta($com_id, 'company_map_draft', $unserializedData);

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

    if(is_array($company_img_gallery)) {
        $company_gallery_ids = [];
        foreach($company_img_gallery as $item) {
            $company_gallery_ids[]['company_img_gallery_item'] = $item;
        }
        update_field('company_img_gallery_draft', $company_gallery_ids, $com_id);
    }
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

    $rejection_reason = get_field('rejection_reason_content', $com_id);
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
            'company_map_draft',
            'company_video_id_draft',
            'company_video_bg_draft',
//            'company_ad_banner_draft',
            'company_img_gallery_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_65084a1e639ae" name="acf[field_65084a1e639ae]" value="draft"/>
        ',
        'updated_message' => 'اطلاعات با موفقیت ذخیره شد.',
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
                $('#acf-field_65084a1e639ae').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php

