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
    echo '<div class="fsection_container" style="">';
    echo '<div class="fsection_body" style="background: lightgreen;
    border-radius: 5px;
    text-align: center;">';
    //
    echo '<span sytle="font-size:14px;font-weight:bold;">' . $myout . '
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="fsection_container" style="">';
    echo '<div class="fsection_head" style="">';
    echo '<span class="head_number">1</span> <span style="">اطلاعات شرکت</span>';
    echo '</div>';
    echo '<div class="fsection_body">';
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
<style>
    article {
        background-color: rgba(210, 210, 210, .1);
    }

    article::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 0;
        background-image: url(https://image.freepik.com/free-vector/abstract-line-hexagon-geometric-texture_1035-17373.jpg);
        opacity: 0.07;
    }

    .acf-fields>.acf-field.acf-field-acfe-column {
        float: right !important;
    }

    .fsection_container {
        padding: 7px;
    }

    .head_number {
        border-radius: 50%;
        background-color: white;
        width: 25px;
        display: block;
        float: right;
        margin-left: 5px;
        color: black;
        text-align: center;
        font-weight: bold;
    }

    .fsection_head {
        display: block;
        border: 1px solid #446084;
        padding: 5px;
        width: 270px;
        border-top-left-radius: 30px;
        color: white;
        border-bottom: 0px;
        background-color: #446084;
    }

    .fsection_body {
        border: 1px solid #446084;
        padding: 11px;
        background-color: rgba(255, 255, 255, 1);
        width: 100%;
        position: relative
    }

    .fsection_body:after {
        content: "";
        height: inherit;
        width: inherit;
    }

    [data-name="c_savedata"] {
        display: none;
        visibility: hidden;
    }

    .image-wrap img {
        border: 1px solid lightgray;
        border-radius: 5px;
    }
</style>
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
