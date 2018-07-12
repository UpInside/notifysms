<?php
/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 12/07/2018
 * Time: 13:37
 */

namespace Source\Notify\SMS;

class DirectCall {

    private $urlService;
    private $endPoint;
    private $params;
    private $callback;

    public function __construct()
    {
        $this->urlService = 'https://api.directcallsoft.com';
    }

    public function sendSMS($from, $to, $text)
    {
        $this->createToken();
        $accessToken = $this->callback->access_token;

        $this->endPoint = '/sms/send';

        $this->params = [
            'origem' => $from,
            'destino' => $to,
            'tipo' => 'texto',
            'access_token' => $accessToken,
            'texto' => $text
        ];

        $this->post();

    }

    private function createToken()
    {
        $this->endPoint = '/request_token';

        $this->params = [
            'client_id' => CONFIG_SMS['CLIENT_ID'],
            'client_secret' => CONFIG_SMS['CLIENT_SECRET'],
            'format' => 'json'
        ];

        $this->post();
    }

    private function post()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlService . $this->endPoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $this->callback = json_decode(curl_exec($ch));

        curl_close($ch);
    }

}