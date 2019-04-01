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
            'OrdenPedidoDetalleExtragarantia' => $warranty,
            'OrdenPedidoFinanciacion' => null,
            'OrdenPedidoFormasPago' => [
                [
                    'FormaPago' => $order->getPaymentMethod(),
                    'Monto' => $order->getCart()->getProductsPrice(),
                    'Referencia' => ''
                ]
            ],
            'cliente' => [
                'Identificacion' => '01-0730-0179',
                'TipoIdentificacion' => 'CEDULA',
                'PrimerNombre' => 'Ana',
                'SegundoNombre' => 'Isabel',
                'PrimerApellido' => 'Ramirez',
                'SegundoApellido' => 'Ramirez',
                'IdCuenta' => '1365853',
                'IdPersona' => '1408804',
                'Correo' => 'pruebas09@gmail.com'
            ],
            'CodigoUsuario' => 'CLIENTE_ECOMMERCE',
            'Tienda' => $config->mongeShopCode,
            'TiendaRetiro' => $store->getSku(),
            'TipoOrden' => 'Orden.Ecommerce',
            'TipoVenta' => 'CR00005',
            'CanalVenta' => '260',
            'FormaPago' => $order->getPaymentMethod(),
            'NumeroOrden' => $order->getOrderNumber(),
            'Plazo' => 0,
            'TasaInteresNormal' => 0,
            'TasaInteresMora' => 0,
            'TasaImpuesto' => 0,
            'CuotaPactada' => 0,
            'Descuento' => 0,
            'MontoFinanciado' => 0,
            'MontoCompra' => 5743.36,
            'Impuesto' => 746.64,
            'TotalCompra' => 6490,
            'NotificarWhatsApp' => false,
            'NotificarSms' => false,
            'NotificarEmail' => true,
            'EmailContacto' => 'pruebas09@gmail.com',
            'TelefonoContacto' => '8324-8614',
            'CodigoMoneda' => '188',
            'Prima' => 0,
            'FechaProceso' => '2018-06-27T21:41:30.147',
            'IdPromocion' => 0,
            'IdSegmento' => 50001,
            'DescuentoTotal' => null,
            'EntregaCasa' => null,
            'FechaPrimerPago' => null,
            'Pais' => null,
            'Provincia' => null,
            'Canton' => null,
            'Distrito' => null,
            'Direccion' => null,
            'DireccionEntrega' => null,
            'DireccionExactaEntregaCasa' => null
        ];

        $json = [
            'idMensaje' => 123,
            'detalleProceso' => [],
            'tienda' => "C212",
            'reintentos' => 0,
            'estadoProceso' => 0,
            'msjError' => "",
            'pais' => [
                'nombre' => "CR",
                'idPais' => 1,
                'codigoSAP' => "CR"
            ],
            'fecha' => "2018-11-13",
            'detalle' => json_encode($orderJson),
            'idEstadoMensaje' => 0,
            'usuario' => "Ecommerce",
            'idTipoMensaje' => 0,
            'origen' => "Ecommerce",
            'idPais' => 1
        ];

        parent::__construct($config, $client, null,
            'Factura/PostProcesarFactura', 92, $json, false);
    }
}