<?php

require_once 'HTTP/Request.php';
require_once 'TodoistException.php';

class Todoist

{

    const API_URL = 'https://todoist.com/API/';
    const MAIL_ADDRESS = '';
    const PASSWORD = '';

    private $token;

    public function __construct()

    {

        $this->login(Todoist::MAIL_ADDRESS, Todoist::PASSWORD);

    }

    private function login($email, $password)

    {

        $params = array(

            'email' => $email,

            'password' => $password

        );

        $url = $this->createUrl('login', $params);

        $res = $this->remote($url, array());

        if ($res === 'LOGIN_ERROR')

        {

            throw new TodoistException('login error');

        }

        $this->token = $res->token;

    }

    public function createProject($projectName)

    {

        $params = array(

            'name' => $projectName,

            'token' => $this->token 

        );

        $url = $this->createUrl('addProject', $params);

        $res = $this->remote($url, array());

        if ($res === 'ERROR_NAME_IS_EMPTY') {

            throw new TodoistException('project name error');

        }

    }

    private function remote($url, $option)

    {

        $http = new HTTP_Request($url, $option);

        if (!PEAR::isError($http->sendRequest())) {

            $res = $http->getResponseBody();

            return json_decode($res);

        } else {

            throw new TodoistException('remote error');

        }

    }

    private function createUrl($action, $params)

    {

        return Todoist::API_URL.$action.'?'.http_build_query($params, NULL, '&');

    }

}
