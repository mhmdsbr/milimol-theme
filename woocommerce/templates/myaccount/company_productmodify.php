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
    var_dump($product_supplier_linked[0]->ID);
//    var_dump($com_id);
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

    $product_header_bg = get_field('product_header_bg', $com_id);
    update_field('product_header_bg_draft', $product_header_bg, $com_id);
    //
    $product_brand = get_field('product_brand', $com_id);
    update_field('product_brand_draft', $product_brand, $com_id);
    //
    $product_appearence = get_field('product_appearence', $com_id);
    update_field('product_appearence_draft', $product_appearence, $com_id);
    //
}
//
if ($cdata_status == 'pending') {
    echo '<div class="fsection_container" style="">';
    echo '<div class="fsection_body" style="background: lightgreen;
    border-radius: 5px;
    text-align: center;">';
    //
    echo '<span sytle="font-size:14px;font-weight:bold;">
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="fsection_container" style="">';
    echo '<div class="fsection_head" style="">';
    echo '<span class="head_number">1</span> <span style="">اطلاعات محصول</span>';
    echo '</div>';
    echo '<div class="fsection_body">';


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
                'product_header_bg_draft',
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
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
                'product_header_bg_draft',
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
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
