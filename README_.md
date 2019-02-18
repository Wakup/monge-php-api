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

### Consulta de atributos

Para obtener el listado de atributos, se utiliza el método `getPaginatedAttributes`, que devuelve un objeto del tipo `PaginatedAttributes`, que contiene además la información de paginación:

```php
$pagination = $wakupClient->getPaginatedAttributes(0, 100);
$attributes = $pagination->getAttributes();
```