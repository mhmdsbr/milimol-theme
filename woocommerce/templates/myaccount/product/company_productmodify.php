<?php

/**
 * compony prodcut modify  form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

$pid = $_GET['pid'] ? $_GET['pid'] : '';
$product = wc_get_product( $pid );

if ($product)
{
    $product_supplier_linked = get_field('product_supplier_linked', $pid);
    if ($product_supplier_linked[0]->ID !== $com_id)
    {
        // this product is not yours
        exit(0);
    }
}
else
{
   if(!empty($pid)) {
       exit(0);
   }
}

// check status
$cdata_status = get_field('product_status', $com_id);
if ($cdata_status == 'publish') {

    $product_brand = get_field('product_brand', $com_id);
    update_field('product_brand_draft', $product_brand, $com_id);
    //
    $product_appearence = get_field('product_appearence', $com_id);
    update_field('product_appearence_draft', $product_appearence, $com_id);
    //
    $product_country = get_field('product_country', $com_id);
    update_field('product_country_draft', $product_country, $com_id);
    //
    $product_analyse = get_field('product_analyse', $com_id);
    update_field('product_analyse_draft', $product_analyse, $com_id);
    //
    $product_location = get_field('product_location', $com_id);
    update_field('product_location_draft', $product_location, $com_id);
    //
    $product_unique_id = get_field('product_unique_id', $com_id);
    update_field('product_unique_id_draft', $product_unique_id, $com_id);
    //
    $product_purity = get_field('product_purity', $com_id);
    update_field('product_purity_draft', $product_purity, $com_id);
    //
    $product_grade = get_field('product_grade', $com_id);
    update_field('product_grade_draft', $product_grade, $com_id);
    //
    $product_package = get_field('product_package', $com_id);
    update_field('product_package_draft', $product_package, $com_id);
    //
    $product_unit = get_field('product_unit', $com_id);
    update_field('product_unit_draft', $product_unit, $com_id);
    //
    $product_weight = get_field('product_weight', $com_id);
    update_field('product_weight_draft', $product_weight, $com_id);
    //
    $product_order_quantity = get_field('product_order_quantity', $com_id);
    update_field('product_order_quantity_draft', $product_order_quantity, $com_id);
    //
    $product_price = get_field('product_price', $com_id);
    update_field('product_price_draft', $product_price, $com_id);
    //
    $product_analyse_download = get_field('product_analyse_download', $com_id);
    update_field('product_analyse_download_draft', $product_analyse_download, $com_id);
    //
    $product_ad_banner_first = get_field('product_ad_banner_first', $com_id);
    update_field('product_ad_banner_first_draft', $product_ad_banner_first, $com_id);
    //
    $product_ad_banner_second = get_field('product_ad_banner_second', $com_id);
    update_field('product_ad_banner_second_draft', $product_ad_banner_second, $com_id);
    //
    $product_header_bg = get_field('product_header_bg', $com_id);
    update_field('product_header_bg_draft', $product_header_bg, $com_id);
    //
}
//
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
    echo '<h3 class="account__company-product-new-title">اطلاعات محصول</h3>';
    echo '</div>';
    echo '<div class="account__company-product-new-content">';

    if(empty($pid)) {
        $formsetting = [
            'post_id' => 'new_post',
            'id' => 'cform',
            'form' => true,
            'new_post' => [
                'post_type' => 'product',
                'post_status' => 'publish',
            ],
            'post_title' => false,
            'field_groups' => ['1412'],
            'fields' => array(
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
                'product_country_draft',
                'product_analyse_draft',
                'product_location_draft',
                'product_unique_id_draft',
                'product_purity_draft',
                'product_grade_draft',
                'product_package_draft',
                'product_unit_draft',
                'product_weight_draft',
                'product_order_quantity_draft',
                'product_price_draft',
                'product_analyse_download_draft',
                'product_ad_banner_first_draft',
                'product_ad_banner_second_draft',
                'product_header_bg_draft',
            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
            <input type="hidden" id="acf-field_6508127b649a7" name="acf[field_6508127b649a7]" value="draft"/>
        ',
            'updated_message' => ' اطلاعات با موفقیت ذخیره شد.',
            'submit_value' => __("ذخیره", 'acf'),

        ];
    } else {
        $formsetting = array(
            'post_id' => $pid,
            'id' => 'cform',
            'form' => true,
            'new_post' => false,
            'post_title' => false,
            'field_groups' => array('1412'),
            'fields' => array(
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
                'product_country_draft',
                'product_analyse_draft',
                'product_location_draft',
                'product_unique_id_draft',
                'product_purity_draft',
                'product_grade_draft',
                'product_package_draft',
                'product_unit_draft',
                'product_weight_draft',
                'product_order_quantity_draft',
                'product_price_draft',
                'product_analyse_download_draft',
                'product_ad_banner_first_draft',
                'product_ad_banner_second_draft',
                'product_header_bg_draft',
            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="1"/>
            <input type="hidden" id="acf-field_6508127b649a7" name="acf[field_6508127b649a7]" value="draft"/>
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
                $('#acf-field_6508127b649a7').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
