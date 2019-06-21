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

    private const PAYMENT_METHOD_PAYPAL = 'PAY';
    private const PAYMENT_METHOD_CREDIT_CARD = 'TAR.TV';
    private const PAYMENT_METHOD_FLEXIPAGO = 'FLE';

    private $id, $financialPromotion, $financialScenario, $userCreditInfo, $voucherNumber, $authMessage;

    /**
     * Private constructor
     * @param $id string External identifier for the payment method selected by user
     * @param $financialPromotion FinancialPromotion|null Financial promotion selected by user
     * @param $financialScenario FinancialScenario|null Financial scenario selected by user
     * @param $creditInfo UserCreditInfo User info from Monge credit system
     * @param $voucherNumber string Receipt number for credit card payment
     * @param $authMessage string Authorization message obtained from credit card payment
     */
    private function __construct(string $id,
                                 ?FinancialPromotion $financialPromotion = null,
                                 ?FinancialScenario $financialScenario = null,
                                 ?UserCreditInfo $creditInfo = null,
                                 ?string $voucherNumber = null,
                                 ?string $authMessage = null)
    {
        $this->id = $id;
        $this->financialPromotion = $financialPromotion;
        $this->financialScenario = $financialScenario;
        $this->userCreditInfo = $creditInfo;
        $this->voucherNumber = $voucherNumber;
        $this->authMessage = $authMessage;
    }

    /**
     * Creates a wrapper object with the payment information for PayPal method
     * @return PaymentInfo Payment information for PayPal
     */
    public static function payPal() : PaymentInfo
    {
        return new self(self::PAYMENT_METHOD_PAYPAL);
    }

    /**
     * Creates a wrapper object with the payment information for Credit Card method
     * @param $voucherNumber string Receipt number for credit card payment
     * @param $authMessage string Authorization message obtained from credit card payment
     * @return PaymentInfo Payment information for Credit Card
     */
    public static function creditCard(string $voucherNumber, string $authMessage) : PaymentInfo
    {
        return new self(self::PAYMENT_METHOD_CREDIT_CARD,
            null, null, null,
            $voucherNumber, $authMessage);
    }

    /**
     * Creates a wrapper object with the payment information for payment on credit method
     * @param FinancialPromotion $financialPromotion Financial promotion selected by user
     * @param FinancialScenario $financialScenario Financial scenario selected by user
     * @param UserCreditInfo $creditInfo Credit information for current user on Monge financial system
     * @return PaymentInfo Payment information for financed payments
     */
    public static function onCredit(FinancialPromotion $financialPromotion,
                                    FinancialScenario $financialScenario,
                                    UserCreditInfo $creditInfo) : PaymentInfo
    {
        return new self(self::PAYMENT_METHOD_FLEXIPAGO, $financialPromotion, $financialScenario, $creditInfo);
    }

    /**
     * @return string External identifier for the payment method selected by user
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return FinancialPromotion|null Financial promotion selected by user
     */
    public function getFinancialPromotion() : ?FinancialPromotion
    {
        return $this->financialPromotion;
    }

    /**
     * @return FinancialScenario|null Financial scenario selected by user
     */
    public function getFinancialScenario() : ?FinancialScenario
    {
        return $this->financialScenario;
    }

    /**
     * @return string|null Internal identifier for user on Monge system
     */
    public function getPersonId() : ?string
    {
        return is_null($this->userCreditInfo) ? null : $this->userCreditInfo->getPersonId();
    }

    /**
     * @return string|null User credit account identifier
     */
    public function getAccountId() : ?string
    {
        return is_null($this->userCreditInfo) ? null : $this->userCreditInfo->getAccountId();
    }

    /**
     * @return string|null Receipt number for credit card payment
     */
    public function getVoucherNumber(): ?string
    {
        return $this->voucherNumber;
    }

    /**
     * @return string|null Authorization message obtained from credit card payment
     */
    public function getAuthMessage(): ?string
    {
        return $this->authMessage;
    }

}