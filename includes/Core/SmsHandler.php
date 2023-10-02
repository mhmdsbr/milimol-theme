<?php
/**
 * SMS Handler Class
 */
namespace EXP\Core;


use SMSIRAppClass;

class SmsHandler
{
    private array $all_sms = [];
    public function __construct()
    {

    }

    public function clear_all_sms(): void
    {
        $this->all_sms = [];

    }

    public function add_to_all_sms($text, $mobile): void
    {
        $all_sms_count = count($this->all_sms);
        $all_sms_count ++;
        $this->all_sms[$all_sms_count]['text'] = $text;
        $this->all_sms[$all_sms_count]['mobile'] = $mobile;


    }

    public function send_to_all(): void
    {
        foreach ($this->all_sms as $singleSms) {
            $sms = SMSIRAppClass::sendBulkSMS($singleSms['text'], [$singleSms['mobile']]);
        }
    }

    public function add_to_all_sms_for_admin($text): void
    {
        $admin_numbers = get_field('admin_mobile_numbers', 'option');
        if(!empty($admin_numbers)) {
            $comma_seperated_numbers = explode(',', $admin_numbers);
            foreach ($comma_seperated_numbers as $number) {
                $this->add_to_all_sms($text, trim($number));
            }
        }
    }

    public function add_to_all_sms_by_user_id($text, $user_id): void
    {
        $phone_number = get_user_meta( $user_id, 'digits_phone', true );

        if(!empty($phone_number)) {
            $this->add_to_all_sms($text, $phone_number);

        }
    }

    public function add_to_all_sms_user_login($text, $user_login): void
    {
        $user_object = get_user_by('login', $user_login);
        if($user_object) {
           $this->add_to_all_sms_by_user_id($text, $user_object->ID);
        }
    }

    public function add_to_all_sms_by_product_id($text, $product_id): void
    {
        $company_object = get_field('product_supplier_linked', $product_id);


        if($company_object) {
            $user_object = get_field('p2p_company_user', $company_object[0]->ID);
            $this->add_to_all_sms_by_user_id($text, $user_object->ID);
        }
    }

    public function add_to_all_sms_by_request_id($text, $request_id): void
    {
        $user_request_linked = get_field('user_request_linked', $request_id);
        $this->add_to_all_sms_by_user_id($text, $user_request_linked);
    }

    public function add_to_all_sms_by_company_id($text, $company_id): void
    {
        $user_object = get_field('p2p_company_user', $company_id);
        if($user_object) {
            $this->add_to_all_sms_by_user_id($text, $user_object->ID);
        }
    }

}
