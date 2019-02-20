# Wakup-Monge PHP API

La siguiente librería proporciona una interfaz PHP con los servicios web de Wakup y Monge.

## Instalación

El proyecto está desplegada en _packagist_ como una librería de composer. Para incluirla al proyecto basta con añadirla como dependencia:

    composer require wakup/monge-php-api
    
## Uso básico

Para acceder al cliente, basta con crear una instancia, que se puede reutilizar para el resto de peticiones:

```php
$wakupClient = new \Wakup\Client();
```
Los métodos de la líbrería tienen tipado fuerte, lo que facilita su uso.

## Métodos Wakup

Los métodos asociados a la gestión del catálogo de Wakup son los siguientes:

### getPaginatedAttributes

Obtiene el listado de atributos de producto registrados en Wakup.

Toma los siguientes parámetros:

| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `page`    | int  | Número de página a consultar. La primera página es la 0. |
| `perPage` | int  | Cantidad de resultados a obtener por página. |

Devuelve un objeto de tipo `PaginatedAttributes`.

Ejemplo de uso:

```php
$pagination = $wakupClient->getPaginatedAttributes(0, 100);
$attributes = $pagination->getAttributes();
```

### getPaginatedCategories

Obtiene el listado de categorías de producto registrados en Wakup.

Toma los siguientes parámetros:

| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `page`    | int  | Número de página a consultar. La primera página es la 0. |
| `perPage` | int  | Cantidad de resultados a obtener por página. |

Devuelve un objeto de tipo `PaginatedCategories`.

Ejemplo de uso:

```php
$pagination = $wakupClient->getPaginatedCategories(0, 100);
$categories = $pagination->getCategories();
```

### getPaginatedProducts

Obtiene el listado de productos que han cambiado desde la última consulta.
El resultado incluirá:

* **Stock**: número de unidades en stock. Esta información se incluye siempre que el producto se añade al listado
* **Precio**: información sobre el precio del producto, incluyendo el importe con impuesto, sin impuesto y la tasa aplicada. Este dato sólo se incluye cuando el precio ha cambiado desde la última consulta.
* **Detalles**: información detallada del producto, incluyendo nombre,  imágenes, valores de atributo, etc. Sólo se incluye cuando ha cambiado algún valor desde la última consulta.

Toma los siguientes parámetros:

| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `lastUpdate` | DateTime  | Fecha de última consulta. Si se envía vacío, se devolverán todos los productos. |
| `page`    | int  | Número de página a consultar. La primera página es la 0. |
| `perPage` | int  | Cantidad de resultados a obtener por página. |

Devuelve un objeto de tipo `PaginatedProducts`.

Ejemplo de uso:

```php
$lastUpdate = new DateTime('2018-12-30 23:21:46');
$pagination = $wakupClient->getPaginatedProducts($lastUpdate, 0, 100);
$products = $pagination->getProducts();