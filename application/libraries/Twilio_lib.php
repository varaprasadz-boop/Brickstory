<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Twilio\Rest\Client;

class Twilio_lib {

    protected $CI;
    protected $client;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('twilio');
        
        $sid = $this->CI->config->item('twilio')['sid'];
        $token = $this->CI->config->item('twilio')['token'];
        $this->client = new Client($sid, $token);
    }

    public function send_sms($to, $message) {
        $from = $this->CI->config->item('twilio')['from'];
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