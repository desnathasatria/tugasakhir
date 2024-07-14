<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property input $input
 * @property rajaongkir $rajaongkir
 */
class RajaongkirController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Rajaongkir');
    }

    public function index()
    {
        $this->load->view('front_page/cekongkir');
    }

    public function provinces()
    {
        $provinces = $this->rajaongkir->getProvinces();
        echo json_encode($provinces);
    }

    public function cities($province_id)
    {
        $cities = $this->rajaongkir->getCities($province_id);
        echo json_encode($cities);
    }

    public function cost()
    {
        $origin = $this->input->post('origin');
        $destination = $this->input->post('destination');
        $weight = $this->input->post('weight');
        $courier = $this->input->post('courier');

        $cost = $this->rajaongkir->getCost($origin, $destination, $weight, $courier);
        echo json_encode($cost);
    }

    public function province_name($province_id)
    {
        $province_name = $this->rajaongkir->getProvinceName($province_id);
        echo json_encode(['nama_provinsi' => $province_name]); // Mengembalikan nama provinsi dalam format JSON
    }

    public function city_name($city_id, $province_id)
    {
        $city_name = $this->rajaongkir->getCityName($city_id, $province_id);
        echo json_encode(['nama_kota' => $city_name]); // Return city name in JSON format
    }
}
