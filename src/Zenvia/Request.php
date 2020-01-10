<?php
/*
 * Zenvia SMS
 * @author Thalles Brandão
 * @date 10/01/2020
 * */
namespace Zenvia;

class Request{

    protected $URL = 'https://api-rest.zenvia.com/services';

    private $basic_username = null;
    private $basic_password = null;

    private $token;

    /**
     * Zenvia constructor.
     * @param $URL
     * @param $username
     * @param bool $password
     */
    public function __construct($username, $password)
    {
        $this->basic_username = trim($username);
        $this->basic_password = trim($password);
    }

    public function sendSMS($to, $msg, $schedule, $from = '')
    {       
        if(empty($schedule)){
            $schedule ='2020-01-10T16:00:00';
        }
        
        $action = '/send-sms';
        $token = $this->getToken();
        echo $token;
        exit();

        $body = array();
a
        $body['sendSmsRequest'] = ['from' => $from, 'to' => $to, 'schedule' => $schedule, 'msg' => $msg, 'flashSms' => false];

        return $this->sendRequest('POST', $token, $action, $body);
    }

    public function getToken()
    {
        $content = base64_encode($this->basic_username . ':' . $this->basic_password);
        return $content;
    }

    protected function sendRequest($method, $token, $action, $content = null)
    {
        $url = $this->URL . $action;
        $headers = array();
        $ch = curl_init($url);
        
        $media_type = $this->media_type[0];
        $payloadName = json_encode($content);

        $headers[] = "Authorization: Bearer {$token->access_token}";        
        $headers[] = "Content-Type: application/json"; 
        $headers[] = "Accept: application/json"; 

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if($content !== NULL){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        if($return === false)
            return 'Curl error: ' . curl_error($ch);
        else
            return $return;        
        curl_close($ch);               
    }

}