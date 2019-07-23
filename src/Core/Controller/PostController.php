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

use App\Core\DataObject;
use App\Core\Response\ResponseModifier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PostController
 *
 * Controller class dedicated to deal with POST requests
 */
class PostController extends BaseController
{

    /**
     * Use to validate a model entity
     *
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected $validator;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(
        ValidatorInterface $validator,
        JsonResponse $jsonResponse,
        RequestStack $requestStack,
        ResponseModifier $responseModifier
    ) {
        $this->validator = $validator;
        parent::__construct($jsonResponse, $requestStack, $responseModifier);
    }

    /**
     * Checks whether a model entity data is valid or not
     *
     * @param  \App\Core\DataObject $entity
     * @return bool
     */
    public function isValid(DataObject $entity): bool
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            $this->errors = $errors;
            return false;
        }

        return true;
    }

    /**
     * Provide validation errors if any
     *
     * @return array
     */
    public function errors(): array
    {
        $output = [];

        foreach ($this->errors as $violation) {
            $output[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $output;
    }
}
