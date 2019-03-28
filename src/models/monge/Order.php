<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 17:35
 */

namespace Wakup;


class Order
{

    private $config, $cart;

    public function toJson()
    {
        #TODO separate guarantee and standard product, export json serialize to request
        $orderJson = [
            'OrdenPedidoDetalle' => [
                [
                    'Bodega' => '1001',
                    'DescuentoDetalle' => null,
                    'TipoDescuento' => null,
                    'Sku' => '100331',
                    'Cantidad' => 1,
                    'CostoUnitario' => 0,
                    'PrecioUnitario' => 6490,
                    'TasaImpuesto' => 13,
                    'Impuesto' => 746.6372,
                    'Descuento' => 0,
                    'Subtotal' => 1000,
                    'Total' => 10000
                ]
            ],
            'OrdenPedidoDetalleExtragarantia' => [
                [
                    'Sku' => '100331',
                    'Descripcion' => 'Extragarantia',
                    'Serie' => '',
                    'Cantidad' => 1,
                    'Plazo' => 12,
                    'PrecioTotal' => 100000,
                    'NumeroLinea' => 1
                ]
            ],
            'OrdenPedidoFinanciacion' => null,
            'OrdenPedidoFormasPago' => [
                [
                    'FormaPago' => 'TAR',
                    'Monto' => 6490,
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
            'Tienda' => 'C212',
            'TiendaRetiro' => 'C003',
            'TipoOrden' => 'Orden.Ecommerce',
            'TipoVenta' => 'CR00005',
            'CanalVenta' => '260',
            'FormaPago' => 'TAR',
            'NumeroOrden' => '123321143',
            'Plazo' => 0,
            'TasaInteresNormal' => 0,
            'TasaInteresMora' => 0,
            'TasaImpuesto' => 0,
            'CuotaPactada' => 0,
            'MontoCompra' => 5743.36,
            'Descuento' => 0,
            'Impuesto' => 746.64,
            'MontoFinanciado' => 0,
            'TotalCompra' => 6490,
            'NotificarWhatsApp' => false,
            'NotificarSms' => false,
            'NotificarEmail' => true,
            'EmailContacto' => 'pruebas09@gmail.com',
            'TelefonoContacto' => '8324-8614',
            'CodigoMoneda' => '188',
            'Prima' => 0,
            'DescuentoTotal' => null,
            'EntregaCasa' => null,
            'FechaProceso' => '2018-06-27T21:41:30.147',
            'IdPromocion' => 0,
            'IdSegmento' => 50001,
            'FechaPrimerPago' => null,
            'Pais' => null,
            'Provincia' => null,
            'Canton' => null,
            'Distrito' => null,
            'Direccion' => null,
            'DireccionEntrega' => null,
            'DireccionExactaEntregaCasa' => null
        ];

        return [
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
    }
}