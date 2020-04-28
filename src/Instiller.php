<?php

namespace ClockworkMarketing\InstillerWrapper;

use ClockworkMarketing\InstillerWrapper\Request;

class Instiller
{

    private $api_id;
    private $api_key;
    public $client;
    public $user;


    public function __construct($api_id, $api_key)
    {
        $this->api_id = $api_id;
        $this->api_key = $api_key;
        $this->request = new Request($api_id, $api_key);
    }

    public function findUser($email_address = null)
    {
        $this->user = $this->request->get('/users/details', [
            'email_address' => $email_address
        ]);

        if($this->user['valid'] != true)
        {
            return null;
        }

        return (object) $this->user;
    }

    public function findOrCreateUser($email_address, $data = [])
    {
        $data['email_address'] = $email_address;
        $this->user = $this->request->post('/users/add_or_update', $data);
        return (object) $this->user->response;
    }

    public function subscribeUserToList($email_address, $list_api_identifier)
    {
        if(!is_object($this->user) || $this->user->email_address != $email_address)
        {
            $user = (object) $this->findOrCreateUser($email_address)->response;
            dump(1);
        } else {
            dump(2);

            $user = $this->user;
        }

       // dd($user);

        $subscribed = $this->request->get('/users/list_subscribe', [
            'email_address' => $user->email_address,
            'list_api_identifier' => $list_api_identifier,
            'subscribed' => 'Y'
        ]);

        return $subscribed;




    }







}

