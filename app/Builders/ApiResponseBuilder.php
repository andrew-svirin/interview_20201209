<?php

namespace AndrewSvirin\Interview\Builders;

use AndrewSvirin\Interview\Factories\Http\ApiResponseFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Helpers\ArrHelper;
use AndrewSvirin\Interview\Models\Model;
use AndrewSvirin\Interview\Responses\ApiResponse;

/**
 * ApiResponse builder.
 */
class ApiResponseBuilder
{

    /**
     * ApiResponse Factory.
     *
     * @var ApiResponseFactory
     */
    private ApiResponseFactory $apiResponseFactory;

    /**
     * ApiResponse for building.
     *
     * @var ApiResponse
     */
    private ApiResponse $apiResponse;

    /**
     * Json stream factory.
     *
     * @var JsonStreamFactoryInterface
     */
    private JsonStreamFactoryInterface $jsonStreamFactory;

    public function __construct(ApiResponseFactory $apiResponseFactory, JsonStreamFactoryInterface $jsonStreamFactory)
    {
        $this->apiResponseFactory = $apiResponseFactory;
        $this->jsonStreamFactory = $jsonStreamFactory;
    }

    /**
     * Create instance of apiResponse.
     *
     * @param int $code
     * @param string $reasonPhrase
     *
     * @return $this
     */
    public function createApiResponse(int $code = 200, string $reasonPhrase = ''): ApiResponseBuilder
    {
        $this->apiResponse = $this->apiResponseFactory->createApiResponse($code, $reasonPhrase);

        return $this;
    }

    /**
     * Put message in api response.
     *
     * @param string $message
     *
     * @return $this
     */
    public function withMessage(string $message): ApiResponseBuilder
    {
        $this->withJsonValue('message', $message);

        return $this;
    }

    /**
     * Put errors in api response.
     *
     * @param array $errors
     *
     * @return $this
     */
    public function withErrors(array $errors): ApiResponseBuilder
    {
        $this->withJsonValue('errors', $errors);

        return $this;
    }

    /**
     * Put model in api response.
     *
     * @param Model $model
     *
     * @return $this
     */
    public function withModel(Model $model): ApiResponseBuilder
    {
        $this->withJsonValue('data', $model->getValues());

        return $this;
    }

    /**
     * Put models in api response.
     *
     * @param Model[] $models
     *
     * @return $this
     */
    public function withModels(array $models): ApiResponseBuilder
    {
        $data = [];
        foreach ($models as $model) {
            $data[] = $model->getValues();
        }
        $this->withJsonValue('data', $data);

        return $this;
    }

    /**
     * Put value by key in json.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    private function withJsonValue(string $key, $value): void
    {
        $json = $this->apiResponse->getJson();

        // Init new json on empty.
        if (null === $json) {
            $json = [];
        }

        $json = ArrHelper::set($json, $key, $value);

        $body = $this->jsonStreamFactory->createStreamFromJson($json);

        $this->apiResponse->withBody($body);
    }

    /**
     * Getter for ApiResponse.
     * @return ApiResponse
     */
    public function getApiResponse(): ApiResponse
    {
        return $this->apiResponse;
    }
}
