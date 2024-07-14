<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RajaOngkir
{
    private $api_key;
    private $base_url;

    public function __construct()
    {
        // Set your API key
        $this->api_key = 'bfc73a5ac233d6ea88fb80d6b59baeab';
        $this->base_url = 'https://api.rajaongkir.com/starter/';
    }

    private function request($method, $endpoint, $params = [])
    {
        $url = $this->base_url . $endpoint;

        $headers = [
            'key: ' . $this->api_key
        ];

        $curl = curl_init();

        switch ($method) {
            case 'GET':
                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
                break;
            default:
                return 'Invalid request method';
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 'cURL Error #: ' . $err;
        }

        return json_decode($response, true);
    }

    public function getProvinces()
    {
        return $this->request('GET', 'province');
    }

    public function getCities($province_id)
    {
        return $this->request('GET', 'city', ['province' => $province_id]);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        return $this->request('POST', 'cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]);
    }

    public function getProvinceName($province_id)
    {
        $provinces = $this->getProvinces();

        foreach ($provinces['rajaongkir']['results'] as $province) {
            if ($province['province_id'] == $province_id) {
                return $province['province'];
            }
        }

        return null;
    }

    public function getCityName($city_id, $province_id)
    {
        $cities = $this->getCities($province_id);

        foreach ($cities['rajaongkir']['results'] as $city) {
            if ($city['city_id'] == $city_id) {
                return $city['city_name'];
            }
        }

        return null;
    }
}
