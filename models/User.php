<?php

namespace app\models;

class User extends Model
{
    private $id;
    private $login;
    private $password;
    private $FistName;
    private $SecondName;
    private $isAdm;

    public function getTableName(): string
    {
        return "users";
    }

    public function insert()
    {

        $sql = "INSERT INTO {$this->tableName} (login, password, FistName, SecondName, isAdm) 
                VALUE (:login, :password, :FistName, :SecondName, :isAdm)";
        return $this->db->insert($sql, $this->getParams());
    }

    public function update()
    {
        // TODO: Implement update() method.
        $sql = "UPDATE {$this->tableName} 
            SET login = :login, password = :password, FistName = :FistName, SecondName = :SecondName, isAdm = :isAdm
            WHERE id={$this->id}";
        return $this->db->update($sql, $this->getParams());
    }

    public function getId($id)
    {
        return $this->id;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $this->getHash($password);
        return $this;
    }

    /**
     * @param mixed $FistName
     */
    public function setFistName(string $FistName)
    {
        $this->FistName = $FistName;
        return $this;
    }

    /**
     * @param mixed $SecondName
     */
    public function setSecondName(string $SecondName)
    {
        $this->SecondName = $SecondName;
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

    private function getHash(string $string)
    {
        $silk = "s18m11";
        return md5($string . $silk);
    }

    private function getParams():array
    {
        return $params = [
            ':login' => $this->login,
            ':password' => $this->password,
            ':FistName' => $this->FistName,
            ':SecondName' => $this->SecondName,
            ':isAdm' => $this->isAdm,
        ];
    }
}