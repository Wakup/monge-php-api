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
        $cart = $order->getCart();
        $store = $order->getStore();
        $user = $order->getUser();
        $contact = $order->getContactPreferences();
        $paymentInfo = $order->getPaymentInfo();
        $scenario = $paymentInfo->getFinancialScenario();
        $promotion = $paymentInfo->getFinancialPromotion();
        $productArray = [];
        $warrantyArray = [];
        for($i = 0; $i < count($cart->getProducts()); ++$i) {
            $product = $cart->getProducts()[$i];
            array_push($productArray, [
                'Bodega' => $store->getWarehouseId(),
                'Sku' => $product->getSku(),
                'Cantidad' => $product->getCount(),
                'PrecioUnitario' => $product->getPrice(),
                'TasaImpuesto' => $product->getTaxRate(),
                'Impuesto' => $product->getTaxAmount(),
                'Subtotal' => $product->getTotalPriceWithoutTax(),
                'Total' => $product->getTotalPrice(),
                'Descuento' => 0,
                'DescuentoDetalle' => null,
                'TipoDescuento' => null,
                'CostoUnitario' => 0,
            ]);
            if ($product->hasWarranty()) {
                $warranty = $product->getWarrantyPlan();
                array_push($warrantyArray, [
                    'Sku' => $warranty->getSku(),
                    'Descripcion' => $warranty->getDescription(),
                    'Cantidad' => $product->getCount(),
                    'Plazo' => $warranty->getTerm(),
                    'PrecioTotal' => $product->getWarrantyPlanTotalPrice(),
                    'NumeroLinea' => $i,
                    'Serie' => '',
                ]);
            }
        }

        $orderJson = [
            'OrdenPedidoDetalle' => $productArray,
            'OrdenPedidoDetalleExtragarantia' => $warrantyArray,
            'OrdenPedidoFinanciacion' => null,
            'OrdenPedidoFormasPago' => [
                [
                    'FormaPago' => $order->getPaymentInfo(),
                    'Monto' => $order->getCart()->getProductsPrice(),
                    'Referencia' => ''
                ]
            ],
            'cliente' => [
                'Identificacion' => $user->getId(),
                'TipoIdentificacion' => $user->getIdType(),
                'PrimerNombre' => $user->getFirstName(),
                'SegundoNombre' => $user->getMiddleName(),
                'PrimerApellido' => $user->getFirstSurname(),
                'SegundoApellido' => $user->getSecondSurname(),
                'IdCuenta' => $user->getAccountId(),
                'IdPersona' => $user->getPersonId(),
                'Correo' => $user->getEmail()
            ],
            'CodigoUsuario' => 'CLIENTE_ECOMMERCE',
            'TipoOrden' => 'Orden.Ecommerce',
            'TipoVenta' => 'CON',
            'CanalVenta' => 'VEN.WEB',
            'Tienda' => "C{$config->mongeShopCode}",  // Requires to prepend C to shop code
            'TiendaRetiro' => $store->getSku(),
            'CodigoMoneda' => $config->mongeCurrencyId,
            'FechaProceso' => date('c'),
            'FormaPago' => $order->getPaymentInfo(),
            'NumeroOrden' => $order->getOrderNumber(),
            'MontoCompra' => $cart->getProductsPriceWithoutTax(),
            'Impuesto' => $cart->getProductsTaxAmount(),
            'TotalCompra' => $cart->getProductsPrice(),
            'IdentificadorReserva' => $order->getReservationId(),
            // Notifications
            'NotificarWhatsApp' => $contact->isNotifyWhatsapp(),
            'NotificarSms' => $contact->isNotifySMS(),
            'NotificarEmail' => $contact->isNotifyEmail(),
            'EmailContacto' => $contact->getEmail(),
            'TelefonoContacto' => $contact->getPhoneNumber(),
            // Credit info
            'MontoFinanciado' => $scenario != null ? $cart->getProductsPrice() : 0,
            'IdPromocion' => $promotion != null ? $promotion->getId() : 0,
            'IdSegmento' => $scenario != null ? $scenario->getSegmentId() : 0,
            'Plazo' => $scenario != null ? $scenario->getTerm() : 0,
            'TasaInteresNormal' => $scenario != null ? $scenario->getRate() : 0,
            'CuotaPactada' => $scenario != null ? $scenario->getFee() : 0,
            'Prima' => 0,
            'TasaInteresMora' => 0,
            'TasaImpuesto' => 0,
            'Descuento' => 0,
            'DescuentoTotal' => 0,
            'FechaPrimerPago' => null,
            // Delivery
            'EntregaCasa' => null,
            'Pais' => null,
            'Provincia' => null,
            'Canton' => null,
            'Distrito' => null,
            'Direccion' => null,
            'DireccionEntrega' => null,
            'DireccionExactaEntregaCasa' => null
        ];

        $json = [
            'pais' => $config->mongeCountryCode,
            'tienda' => "C{$config->mongeShopCode}", // Requires to prepend C to shop code
            'fecha' => date('Y-m-d'),
            'detalle' => json_encode($orderJson),
            'estadoProceso' => 0,
            'origen' => "Ecommerce"
        ];

        parent::__construct($config, $client, null,
            'Factura/PostProcesarFactura', 92, $json, false);
    }
}