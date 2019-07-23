<?php
/**
 * Code Challenge - InterNations
 *
 * This file is a part of the code challenge that is given by
 * the InterNations Team.
 *
 * @version   1.0.0
 * @author    Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 * @copyright Copyright © Rajeev K Tomy
 */
declare(strict_types=1);

namespace App\Core\Controller;

use App\Core\Response\ResponseModifier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class BaseController
 * Abstract layer that provides some useful methods for it's children
 */
abstract class BaseController
{

    /**
     * @var \Symfony\Component\HttpFoundation\JsonResponse
     */
    private $jsonResponse;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var \App\Core\Response\ResponseModifier
     */
    private $responseModifier;

    /**
     * BaseController constructor.
     *
     * @param \Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \App\Core\Response\ResponseModifier            $responseModifier
     */
    public function __construct(
        JsonResponse $jsonResponse,
        RequestStack $requestStack,
        ResponseModifier $responseModifier
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->requestStack = $requestStack;
        $this->responseModifier = $responseModifier;
    }

    /**
     * Provide current request instance
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function request(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Provide JSON Response instance
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonResponse(): JsonResponse
    {
        return $this->jsonResponse;
    }

    /**
     * Response modifier
     *
     * @return \App\Core\Response\ResponseModifier
     */
    public function modifier(): ResponseModifier
    {
        return $this->responseModifier;
    }

    /**
     * Success JSON response
     *
     * @param  mixed $data
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function successResponse($data = []) : JsonResponse
    {
        return $this->jsonResponse->setData($this->modifier()->wrapSuccess($data));
    }

    /**
     * Validation Error Response
     *
     * @param  array $message
     * @return \Symfony\Component\HttpFoundation\JsonResponse|null
     */
    public function validationErrorResponse(array $message = []) : ?JsonResponse
    {
        return $this->jsonResponse()->setStatusCode(422)
            ->setData($this->modifier()->wrapValidationFailed($message));
    }

    /**
     * Failure response that should be used when an App Exception is thrown
     *
     * @param  string $message
     * @param  int    $statusCode
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function customFailureResponse(string $message = '', int $statusCode = 500) : JsonResponse
    {
        return $this->jsonResponse->setStatusCode($statusCode)
            ->setData($this->modifier()->wrapUnknownFailure($message));
    }

    /**
     * Internal Server Failure response
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function serverFailureResponse() : JsonResponse
    {
        return $this->jsonResponse->setStatusCode(500)
            ->setData($this->modifier()->wrapUnknownFailure());
    }
}
