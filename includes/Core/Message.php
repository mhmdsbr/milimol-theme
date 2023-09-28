<?php
/**
 * Message
 */
namespace EXP\Core;


use WP_User_Query;
use WPMailSMTP\Admin\Pages\VersusTab;

class Message
{
    public function __construct()
    {

        add_action('wp_head', [&$this, 'custom_ajax_url']);

        add_action('wp_ajax_mili_message', [&$this, 'mili_message_callback']);
        add_action('wp_ajax_nopriv_mili_message', [&$this, 'mili_message_callback']);
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

    function mili_message_callback(): void
    {
        global $wpdb;

        // Check if the 'message_subject', 'message_body', and 'message_participants' fields exist in the POST data
        if (isset($_POST['message_subject'], $_POST['message_body'], $_POST['message_participants'], $_POST['message_company_id'])) {
            $message_subject = sanitize_text_field($_POST['message_subject']);
            $message_body = sanitize_text_field($_POST['message_body']);
            $message_participants = sanitize_text_field($_POST['message_participants']);
            $message_company_id = sanitize_text_field($_POST['message_company_id']);

            if(!empty($message_company_id)) {
                $user_object = get_field('p2p_company_user', $message_company_id);
                $message_participants = $user_object->ID;
            }

//                // Output the raw data for debugging.
//                ob_start();
//                var_dump($message_participants);
//                var_dump($message_company_id);
//                $output = ob_get_clean();
//                ob_end_flush();
//                update_field('temp', $output, 'option');


            // Get the current user's ID as the message author
            $current_user = wp_get_current_user();
            $msg_author = $current_user->ID;

            // Insert data into the 'wp_fep_messages' table
            $table_name_messages = $wpdb->prefix . 'fep_messages';
            $wpdb->insert(
                $table_name_messages,
                array(
                    'mgs_title' => $message_subject,
                    'mgs_content' => $message_body,
                    'mgs_author' => $msg_author,
                    'mgs_last_reply_by' => $msg_author,
                    'mgs_status' => 'publish',
                    'mgs_created' => date('Y-m-d H:i:s'),
                    'mgs_last_reply_time' => date('Y-m-d H:i:s'),
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
            $wpdb->insert(
                $table_name_participants,
                array(
                    'mgs_participant' => $message_participants,
                    'mgs_id' => $message_id,
                )
            );

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

            // Respond with a success message
            wp_send_json(array('success' => true, 'message' => 'Message sent successfully.'));
        } else {
            wp_send_json(array('success' => false, 'message' => 'Missing POST data'));
        }
        die();
    }



}
