<?php

namespace PickPointSdk\PickPoint;

class PickPointConf
{

    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $ikn;

    /**
     * PickPointConf constructor.
     * @param string $host
     * @param string $login
     * @param string $password
     * @param string $ikn
     */
    public function __construct(string $host, string $login, string $password, string $ikn)
    {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;
        $this->ikn = $ikn;
    }


    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getIKN()
    {
        return $this->ikn;
    }

}