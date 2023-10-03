<?php
/**
 * Message
 */
namespace EXP\Core;


use JetBrains\PhpStorm\NoReturn;
use WP_User_Query;
use WPMailSMTP\Admin\Pages\VersusTab;

class Message
{
    public function __construct()
    {

        add_action('wp_head', [&$this, 'custom_ajax_url']);

        add_action('wp_ajax_mili_message', [&$this, 'mili_message_callback']);
        add_action('wp_ajax_nopriv_mili_message', [&$this, 'mili_message_callback']);

        // Add the AJAX action hook for checking user login status
        add_action('wp_ajax_check_user_logged_in', [&$this, 'check_user_logged_in']);
        add_action('wp_ajax_nopriv_check_user_logged_in', [&$this, 'check_user_logged_in']); // Allow non-logged-in users to check as well


    }

    #[NoReturn] function check_user_logged_in(): void
    {
        echo is_user_logged_in() ? 'yes' : 'no';
        die();
    }

// send message ajax

    function custom_ajax_url(): void
    {
        echo '<script type="text/javascript">
           const ajaxurl = "' .
            admin_url('admin-ajax.php') .
            '";
         </script>';

    }

    function mili_message_update_message_count($user_id): void
    {
        // Retrieve the current '_fep_user_message_count' meta value
        $current_meta_value = get_user_meta($user_id, '_fep_user_message_count', true);

        // If the meta value is empty or not an array, initialize it
        if (empty($current_meta_value) || !is_array($current_meta_value)) {
            $current_meta_value = array('total' => 0, 'unread' => 0);
        }

        // Increment the 'total' value by 1
        $current_meta_value['total'] += 1;

        // Serialize the updated meta value
        $updated_meta_value_serialized = serialize($current_meta_value);

        // Update the user meta with the updated value
        update_user_meta($user_id, '_fep_user_message_count', $updated_meta_value_serialized);
        //
    }

    function mili_message_send_single($subject, $message, $participant, $productId = null): void
    {

        global $wpdb;


        if ($productId !== null) {
            $product_object = wc_get_product($productId);
            $product_name = $product_object->name;
            $message = '<h5 class="message-product-name">این پیام برای محصول <span>' . $product_name . '</span> می باشد.</h5>' . $message;

        }


        $current_user = wp_get_current_user();
        $msg_author = $current_user->ID;
        $msg_excerpt = General::generate_excerpt($message, $max_words = 15, $append_ellipsis = true);

        // Insert data into the 'wp_fep_messages' table
        $table_name_messages = $wpdb->prefix . 'fep_messages';
        $wpdb->insert(
            $table_name_messages,
            array(
                'mgs_title' => $subject,
                'mgs_content' => $message,
                'mgs_author' => $msg_author,
                'mgs_last_reply_by' => $msg_author,
                'mgs_status' => 'publish',
                'mgs_created' => date('Y-m-d H:i:s'),
                'mgs_last_reply_time' => date('Y-m-d H:i:s'),
                'mgs_last_reply_excerpt' => $msg_excerpt,
            )
        );

        $message_id = $wpdb->insert_id;

        // Insert data into the 'wp_fep_participants' table
        $random_number = time();
        $table_name_participants = $wpdb->prefix . 'fep_participants';
        $wpdb->insert(
            $table_name_participants,
            array(
                'mgs_participant' => $msg_author,
                'mgs_parent_read' => $random_number,
                'mgs_id' => $message_id,
            )
        );

        $this->mili_message_update_message_count($msg_author);

        $participant_object = get_user_by('login', $participant);
        $participant_id = $participant_object->ID;
        $wpdb->insert(
            $table_name_participants,
            array(
                'mgs_participant' => $participant_id,
                'mgs_id' => $message_id,
            )
        );

        $this->mili_message_update_message_count($participant_id);



        // Insert data into the 'wp_fep_messagemeta' table
        $table_name_messagemeta = $wpdb->prefix . 'fep_messagemeta';
        $wpdb->insert(
            $table_name_messagemeta,
            array(
                'fep_message_id' => $message_id,
                'meta_value' => $random_number,
                'meta_key' => '_fep_email_sent',
            )
        );

    }
    function mili_message_callback()
    {

        $current_user = wp_get_current_user();

        // Check if the 'message_subject', 'message_body', and 'message_participants' fields exist in the POST data
        if (!empty($_POST['message_subject']) && !empty($_POST['message_body']) && !empty($_POST['message_participants']) && !empty($_POST['message_company_id'])) {
            $message_subject = sanitize_text_field($_POST['message_subject']);
            $message_body = sanitize_text_field($_POST['message_body']);
            $message_participants = sanitize_text_field($_POST['message_participants']);
            $message_product_ids = sanitize_text_field($_POST['message_product_ids']);
            $message_company_id = sanitize_text_field($_POST['message_company_id']);


            if(!empty($message_company_id) && empty($message_participants)) {
                $user_object = get_field('p2p_company_user', $message_company_id);
                $message_participants = $user_object->user_login;
            }

            if(str_contains($message_participants, ',')) {
                $participantsArray = explode(',', $message_participants);
                $productIdsArray = explode(',', $message_product_ids);
                // Remove any leading or trailing spaces from each element and make the array values unique
                $participantsArray = array_map('trim', $participantsArray);
                $productIdsArray = array_map('trim', $productIdsArray);
//                $participantsArray = array_unique($participantsArray);
                $i = 0;
                foreach ($participantsArray as $participant) {
                    if($current_user->user_login == $participant) continue;
                    $product_id = $productIdsArray[$i];
                    $this->mili_message_send_single($message_subject, $message_body, $participant, $product_id);
                    $i++;
                }

            } else {
                $this->mili_message_send_single($message_subject, $message_body, $message_participants);
            }

            // Respond with a success message
            wp_send_json(array('success' => true, 'message' => 'Message sent successfully.'));
        } else {
            wp_send_json(array('success' => false, 'message' => 'Missing POST data'));
        }
        die();
    }



}
