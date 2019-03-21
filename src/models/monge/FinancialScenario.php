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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setIdPromocion($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     */
    public function setPlazo($term): void
    {
        $this->term = $term;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setTasa($rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param mixed $fee
     */
    public function setCuota($fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->totalFee;
    }

    /**
     * @param mixed $totalFee
     */
    public function setCuotaTotalDePago($totalFee): void
    {
        $this->totalFee = $totalFee;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescripcionSegmento($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param mixed $paymentDate
     */
    public function setFechaDePago($paymentDate): void
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return mixed
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param mixed $frequency
     */
    public function setFrecuencia($frequency): void
    {
        $this->frequency = $frequency;
    }

    /**
     * @return mixed
     */
    public function getAnnualEffectiveRate()
    {
        return $this->annualEffectiveRate;
    }

    /**
     * @param mixed $annualEffectiveRate
     */
    public function setTCEA($annualEffectiveRate): void
    {
        $this->annualEffectiveRate = $annualEffectiveRate;
    }

    /**
     * @return mixed
     */
    public function getGuaranteeFee()
    {
        return $this->guaranteeFee;
    }

    /**
     * @param mixed $guaranteeFee
     */
    public function setExtraGarantia($guaranteeFee): void
    {
        $this->guaranteeFee = $guaranteeFee;
    }

    /**
     * @return mixed
     */
    public function getSegmentId()
    {
        return $this->segmentId;
    }

    /**
     * @param mixed $segmentId
     */
    public function setSegmento($segmentId): void
    {
        $this->segmentId = $segmentId;
    }


}