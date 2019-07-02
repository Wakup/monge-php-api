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
     * @param string $password User password in plain text
     * @return bool Returns true if login is successful
     * @throws WakupException
     */
    public function login(string $email, string $password) : bool
    {
        $request = new LoginRequest($this->config, $this->defaultClient, $email, $password);
        return $request->launch();
    }

    /**
     * Registers a new user with the given email and password
     *
     * @param string $email User login email
     * @param string $password User password in plain text
     * @return AzureUser information of the created user
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
     * Resets the user password
     *
     * @param string $email User login email
     * @param string $newPassword New user password in plain text
     * @return bool true if password has been successfully changed, or false if user can not be found
     * @throws WakupException
     */
    public function resetPassword(string $email, string $newPassword) : bool
    {
        $user = $this->findUser($email);
        if ($user == null) return false;
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
     * Changes the sign in email of the given user
     *
     * @param string $email User current login email
     * @param string $newEmail User new email address
     * @return bool true if email has been successfully changed, or false if user can not be found
     * @throws WakupException
     */
    public function changeEmail(string $email, string $newEmail) : bool
    {
        $user = $this->findUser($email);
        if ($user == null) return false;
        $jsonBody = [
            "signInNames" => [
                [
                    "type" => "emailAddress",
                    "value" => $newEmail
                ]
            ]
        ];
        $request = new UsersRequest($this->config, $this->azureClient, 'PATCH', [], [], $jsonBody,
            null, $user->getObjectId());
        $request->launch();
        return true;
    }

    /**
     * Deletes the user with given email
     *
     * @param $email string User login email
     * @return bool true if user has been successfully deleted, or false if user can not be found
     * @throws WakupException
     */
    public function deleteUser(string $email) : bool
    {
        $user = $this->findUser($email);
        if ($user == null) return false;
        $request = new UsersRequest($this->config, $this->azureClient, 'DELETE', [], [], null,
            null, $user->getObjectId());
        $request->launch();
        return true;
    }

    /**
     * Checks if an user with the given email is already registered
     *
     * @param string $email User login email
     * @return bool true if an user with the given email is already registered
     * @throws WakupException
     */
    public function isUserRegistered(string $email) : bool
    {
        return $this->findUser($email) != null;
    }

    /**
     * Obtains the information of the user with given email
     *
     * @param string $email User login email
     * @return AzureUser|null information of the created user. Null if the user does not exist
     * @throws WakupException
     */
    public function findUser(string $email) : ?AzureUser
    {
        $params = ['$filter' => "signInNames/any(x:x/value eq '{$email}')"];
        $request = new UsersRequest($this->config, $this->azureClient, 'GET', [], $params, null,
            AzureUser::class);
        $users = $request->launch();
        return empty($users) ? null : $users[0];
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
     * @throws WakupException
     */
    public function getNearestStores(float $latitude, float $longitude, $page = 0, $perPage = 25) : PaginatedStores
    {
        $params = [
            'companyId' => $this->config->wakupCompanyId,
            'latitude' => $latitude,
            'longitude' => $longitude
        ];
        $request = new WakupRequest($this->config, $this->defaultClient, new PaginatedStores(),
            'catalog/stores', $params, $page, $perPage);
        return $request->launch();
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
        # Sort by distance
        usort($result, function(StoreStock $a, StoreStock $b)
        {
            return $a->getStore()->getDistanceInMiles() > $b->getStore()->getDistanceInMiles();
        });
        return $result;
    }

    // MONGE Requests
    // ---------------//

    /**
     * Obtains the credit info of the user on Monge system, including available credit amount, fee and internal
     * identifiers for later use on other requests.
     *
     * @param string $userIdentifier User VAT identifier
     * @return UserCreditInfo|null Credit information for given user. Null if user is not registered on credit system.
     * @throws WakupException
     */
    public function getUserCreditInfo(string $userIdentifier) : ?UserCreditInfo
    {
        $params = [
            'TipoIdentificacion' => 51,
            'Identificacion' => $userIdentifier,
            'primerNombre' => '',
            'segundoNombre' => '',
            'primerApellido' => '',
            'segundoApellido' => '',
            'FechaNacimiento' => null,
            'CorreoElectronico' => '',
            'LlaveSistema' => 'TVCRI',
            'TipoEjecucion' => 'AUTO'
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, new SystemActionCreditInfo(),
            'Cliente/ValidaCliente', 96, $params);
        // Return only first value
        $response = $request->launch();
        $creditInfo = $response->getCreditInfo();
        return $creditInfo != null && $creditInfo->getPersonId() > 0 ? $response->getCreditInfo() : null;
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
     * @param UserCreditInfo $creditInfo Information of the logged user on the Monge credit system
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return FinancialPromotion[] List of financial promotions that applies to given user and cart
     * @throws WakupException
     */
    public function getFinancialPromotions(UserCreditInfo $creditInfo, Cart $cart) : array
    {
        $skuArray = [];
        foreach ($cart->getProducts() as $product) {
            array_push($skuArray, $product->getSku());
        }
        $params = [
            'codigocanalVenta' => $this->config->mongeChannelCode,
            'codigoTienda' => $this->config->mongeShopCode,
            'codigoArticulos' => join(',', $skuArray),
            'idPersona' => $creditInfo->getPersonId()
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, FinancialPromotion::class,
            'Cotizacion/ListarPromocion', 98, $params);
        return $request->launch();
    }

    public function generaDocumentos(string $requestNumber)
    {
        $params = [
            'NumeroSolicitud' => $requestNumber,
            'LlaveSistema' => 'TVCRI'
        ];
        $request = new MongeRequest($this->config, $this->mongeClient, null,
            'Solicitud/GeneraDocumentos', 99, $params);
        return $request->launch();
    }

    /**
     * Obtains the financial scenarios for a given promotion and cart
     *
     * @param UserCreditInfo $creditInfo Information of the logged user on the Monge credit system
     * @param int $promotionId Selected promotion ID
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return FinancialScenario[] List of financial scenarios available for given cart and promotion
     * @throws WakupException
     */
    public function getFinancialScenarios(
        UserCreditInfo $creditInfo, int $promotionId, Cart $cart) : array
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
            'codCliente' => $creditInfo->getPersonId(),
            'lineaCredito' => $creditInfo->getCreditLineId(),
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
            if (!$cartProduct->isVirtual()) {
                array_push($items, ['sku' => $cartProduct->getSku(), 'cantidad' => $cartProduct->getCount()]);
            }
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

    const ORDER_TYPE_CENTRAL = 'central';
    const ORDER_TYPE_STORE = 'store';

    /**
     * Makes the reservation of the products in the cart before the payment process of the order.
     * There are two types of reservation for the different shopping options: from central stock or from store stock.
     *
     * @param string $orderType Value from ORDER_TYPE_ constants to define the stock origin for order
     * @param Store $store Store in which the reservation is done. For central reservations, it defines the collection store
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return string Reservation identifier. Required to later cancel it.
     * @throws WakupException
     */
    public function reserveOrderStock(string $orderType, Store $store, Cart $cart) : string
    {
        $items = [];
        foreach ($cart->getProducts() as $cartProduct) {
            switch ($orderType) {
                case self::ORDER_TYPE_STORE:
                    if (!$cartProduct->isVirtual()) {
                        array_push($items, [
                                'sku' => $cartProduct->getSku(),
                                'cantidad' => $cartProduct->getCount(),
                                'tienda' => $store->getSku(),
                                'bodegaOrigen' => $store->getWarehouseId(),
                                'pais' => $this->config->mongeCountryCode]
                        );
                    }
                    break;
                case self::ORDER_TYPE_CENTRAL:
                    if (!$cartProduct->isVirtual()) {
                        array_push($items, [
                                'sku' => $cartProduct->getSku(),
                                'tienda' => $store->getSku(),
                                'bodega' => $this->config->mongeWarehouseCode,
                                'cantidad' => $cartProduct->getCount(),
                                'unidadMedida' => 'UN',
                                'motivoPedido' => '',
                            ]
                        );
                    }
                    break;
                default:
                    throw new WakupException(new \Exception('Unsupported order type'));
            }
        }
        switch ($orderType) {
            case self::ORDER_TYPE_STORE:
                $request = new MongeRequest($this->config, $this->mongeClient, '',
                    'Inventario/ReservaInventario', 93, $items, false);
                return $request->launch();
                break;
            case self::ORDER_TYPE_CENTRAL:
                $params = [
                    'usuarioCreacion' => 'TiendaVirtual',
                    'fechaCreacion' => date(\DateTime::ATOM),
                    'detalle' => $items
                ];
                $request = new MongeRequest($this->config, $this->mongeClient, '',
                    'Inventario/PedidosPorTraslado', 93, $params);
                $response = $request->launch();
                return $response->numeroDocumentoCompras;
                break;
            default:
                throw new WakupException(new \Exception('Unsupported order type'));
        }
    }

    /**
     * Cancels a previously made store stock reservation
     *
     * @param string $orderType Value from ORDER_TYPE_ constants to define the stock origin for order
     * @param string $reservationId Id of the reservation obtained on reserveOrderStock method
     * @return bool Returns true if request is successful
     * @throws WakupException
     */
    public function cancelOrderStockReservation(string $orderType, string $reservationId) : bool
    {
        switch ($orderType) {
            case self::ORDER_TYPE_STORE:
                $params = ['idReserva' => $reservationId, 'codigoUsuario' => 'TiendaVirtual'];
                $request = new MongeRequest($this->config, $this->mongeClient, null,
                    'Inventario/ReversaReservaInventario', 93, $params);
                $request->launch();
                return true;
                break;
            case self::ORDER_TYPE_CENTRAL:
                $params = ['numeroDocumento' => $reservationId];
                $request = new MongeRequest($this->config, $this->mongeClient, null,
                    'Inventario/AnulacionDePedidoTraslado', 93, $params);
                $request->launch();
                return true;
                break;
            default:
                throw new WakupException(new \Exception('Unsupported order type'));
        }
    }

    /**
     * Confirms the stock reservation as previous step to process order
     * @param string $orderType Value from ORDER_TYPE_ constants to define the stock origin for order
     * @param string $reservationId Id of the reservation obtained on reserveOrderStock method
     * @param Cart $cart Wrapper object for products added to the cart by the logged user
     * @return bool Returns true if request is successful
     * @throws WakupException
     */
    public function confirmOrderStockReservation(string $orderType, string $reservationId, Cart $cart) : bool
    {
        switch ($orderType) {
            case self::ORDER_TYPE_STORE:
                return true;
                break;
            case self::ORDER_TYPE_CENTRAL:
                $productCount = 0;
                foreach ($cart->getProducts() as $cartProduct) {
                    if (!$cartProduct->isVirtual()) {
                        $productCount += $cartProduct->getCount();
                    }
                }
                $items = [[
                    'documentoReferencia' => $reservationId,
                    'cantidad' => $productCount,
                    'referencia' => 1,
                    'unidadMedida' => 'UN'
                ]];
                $params = [
                    'fechaCreacion' => date(\DateTime::ATOM),
                    'detalle' => $items
                ];
                $request = new MongeRequest($this->config, $this->mongeClient, null,
                    'Inventario/CreacionDeEntregaDeSalida', 93, $params);
                $request->launch();
                return true;
                break;

            default:
                throw new WakupException(new \Exception('Unsupported order type'));
        }
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