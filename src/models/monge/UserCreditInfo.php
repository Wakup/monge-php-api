<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-12
 * Time: 11:35
 */

namespace Wakup;

class UserCreditInfo
{
    private $personId, $accountId, $accountStatusId, $accountStatus, $availableCreditLine,
        $availableCreditFee, $creditLineId;

    /**
     * @return int Internal identifier for user on credit system
     */
    public function getPersonId() : ?int
    {
        return $this->personId;
    }

    /**
     * @param int $personId Internal identifier for user on credit system
     */
    public function setIdPerson(?int $personId): void
    {
        $this->personId = $personId;
    }

    /**
     * @return int Identifier for user account on credit system
     */
    public function getAccountId() : ?int
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId Identifier for user account on credit system
     */
    public function setIdCuenta(?int $accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return int Numeric identifier for user account status
     */
    public function getAccountStatusId() : ?int
    {
        return $this->accountStatusId;
    }

    /**
     * @param int $accountStatusId Numeric identifier for user account status on credit system
     */
    public function setIdStatusCuenta(int $accountStatusId): void
    {
        $this->accountStatusId = $accountStatusId;
    }

    /**
     * @return string Description for user account status on credit system
     */
    public function getAccountStatus() : ?string
    {
        return $this->accountStatus;
    }

    /**
     * @param string $accountStatus Description for user account status on credit system
     */
    public function setAccountStatus(?string $accountStatus): void
    {
        $this->accountStatus = $accountStatus;
    }

    /**
     * @return float Amount of credit line available for user
     */
    public function getAvailableCreditLine() : ?float
    {
        return $this->availableCreditLine;
    }

    /**
     * @param float $availableCreditLine Amount of credit line available for user
     */
    public function setDisponibleLinea(?float $availableCreditLine): void
    {
        $this->availableCreditLine = $availableCreditLine;
    }

    /**
     * @return float Available fee for user credit line
     */
    public function getAvailableCreditFee() : ?float
    {
        return $this->availableCreditFee;
    }

    /**
     * @param float $availableCreditFee Available fee for user credit line
     */
    public function setDisponibleCuota(?float $availableCreditFee): void
    {
        $this->availableCreditFee = $availableCreditFee;
    }

    /**
     * @return int Identifier for credit line assigned to user on credit system
     */
    public function getCreditLineId() : ?int
    {
        return $this->creditLineId;
    }

    /**
     * @param int $creditLineId Identifier for credit line assigned to user on credit system
     */
    public function setIdLineaCredito(?int $creditLineId): void
    {
        $this->creditLineId = $creditLineId;
    }
}