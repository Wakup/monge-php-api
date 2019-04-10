<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:44
 */

namespace Wakup;


use Wakup\Requests\LoginRequest;
use Wakup\Requests\MongeRequest;
use Wakup\Requests\ProcessOrderRequest;
use Wakup\Requests\UsersRequest;
use Wakup\Requests\WakupRequest;

class Client extends HttpClient
{
    // User session requests
    // ----------------------//

    /**
     * Makes a login attempt with given credentials and returns true if there is a match with email and password and
     * false if it is incorrect
     *
     * @param string $email User login email
     * @param string $password User password
     * @return bool Returns true if login is successful
     * @throws WakupException
     */
    public function login(string $email, string $password) : bool
    {
        $request = new LoginRequest($this->config, $this->defaultClient, $email, $password);
        return $request->launch();
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws WakupException
     */
    public function register(string $email, string $password) : AzureUser
    {
        $jsonBody = [
            'accountEnabled' => true,
            'signInNames' => [
                [
                    'type' => 'emailAddress',
                    'value' => $email
                ]
            ],
            'displayName' => $email,
            'creationType' => 'LocalAccount',
            'passwordProfile' => [
                'password' => $password,
                'forceChangePasswordNextLogin' => false
            ],
            'passwordPolicies' => 'DisablePasswordExpiration'
        ];
        $request = new UsersRequest($this->config, $this->azureClient, 'POST', [], [], $jsonBody, new AzureUser());
        return $request->launch();
    }

    /**
     * @param string $email
     * @param string $newPassword
     * @return bool
     * @throws WakupException
     */
    public function resetPassword(string $email, string $newPassword)
    {
        $user = $this->findUser($email);
        $jsonBody = [
            "passwordProfile" => [
                "password" => $newPassword,
                "forceChangePasswordNextLogin" => false
            ]
        ];
        $request = new UsersRequest($this->config, $this->azureClient, 'PATCH', [], [], $jsonBody,
            null, $user->getObjectId());
        $request->launch();
        return true;
    }

    /**
     * @param $email
     * @return bool
     * @throws WakupException
     */
    public function deleteUser($email)
    {
        $user = $this->findUser($email);
        $request = new UsersRequest($this->config, $this->azureClient, 'DELETE', [], [], null,
            null, $user->getObjectId());
        $request->launch();
        return true;
    }

    /**
     * @param string $email
     * @return User
     * @throws WakupException
     */
    public function findUser(string $email) : AzureUser
    {
        $params = ['$filter' => "signInNames/any(x:x/value eq '{$email}')"];
        $request = new UsersRequest($this->config, $this->azureClient, 'GET', [], $params, null,
            AzureUser::class);
        return $request->launch()[0];
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
        $request = new WakupRequest($this->config, $this->defaultClient, new PaginatedAttributes(),
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
        $request = new WakupRequest($this->config, $this->defaultClient, new PaginatedCategories(),
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
        $request = new WakupRequest($this->config, $this->defaultClient, new PaginatedProducts(),
            'catalog/products', $params, $page, $perPage);
        return $request->launch();
    }

    /**
     * Returns the list of N stores near to the given location
     * @param float $latitude Latitude component for search location coordinates
     * @param float $longitude Longitude component for search location coordinates
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedStores
     */
    public function getNearestStores(float $latitude, float $longitude, $page = 0, $perPage = 25) : PaginatedStores
    {
        // TODO make service call when its ready
        $pagination = new PaginatedStores();
        $pagination->setPage($page);
        $pagination->setPerPage($perPage);
        $pagination->setTotalPages(1);
        $pagination->setHasMore(false);
        $pagination->setStores([
            new Store('C002', '1001', 'Tienda 1', 'Dirección tienda 1', 9.93, -84.21),
            new Store('C003', '1002', 'Tienda 2', 'Dirección tienda 2', 9.7, -84.51),
            new Store('C004', '1003', 'Tienda 3', 'Dirección tienda 3', 9.6, -84.71),
            new Store('C005', '1004', 'Tienda 4', 'Dirección tienda 4', 9.3, -84.25),
            new Store('C006', '1005', 'Tienda 5', 'Dirección tienda 5', 9.99, -83.91),
        ]);
        return $pagination;
    }

    /**
     * Obtains the stock available for the given cart products in the stores nearest to the given location
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @param float $latitude Latitude component for search location coordinates
     * @param float $longitude Longitude component for search location coordinates
     * @param int $storeCount Max store count to obtain
     * @return StoreStock[] List of objects containing available stock for requested products in nearest stores
     * @throws WakupException
     */
    public function getNearestStoresStock(Cart $cart, float $latitude, float $longitude, $storeCount = 10) : array
    {
        $nearStores = $this->getNearestStores($latitude, $longitude, 0, $storeCount)->getStores();
        $storeIds = [];
        foreach ($nearStores as $store) {
            $storeIds[$store->getSku()] = $store;
        }
        $storesStock = $this->getStoresStock(array_keys($storeIds), $cart);
        $result = [];
        foreach ($storesStock as $storeStock) {
            $store = $storeIds[$storeStock->getStoreId()];
            $store->setWarehouseId($storeStock->getWarehouseId());
            $stock = new StoreStock($store, $storeStock->getItems());
            array_push($result, $stock);
        }
        return $result;
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
     * Obtains the list of available warranty plans for a given product
     *
     * @param string $sku Product sku
     * @param float $price Product price
     * @return WarrantyPlan[] List of available warranty plans for given product
     * @throws WakupException
     */
    public function getWarrantyPlans(string $sku, float $price) : array
    {
        $params = ['sku' => $sku, 'costo' => $price];
        $request = new MongeRequest($this->config, $this->mongeClient, Warranty::class,
            'Cotizacion/ConsultarPlanProducto', 97, $params);
        $result = $request->launch();
        return $result[0]->getProductPlans();
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
        $TYPE_ID_PRODUCT = 1;
        $TYPE_ID_WARRANTY = 3;
        $skuArray = [];
        $warrantySkuArray = [];
        $pricesArray = [];
        $warrantyPricesArray = [];
        for($i = 0; $i < count($cart->getProducts()); ++$i) {
            $product = $cart->getProducts()[$i];
            // Add product SKU
            $formattedSku = join('&', [$TYPE_ID_PRODUCT, 0, $i, $product->getSku()]);
            array_push($skuArray, $formattedSku);
            array_push($pricesArray, $product->getTotalPrice());
            if ($product->hasWarranty()) {
                // Add warranty SKUs
                $formattedWarrantySku = join('&', [$TYPE_ID_WARRANTY, 0, $i, $product->getSku()]);
                array_push($warrantySkuArray, $formattedWarrantySku);
                array_push($warrantyPricesArray, $product->getWarrantyPlanTotalPrice());
            }
        }

        $params = [
            'codCliente' => $personId,
            'lineaCredito' => $creditLineId,
            'idPromocion' => $promotionId,
            'monto' => $cart->getProductsPrice(),
            'codProductos' => join(';', $skuArray),
            'precioProductos' => join(';', $pricesArray),
            'codigoGarantia' => join(';', $warrantySkuArray),
            'precioGarantia' => join(';', $warrantyPricesArray),
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
     * @return StoreIdStock[] List of stock availability for each requested store
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
        $request = new MongeRequest($this->config, $this->mongeClient, StoreIdStock::class,
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
    public function reserveOrderStock(string $storeId, int $warehouseId, Cart $cart) : string
    {
        $items = [];
        foreach ($cart->getProducts() as $cartProduct) {
            array_push($items, [
                    'sku' => $cartProduct->getSku(),
                    'cantidad' => $cartProduct->getCount(),
                    'tienda' => $storeId,
                    'bodegaOrigen' => $warehouseId,
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
            'Inventario/ReversaReservaInventario', 93, $params);
        $request->launch();
        return true;
    }

    /**
     * Process and generates invoice for given order
     *
     * @param Order $order Container for order information
     * @return bool Returns true if process was successful
     * @throws WakupException
     */
    public function processOrder(Order $order)
    {
        $request = new ProcessOrderRequest($this->config, $this->mongeClient, $order);
        $request->launch();
        return true;
    }

}