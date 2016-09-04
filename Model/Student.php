<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11/07/2016
 * Time: 14:14
 */
class Student
{

    private $id;
    private $name;
    private $surname;
    private $email;
    private $country;
    private $city;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


    

   

    public function convertObjectToArray(){
        $data = array('id'=>$this->getId(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'email'=>$this->getEmail(),
            'country'=>$this->getCountry(),
            'city'=>$this->getCity());
        return $data;
    }
    public static function convertArrayToObject(Array &$data){
        return self::createObject($data['id'],$data['name'],$data['surname'],$data['email'],$data['country'],$data['city']);
    }
    public static function createObject($id,$name,$surname,$email,$country,$city){
        $student=new Student();
        $student->setId($id);
        $student->setName($name);
        $student->setSurname($surname);
        $student->setEmail($email);
        $student->setCountry($country);
        $student->setCity($city);
        return$student;
    }
}