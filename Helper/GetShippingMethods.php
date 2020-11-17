<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Funami\EmotionShippingMethods\Helper;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Laminas\View\Helper\AbstractHelper;

class GetShippingMethods extends AbstractHelper
{
    const PRODUCT_IMAGES_JSON_API = "https://my-json-server.typicode.com/";
    const API_REQUEST_ENDPOINT = 'harakiri-cat/emotion_api/';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }
    /**
     * Fetch some data from API
     */
    public function execute() {
        $apiName = 'shipping_methods';
        $response = $this->doRequest(static::API_REQUEST_ENDPOINT . $apiName);
        $status = $response->getStatusCode(); // 200 status code
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        return json_decode ($responseContent);

    }


    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::PRODUCT_IMAGES_JSON_API
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
