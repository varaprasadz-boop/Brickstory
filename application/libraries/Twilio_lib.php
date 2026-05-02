<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Twilio\Rest\Client;

class Twilio_lib {

    protected $CI;
    protected $client;

    public function __construct() {
        $this->CI =& get_instance();
        $sid = get_settings('SMS_TWILIO_SID', '');
        $token = get_secret_settings('SMS_TWILIO_TOKEN', '');
        if (empty($sid) || empty($token)) {
            log_message('error', 'Twilio not configured: missing SID or token in settings.');
            $this->client = null;
            return;
        }
        $this->client = new Client($sid, $token);
    }

    public function send_sms($to, $message) {
        if ($this->client === null) {
            return 'Twilio not configured';
        }
        $from = get_settings('SMS_TWILIO_FROM', '');
        if (empty($from)) {
            log_message('error', 'Twilio "from" number not configured.');
            return 'Twilio "from" missing';
        }
        try {
            $message = $this->client->messages->create(
                $to,
                [
                    'from' => $from,
                    'body' => $message
                ]
            );
            return $message->sid;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $e->getMessage();
        }
    }
}

?>