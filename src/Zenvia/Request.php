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

    public function sendSMS($to, $msg, $schedule = '')
    {       
        if(empty($schedule)){
            $schedule = date('Y-m-d\TH:i:s');
        }
        
        $action = '/send-sms';
        $token = $this->getToken();

        $body = array();
        $body['sendSmsRequest'] = ['to' => $to, 'msg' => $msg, 'schedule' => $schedule];

        return $this->sendRequest('POST', $token, $action, $body);
    }

    public function sendSMSMultipe($sms = Array(), $schedule = '')
    {       
        
        $action = '/send-sms-multiple';
        $token = $this->getToken();

        $body = array();

        foreach ($sms as $key => $value) {
            if(empty($value['schedule'])){
                $schedule = date('Y-m-d\TH:i:s');
            }else{
                $schedule = $value['schedule'];
            }
            $body['sendSmsMultiRequest']['sendSmsRequestList'][] = ['to' => $value['to'], 'msg' =>  $value['msg'], 'schedule' => $schedule];
        }   

        return $this->sendRequest('POST', $token, $action, $body);
    }

    protected function getToken()
    {
        return base64_encode($this->basic_username . ':' . $this->basic_password);
    }

    protected function sendRequest($method, $token, $action, $content = null)
    {

        $url = $this->URL . $action;
        $headers = array();
        $ch = curl_init($url);
        
        $payloadName = json_encode($content);

        $headers[] = "Authorization: Basic {$token}";        
        $headers[] = "Content-Type: application/json"; 
        $headers[] = "Accept: application/json"; 

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
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