<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:44
 */

namespace Wakup;


use Wakup\Requests\MongeRequest;
use Wakup\Requests\WakupRequest;

class Client extends HttpClient
{
    // User session requests
    // ----------------------//

    public function isValidPassword(string $username, string $password) : bool
    {
        return true;
    }

    public function register(string $username, string $email, string $password)
    {
        return true;
    }

    public function resetPassword(string $username, string $newPassword)
    {
        return true;
    }


    // WAKUP Catalog requests
    // ----------------------//

    /**
     * Obtains the paginated list of product attributes registered on Wakup catalogue manager
     *
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedAttributes Product attributes list with pagination information
     * @throws WakupException
     */
    public function getPaginatedAttributes($page = 0, $perPage = 25) : PaginatedAttributes
    {
        $request = new WakupRequest($this->config, $this->wakupClient, new PaginatedAttributes(),
            'catalog/attributes', [], $page, $perPage);
        return $request->launch();
    }

    /**
     * Obtains the paginated list of product categories registered on Wakup catalogue manager
     *
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedCategories Product categories list with pagination information
     * @throws WakupException
     */
    public function getPaginatedCategories($page = 0, $perPage = 25) : PaginatedCategories
    {
        $request = new WakupRequest($this->config, $this->wakupClient, new PaginatedCategories(),
            'catalog/categories', [], $page, $perPage);
        return $request->launch();
    }

    /**
     * Obtains the list of products that has changed from the last update time. The returning products will only contain
     * price or details info if it has changed since given date.
     *
     * @param \DateTime $lastUpdate Time of last update
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedProducts List of paginated products that has changed since last update time
     * @throws WakupException
     */
    public function getPaginatedProducts(\DateTime $lastUpdate = null, $page = 0, $perPage = 25) : PaginatedProducts
    {
        $params = $lastUpdate != null ? ['lastUpdate' => $lastUpdate->format(\DateTime::ATOM)] : [];
        $request = new WakupRequest($this->config, $this->wakupClient, new PaginatedProducts(),
            'catalog/products', $params, $page, $perPage);
        return $request->launch();
    }

    // MONGE Requests
    // ---------------//

    /**
     * Obtains the credit info of the user on Monge system, including available credit amount, fee and internal
     * identifiers for later use on other requests.
     *
     * @param string $userIdentifier User VAT identifier
     * @return UserCreditInfo Credit information for given user. Null if user is not registered on credit system.
     * @throws WakupException
     */
    public function getUserCreditInfo(string $userIdentifier) : UserCreditInfo
    {
        $params = ['TipoIdentificacion' => 51, 'Identificacion' => $userIdentifier];
        $request = new MongeRequest($this->config, $this->mongeClient, UserCreditInfo::class,
            'Cliente/BuscarCliente', 96, $params);
        // Return only first value
        $responseArray = $request->launch();
        return count($responseArray) > 0 ? $responseArray[0] : null;
    }

    /**
     * Obtains the available financial promotions for given user and products list.
     *
     * @param int $personId Monge internal user identifier
     * @param string[] $skuList List of product SKUs included con shopping cart
     * @return FinancialPromocion[] List of financial promotions that applies to given user and cart
     * @throws WakupException
     */
    public function getFinancialPromotions(int $personId, array $skuList) : array
    {
        $params = [
            'codigocanalVenta' => $this->config->mongeChannelCode,
            'codigoTienda' => $this->config->mongeShopCode,
            'codigoArticulos' => join(',', $skuList),
            'idPersona' => $personId
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, FinancialPromocion::class,
            'Cotizacion/ListarPromocion', 98, $params);
        return $request->launch();
    }

    /**
     * Obtains the financial scenarios for a given promotion and cart
     *
     * @param int $personId Monge internal user identifier
     * @param int $creditLineId Monge internal identifier for user credit line
     * @param int $promotionId Selected promotion ID
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return FinancialScenario[] List of financial scenarios available for given cart and promotion
     * @throws WakupException
     */
    public function getFinancialScenarios(
        int $personId, int $creditLineId, int $promotionId, Cart $cart) : array
    {
        $skuArray = [];
        $guaranteeSkuArray = [];
        $pricesArray = [];
        $guaranteePricesArray = [];
        for($i = 0; $i < count($cart->getProducts()); ++$i) {
            $product = $cart->getProducts()[$i];
            $formattedSku = join('&', [$product->getTypeId(), 0, $i, $product->getSku()]);
            switch ($product->getTypeId()) {
                case CartProduct::TYPE_ID_PRODUCT:
                    array_push($skuArray, $formattedSku);
                    array_push($pricesArray, $product->getTotalPrice());
                    break;
                case CartProduct::TYPE_ID_GUARANTEE:
                    array_push($guaranteeSkuArray, $formattedSku);
                    array_push($guaranteePricesArray, $product->getTotalPrice());
                    break;
            }
        }

        $params = [
            'codCliente' => $personId,
            'lineaCredito' => $creditLineId,
            'idPromocion' => $promotionId,
            'monto' => $cart->getTotalPrice(),
            'codProductos' => join(';', $skuArray),
            'precioProductos' => join(';', $pricesArray),
            'codigoGarantia' => join(';', $guaranteeSkuArray),
            'precioGarantia' => join(';', $guaranteePricesArray),
            'moneda' => $this->config->mongeCurrencyId
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, FinancialScenario::class,
            'Cotizacion/ListarEscenarios', 98, $params);
        return $request->launch();
    }

    /**
     * Obtains the stock availability of the given cart in the requested stores
     *
     * @param array $stores Array of store identifiers to obtain stock from
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return StoreStock[] List of stock availability for each requested store
     * @throws WakupException
     */
    public function getStoresStock(array $stores, Cart $cart) : array
    {
        $items = [];
        foreach ($cart->getProducts() as $cartProduct) {
            array_push($items, ['sku' => $cartProduct->getSku(), 'cantidad' => $cartProduct->getCount()]);
        }
        $params = [
            'tiendas' => $stores,
            'sistema' => 'Ecommerce',
            'articulos' => $items
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, StoreStock::class,
            'Inventario/ConsultaInventario', 93, $params);
        return $request->launch();
    }

    /**
     * Makes the reservation of the products in the cart before the payment process of the order
     *
     * @param string $storeId Identifier of the store in which the reservation is done
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return string Reservation identifier. Required to later cancel it.
     * @throws WakupException
     */
    public function reserveOrderStock(string $storeId, Cart $cart) : string
    {
        $items = [];
        foreach ($cart->getProducts() as $cartProduct) {
            array_push($items, [
                    'sku' => $cartProduct->getSku(),
                    'cantidad' => $cartProduct->getCount(),
                    'tienda' => $storeId,
                    'pais' => $this->config->mongeCountryCode]
            );
        }
        $request = new MongeRequest($this->config, $this->mongeClient, '',
            'Inventario/ReservaInventario', 93, $items, false);
        return $request->launch();
    }

    /**
     * Cancels a previously made store stock reservation
     *
     * @param string $reservationId Id of the reservation
     * @return bool Returns true if request is successful
     * @throws WakupException
     */
    public function cancelOrderStockReservation(string $reservationId) : bool
    {
        $params = ['idReserva' => $reservationId, 'codigoUsuario' => 'TiendaVirtual'];
        $request = new MongeRequest($this->config, $this->mongeClient, null,
            'Inventario/ReversaReservaInventario', 93, $params, false);
        $request->launch();
        return true;
    }

}