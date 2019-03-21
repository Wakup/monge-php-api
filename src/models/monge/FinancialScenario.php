<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-14
 * Time: 14:19
 */

namespace Wakup;


class FinancialScenario
{
    private $id, $term, $rate, $fee, $totalFee, $description, $paymentDate,
        $frequency, $annualEffectiveRate, $guaranteeFee, $segmentId;

    /**
     * @return int Scenario identifier
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id Scenario identifier
     */
    public function setIdPromocion(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float Credit term
     */
    public function getTerm() : float
    {
        return $this->term;
    }

    /**
     * @param float $term Credit term
     */
    public function setPlazo(string $term): void
    {
        $this->term = $term;
    }

    /**
     * @return float Interest rate of the credit
     */
    public function getRate() : float
    {
        return $this->rate;
    }

    /**
     * @param float $rate Interest rate of the credit
     */
    public function setTasa(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return float Fee of the amount that is being financed
     */
    public function getFee() : float
    {
        return $this->fee;
    }

    /**
     * @param float $fee Fee of the amount that is being financed
     */
    public function setCuota(float $fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @return float Total quota adding up previous debt installments
     */
    public function getTotalFee() : float
    {
        return $this->totalFee;
    }

    /**
     * @param float $totalFee Total quota adding up previous debt installments
     */
    public function setCuotaTotalDePago(float $totalFee): void
    {
        $this->totalFee = $totalFee;
    }

    /**
     * @return string Description of the segment
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description Description of the segment
     */
    public function setDescripcionSegmento(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime Date of first payment
     */
    public function getPaymentDate() : \DateTime
    {
        return $this->paymentDate;
    }

    /**
     * @param string $paymentDate Date of first payment
     */
    public function setFechaDePago(\DateTime $paymentDate): void
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return string Frequency of payment (Biweekly, Monthly, etc)
     */
    public function getFrequency() : string
    {
        return $this->frequency;
    }

    /**
     * @param string $frequency Frequency of payment (Biweekly, Monthly, etc)
     */
    public function setFrecuencia(string $frequency): void
    {
        $this->frequency = $frequency;
    }

    /**
     * @return float Annual effective rate
     */
    public function getAnnualEffectiveRate() : float
    {
        return $this->annualEffectiveRate;
    }

    /**
     * @param float $annualEffectiveRate Annual effective rate
     */
    public function setTCEA(float $annualEffectiveRate): void
    {
        $this->annualEffectiveRate = $annualEffectiveRate;
    }

    /**
     * @return float Fee for the extra guarantee
     */
    public function getGuaranteeFee() : float
    {
        return $this->guaranteeFee;
    }

    /**
     * @param float $guaranteeFee Fee for the extra guarantee
     */
    public function setExtraGarantia(float $guaranteeFee): void
    {
        $this->guaranteeFee = $guaranteeFee;
    }

    /**
     * @return int Credit segment identifier
     */
    public function getSegmentId() : int
    {
        return $this->segmentId;
    }

    /**
     * @param int $segmentId Credit segment identifier
     */
    public function setSegmento(int $segmentId): void
    {
        $this->segmentId = $segmentId;
    }


}