<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-05-08
 * Time: 18:13
 */

namespace Wakup;

class ContactPreferences
{
    private $notifyWhatsapp, $notifySMS, $notifyEmail, $email, $phoneNumber;

    /**
     * Contact preferences selected by the user when processing a new order
     * @param $notifyWhatsapp bool Defines if the user wants to receive order status updates vía WhatsApp
     * @param $notifySMS bool Defines if the user wants to receive order status updates vía SMS
     * @param $notifyEmail bool Defines if the user wants to receive order status updates vía email
     * @param $email string|null User email address
     * @param $phoneNumber string|null User phone number
     */
    public function __construct(bool $notifyWhatsapp, bool $notifySMS, bool $notifyEmail, ?string $email, ?string $phoneNumber)
    {
        $this->notifyWhatsapp = $notifyWhatsapp;
        $this->notifySMS = $notifySMS;
        $this->notifyEmail = $notifyEmail;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return bool Defines if the user wants to receive order status updates vía WhatsApp
     */
    public function isNotifyWhatsapp(): bool
    {
        return $this->notifyWhatsapp;
    }

    /**
     * @return bool Defines if the user wants to receive order status updates vía SMS
     */
    public function isNotifySMS(): bool
    {
        return $this->notifySMS;
    }

    /**
     * @return bool Defines if the user wants to receive order status updates vía email
     */
    public function isNotifyEmail(): bool
    {
        return $this->notifyEmail;
    }

    /**
     * @return string|null User email address
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null User phone number
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }



}