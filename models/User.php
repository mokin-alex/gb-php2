<?php

namespace app\models;


class User extends Record
{
    public $id;
    public $login;
    public $password;
    public $firstName;
    public $secondName;
    public $isAdm;

    public function __construct(int $id = null, string $login = null, string $password = null, string $firstName = null, string $secondName = null, int $isAdm = 0)
    {
    parent::__construct();
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLogin(string $login)
    {
        $this->setPropsIsUpdated('login');
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->setPropsIsUpdated('password');
        $this->password = static::getHash($password);
        return $this;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->setPropsIsUpdated('fistName');
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param mixed $secondName
     */
    public function setSecondName(string $secondName)
    {
        $this->setPropsIsUpdated('secondName');
        $this->secondName = $secondName;
        return $this;
    }

    /**
     * @param bool $isAdm
     */
    public function setIsAdm(bool $isAdm)
    {
        $this->setPropsIsUpdated('isAdm');
        $this->isAdm = (int) $isAdm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAdm()
    {
        return $this->isAdm;
    }

    public static function getHash(string $string)
    {
        $silk = "s18m11";
        return md5($string . $silk);
    }
}