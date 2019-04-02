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

        #TODO separate warranty and standard product, export json serialize to request
        $orderJson = [
            'OrdenPedidoDetalle' => $productArray,
            'OrdenPedidoDetalleExtragarantia' => $warrantyArray,
            'OrdenPedidoFinanciacion' => null,
            'OrdenPedidoFormasPago' => [
                [
                    'FormaPago' => $order->getPaymentMethod(),
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
            'Tienda' => "C{$config->mongeShopCode}",  // Requires to prepend C to shop code
            'TiendaRetiro' => $store->getSku(),
            'TipoOrden' => 'Orden.Ecommerce',
            'TipoVenta' => 'CR00005',
            'CanalVenta' => '260',
            'CodigoMoneda' => $config->mongeCurrencyId,
            'FechaProceso' => date('c'),
            'FormaPago' => $order->getPaymentMethod(),
            'NumeroOrden' => $order->getOrderNumber(),
            'MontoCompra' => $cart->getProductsPriceWithoutTax(),
            'Impuesto' => $cart->getProductsTaxAmount(),
            'TotalCompra' => $cart->getProductsPrice(),
            // Notifications
            'NotificarWhatsApp' => false,
            'NotificarSms' => false,
            'NotificarEmail' => true,
            'EmailContacto' => 'pruebas09@gmail.com',
            'TelefonoContacto' => '8324-8614',
            // Credit info
            'Prima' => 0,
            'Plazo' => 0,
            'TasaInteresNormal' => 0,
            'TasaInteresMora' => 0,
            'TasaImpuesto' => 0,
            'CuotaPactada' => 0,
            'Descuento' => 0,
            'MontoFinanciado' => 0,
            'IdPromocion' => 0, // Server crashes if null
            'IdSegmento' => 0, // Server crashes if null
            'DescuentoTotal' => null,
            'EntregaCasa' => null,
            'FechaPrimerPago' => null,
            // Delivery
            'Pais' => null,
            'Provincia' => null,
            'Canton' => null,
            'Distrito' => null,
            'Direccion' => null,
            'DireccionEntrega' => null,
            'DireccionExactaEntregaCasa' => null
        ];

        $json = [
            'tienda' => "C{$config->mongeShopCode}", // Requires to prepend C to shop code
            'idMensaje' => 123,
            'idEstadoMensaje' => 0,
            'idTipoMensaje' => 0,
            'idPais' => 1,
            'detalleProceso' => [],
            'reintentos' => 0,
            'estadoProceso' => 0,
            'msjError' => "",
            'pais' => [
                'nombre' => "CR",
                'idPais' => 1,
                'codigoSAP' => "CR"
            ],
            'fecha' => date('Y-m-d'),
            'detalle' => json_encode($orderJson),
            'usuario' => "Ecommerce",
            'origen' => "Ecommerce",
        ];

        parent::__construct($config, $client, null,
            'Factura/PostProcesarFactura', 92, $json, false);
    }
}