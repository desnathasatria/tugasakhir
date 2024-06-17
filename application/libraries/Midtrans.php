<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/midtrans/midtrans-php/Midtrans.php';

class Midtrans {

    public function __construct() {
        $ci =& get_instance();
        $ci->config->load('midtrans');
        
        $config = $ci->config->item('midtrans');
        
        \Midtrans\Config::$serverKey = $config['server_key'];
        \Midtrans\Config::$isProduction = $config['is_production'];
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function create_payment_link($data) {
        try {
            $response = \Midtrans\Snap::createTransaction($data);
            return $response;  // Memastikan response yang dikembalikan adalah objek
        } catch (Exception $e) {
            return (object) ['error' => $e->getMessage()];  // Mengembalikan objek error
        }
    }
}
