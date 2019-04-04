<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-25
 * Time: 13:07
 */

namespace Wakup\Requests;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Wakup\Config;
use Wakup\WakupException;

abstract class JsonRequest implements Request
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \JsonMapper
     */
    private $jsonMapper;

    protected $method, $url, $queryParams, $headers, $bodyContent;

    /**
     * JsonRequest constructor.
     * @param Config $config
     * @param Client $client
     * @param string $method
     * @param string $url
     * @param array $queryParams
     * @param array $headers
     * @param string $bodyContent
     */
    public function __construct(Config $config, Client $client, string $method, string $url,
                                ?array $queryParams=[], ?array $headers=[], ?string $bodyContent="")
    {
        $this->config = $config;
        $this->client = $client;
        $this->method = $method;
        $this->url = $url;
        $this->queryParams = $queryParams;
        $this->headers = $headers;
        $this->bodyContent = $bodyContent;
    }

    /**
     * @return mixed
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getQueryParams() : array
    {
        return $this->queryParams;
    }

    /**
     * @return mixed
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBodyContent() : ?string
    {
        return $this->bodyContent;
    }

    public function getJsonMapper() : \JsonMapper
    {
        if ($this->jsonMapper == null) {
            $this->jsonMapper = new \JsonMapper();
            $this->jsonMapper->bStrictNullTypes = false;
        }
        return $this->jsonMapper;
    }

    /**
     * @throws WakupException
     */
    function launch()
    {
        try {
            $response = $this->client->request(
                $this->getMethod(),
                $this->getUrl(),
                [
                    'query' => $this->getQueryParams(),
                    'body' => $this->getBodyContent(),
                    'headers' => $this->getHeaders()
                ]);
            $obj = json_decode($response->getBody());
            return $this->onResponseProcess($obj);
        } catch (\JsonMapper_Exception $e) {
            return $this->onRequestException($e);
        } catch (GuzzleException $e) {
            return $this->onRequestException($e);
        }
    }

    /**
     * @param \Exception $e
     * @throws WakupException
     */
    function onRequestException(\Exception $e)
    {
        throw new WakupException($e);
    }

    /**
     * @param $parsedJson
     * @return mixed
     * @throws \JsonMapper_Exception
     */
    abstract function onResponseProcess($parsedJson);

}