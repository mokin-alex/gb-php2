<?php

namespace app\models;

use app\services\Db;

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

    public static function getTableName(): string
    {
        return "users";
    }

    public static function getUserByLogin(string $login)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE  login = :login";
        return Db::getInstance()->queryOne(get_called_class(), $sql, [':login' => $login]);
    }

    public function insert()
    {

        $sql = "INSERT INTO {$this->tableName} (login, password, FistName, SecondName, isAdm) 
                VALUE (:login, :password, :FistName, :SecondName, :isAdm)";
        return $this->db->insert($sql, $this->getParams());
    }

    public function update()
    {
         $sql = "UPDATE {$this->tableName} 
            SET login = :login, password = :password, FistName = :FistName, SecondName = :SecondName, isAdm = :isAdm
            WHERE id = {$this->id}";
        return $this->db->execute($sql, $this->getParams());
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = {$this->id}";
        return $this->db->execute($sql);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = static::getHash($password);
        return $this;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName(string $firstName)
    {
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
        $this->secondName = $secondName;
        return $this;
    }

    /**
     * @param bool $isAdm
     */
    public function setIsAdm(bool $isAdm)
    {
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

    private function getParams():array
    {
        return $params = [
            ':login' => $this->login,
            ':password' => $this->password,
            ':FistName' => $this->firstName,
            ':SecondName' => $this->secondName,
            ':isAdm' => $this->isAdm,
        ];
    }
}