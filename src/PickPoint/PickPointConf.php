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
     * @param array $config
     */
    public function __construct(array $config)
    {

        $this->host = $config['host'] ?? '';
        $this->login = $config['login'] ?? '';
        $this->password = $config['password'] ?? '';
        $this->ikn = $config['ikn'] ?? '';
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