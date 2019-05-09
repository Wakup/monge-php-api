<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-05-08
 * Time: 20:13
 */

namespace Wakup;


class PaymentInfo
{

    const PAYMENT_METHOD_PAYPAL = 'PAY';
    const PAYMENT_METHOD_CREDIT_CARD = 'TAR';
    const PAYMENT_METHOD_FLEXIPAGO = 'FLE';

    private $id, $financialPromotion, $financialScenario;

    /**
     * PaymentInfo constructor.
     * @param $id
     * @param $financialPromotion
     * @param $financialScenario
     */
    public function __construct(string $id,
                                FinancialPromotion $financialPromotion = null,
                                FinancialScenario $financialScenario = null)
    {
        $this->id = $id;
        $this->financialPromotion = $financialPromotion;
        $this->financialScenario = $financialScenario;
    }


    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return FinancialPromotion|null
     */
    public function getFinancialPromotion() : ?FinancialPromotion
    {
        return $this->financialPromotion;
    }

    /**
     * @return FinancialScenario|null
     */
    public function getFinancialScenario() : ?FinancialScenario
    {
        return $this->financialScenario;
    }

}