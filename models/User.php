<?php
namespace models;

class User extends Model
{
    public $id;
    public $login;
    public $password;
    public $email;

    public function getTableName(): string
    {
        return "users";
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}