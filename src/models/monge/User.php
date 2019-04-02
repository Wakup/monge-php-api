<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-04-02
 * Time: 11:58
 */

namespace Wakup;


class User
{
    private $id, $idType, $firstName, $middleName, $firstSurname, $secondSurname, $accountId, $personId, $email;

    const ID_TYPE_TAX_ID = 'CEDULA';

    /**
     * User constructor.
     * @param $id string User identifier. It can be the tax id or other type of identification, defined by getIdType method.
     * @param $idType string Type of the user identifier (e.g. tax id). Available values are described constants named ID_TYPE_*
     * @param $firstName ?string User first name
     * @param $middleName ?string User middle name
     * @param $firstSurname ?string User first surname
     * @param $secondSurname ?string User second surname
     * @param $personId string Internal identifier for user on Monge system
     * @param $accountId ?string User credit account identifier
     * @param $email string User account email
     */
    public function __construct(string $id, string $idType,
                                ?string $firstName, ?string $middleName, ?string $firstSurname, ?string $secondSurname,
                                string $personId, ?string $accountId, string $email)
    {
        $this->id = $id;
        $this->idType = $idType;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->firstSurname = $firstSurname;
        $this->secondSurname = $secondSurname;
        $this->accountId = $accountId;
        $this->personId = $personId;
        $this->email = $email;
    }


    /**
     * @return string User identifier. It can be the tax id or other type of identification, defined by getIdType method.
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @param string $id User identifier. It can be the tax id or other type of identification, defined by getIdType method.
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string Type of the user identifier (e.g. tax id). Available values are described constants named ID_TYPE_*
     */
    public function getIdType() : string
    {
        return $this->idType;
    }

    /**
     * @param string $idType Type of the user identifier (e.g. tax id). Available values are described constants named ID_TYPE_*
     */
    public function setIdType(string $idType): void
    {
        $this->idType = $idType;
    }

    /**
     * @return string User first name
     */
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName User first name
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string User middle name
     */
    public function getMiddleName() : ?string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName User middle name
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string User first surname
     */
    public function getFirstSurname() : ?string
    {
        return $this->firstSurname;
    }

    /**
     * @param string $firstSurname User first surname
     */
    public function setFirstSurname(?string $firstSurname): void
    {
        $this->firstSurname = $firstSurname;
    }

    /**
     * @return string User second surname
     */
    public function getSecondSurname() : ?string
    {
        return $this->secondSurname;
    }

    /**
     * @param string $secondSurname User second surname
     */
    public function setSecondSurname(?string $secondSurname): void
    {
        $this->secondSurname = $secondSurname;
    }

    /**
     * @return string User credit account identifier
     */
    public function getAccountId() : ?string
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId User credit account identifier
     */
    public function setAccountId(?string $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string Internal identifier for user on Monge system
     */
    public function getPersonId() : string
    {
        return $this->personId;
    }

    /**
     * @param string $personId Internal identifier for user on Monge system
     */
    public function setPersonId(string $personId): void
    {
        $this->personId = $personId;
    }

    /**
     * @return string User account email
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email User account email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}