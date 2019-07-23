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

namespace App\Core\Response;

class ResponseModifier
{
    // https://stackoverflow.com/questions/1959947/whats-an-appropriate-http-status-code-to-return-by-a-rest-api-service-for-a-val/1960453
    const SUCCESS = 'success';
    const FAILED = 'failed';
    const STATUS_CODE_200 = 200;
    const STATUS_CODE_422 = 422;
    const STATUS_CODE_401 = 401;
    const STATUS_CODE_500 = 500;

    /**
     * Wrap the actual response data with success related response data
     *
     * @param  array       $data
     * @param  string|null $message
     * @return array
     */
    public function wrapSuccess(array $data = [], $message = null): array
    {
        return [
            'status'     => self::SUCCESS,
            'statusCode' => self::STATUS_CODE_200,
            'message'    => $message ?? 'Success',
            'data'       => $data,
            'error'      => [],
        ];
    }

    /**
     * Wrap the actual response data with validation-failure related response data
     *
     * @param  array       $data
     * @param  string|null $message
     * @return array
     */
    public function wrapValidationFailed(array $data, $message = null): array
    {
        return [
            'status'     => self::FAILED,
            'statusCode' => self::STATUS_CODE_422,
            'message'    => $message ?? 'Validation Failed',
            'data'       => [],
            'error'      => $data,
        ];
    }

    /**
     * Response for an internal server error.  ie, failure due to unknown reasons
     *
     * @param  null $message
     * @return array
     */
    public function wrapUnknownFailure($message = null): array
    {
        return [
            'status'     => self::FAILED,
            'statusCode' => self::STATUS_CODE_500,
            'message'    => $message ?? 'Internal Server Error',
            'data'       => [],
            'error'      => ['Server failed to process the request'],
        ];
    }
}
