<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 12:02
 */

namespace Wakup\Requests;


use GuzzleHttp\Client;
use Wakup\Config;
use Wakup\Order;

class ProcessOrderRequest extends MongeRequest
{


    /**
     * ProcessOrderInvoiceRequest constructor.
     */
    public function __construct(Config $config, Client $client, Order $order)
    {
        $json = [];
        parent::__construct($config, $client, null,
            'Factura/PostProcesarFactura', 92, $order->toJson(), false);
    }
}