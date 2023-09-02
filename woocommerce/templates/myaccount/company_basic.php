<?php

/**
 * Edit company basic form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;
//
acf_form_head();
// load com obj
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;
// $com_obj = get_page_by_path($usercom_slug, OBJECT, 'sup_company');
//
// check status
$cdata_status = get_field('basic_status', $com_id);
if ($cdata_status == 'publish') {
    // replace main data to this fields
    // $c_namefa = $com_obj->post_title;
    // update_field('c_namefa', $c_namefa, $com_id);
    // // logo is hear
    // $turl = wp_get_attachment_image_src(get_post_thumbnail_id($com_id), $size = 'thumbnail', $icon = false);
    // update_field('field_61d6adba77401', get_post_thumbnail_id($com_id), $com_id);
    //
    $company_icon = get_field('company_icon', $com_id);
    update_field('company_icon_draft', $company_icon, $com_id);
    //
    $company_intro = get_field('company_intro', $com_id);
    update_field('company_intro_draft', $company_intro, $com_id);
    //
    $company_country = get_field('company_country', $com_id);
    update_field('company_country_draft', $company_country, $com_id);
    //
    $company_city = get_field('company_city', $com_id);
    update_field('company_city_draft', $company_city, $com_id);
    //
    $company_start_date = get_field('company_start_date', $com_id);
    update_field('company_start_date_draft', $company_start_date, $com_id);
    //
    $company_job_field = get_field('company_job_field', $com_id);
    update_field('company_job_field_draft', $company_job_field, $com_id);
    //
    $company_ceo = get_field('company_ceo', $com_id);
    update_field('company_ceo_draft', $company_ceo, $com_id);
    //
    $company_personnel = get_field('company_personnel', $com_id);
    update_field('company_personnel_draft', $company_personnel, $com_id);
    //
    $company_office_phone = get_field('company_office_phone', $com_id);
    update_field('company_office_phone_draft', $company_office_phone, $com_id);
    //
    $company_phone = get_field('company_phone', $com_id);
    update_field('company_phone_draft', $company_phone, $com_id);
    //
    $company_office_address = get_field('company_office_address', $com_id);
    update_field('company_office_address_draft', $company_office_address, $com_id);
    //
    $company_address = get_field('company_address', $com_id);
    update_field('company_address_draft', $company_address, $com_id);
    //
    $company_mobile = get_field('company_mobile', $com_id);
    update_field('company_mobile_draft', $company_mobile, $com_id);
    //
    $company_fax = get_field('company_fax', $com_id);
    update_field('company_fax_draft', $company_fax, $com_id);
    //
    $company_email = get_field('company_email', $com_id);
    update_field('company_email_draft', $company_email, $com_id);
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
            'company_icon_draft',
            'company_intro_draft',
            'company_country_draft',
            'company_city_draft',
            'company_start_date_draft',
            'company_job_field_draft',
            'company_ceo_draft',
            'company_personnel_draft',
            'company_office_phone_draft',
            'company_phone_draft',
            'company_office_address_draft',
            'company_address_draft',
            'company_mobile_draft',
            'company_fax_draft',
            'company_email_draft',
        ),
        'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
        <input type="hidden" id="acf-field_64e0cbb1417e7" name="acf[field_64e0cbb1417e7]" value="draft"/>
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
                $('#acf-field_64e0cbb1417e7').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
