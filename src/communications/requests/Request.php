<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-22
 * Time: 16:18
 */

namespace Wakup\Requests;

interface Request
{
    function getMethod() : string;
    function getUrl() : string;
    function getQueryParams() : array;
    function getHeaders(): array;
    function getBodyContent() : string;
    function launch();
}