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
$cdata_status = get_field('social_status', $com_id);
if ($cdata_status == 'publish') {
    $company_website = get_field('company_website', $com_id);
    update_field('company_website_draft', $company_website, $com_id);
    //
    $company_whatsapp = get_field('company_whatsapp', $com_id);
    update_field('company_whatsapp_draft', $company_whatsapp, $com_id);
    //
    $company_instagram = get_field('company_instagram', $com_id);
    update_field('company_instagram_draft', $company_instagram, $com_id);
    //
    $company_email_icon = get_field('company_email_icon', $com_id);
    update_field('company_email_icon_draft', $company_email_icon, $com_id);
    //
    $company_aparat = get_field('company_aparat', $com_id);
    update_field('company_aparat_draft', $company_aparat, $com_id);
    //
    $company_facebook = get_field('company_facebook', $com_id);
    update_field('company_facebook_draft', $company_facebook, $com_id);
    //
    $company_twitter = get_field('company_twitter', $com_id);
    update_field('company_twitter_draft', $company_twitter, $com_id);
    //
    $company_telegram = get_field('company_telegram', $com_id);
    update_field('company_telegram_draft', $company_telegram, $com_id);
    //
    $company_youtube = get_field('company_youtube', $com_id);
    update_field('company_youtube_draft', $company_youtube, $com_id);
}
//
if ($cdata_status == 'pending') {
    echo '<div class="account__company-social">';
    echo '<div class="account__company-social-content">';
    //
    echo '<span>
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-social">';
    echo '<div class="account__company-social-header">';
    echo '<h3 class="account__company-social-title">شبکه های مجازی</h3>';
    echo '</div>';
    echo '<div class="account__company-social-content">';
    $formsetting = array(
        'post_id' => $com_id,
        'id' => 'cform',
        'form' => true,
        'new_post' => false,
        'post_title' => false,
        'field_groups' => array('646'),
        'fields' => array(
            'company_website_draft',
            'company_whatsapp_draft',
            'company_instagram_draft',
            'company_email_icon_draft',
            'company_aparat_draft',
            'company_facebook_draft',
            'company_twitter_draft',
            'company_telegram_draft',
            'company_youtube_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_64e46c2de8abe" name="acf[field_64e46c2de8abe]" value="draft"/>
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
                $('#acf-field_64e46c2de8abe').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
