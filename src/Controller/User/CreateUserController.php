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

namespace App\Controller\User;

use App\Exceptions\EntitySaveException;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\User\CreateUserServiceProvider;
use App\Api\User\Data\UserInterface;
use App\Core\Controller\PostController;

/**
 * Controller that deals with creating a User
 *
 * It's job involves:
 * - Validating the inputs
 * - Perform saving by means of a service provider
 * - Finally provide the response
 */
class CreateUserController extends PostController
{

    /**
     * API Endpoint that handles create user action
     *
     * @Route("/api/user", name="createUser", methods={"POST"})
     * @param  \App\Api\User\Data\UserInterface $user
     * @param  \App\Service\User\CreateUserServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute(
        UserInterface $user,
        CreateUserServiceProvider $serviceProvider
    ) {
        // collect request data
        $fullName = $this->request()->get(UserInterface::FULLNAME, '');
        $country = $this->request()->get(UserInterface::COUNTRY, '');

        try {
            // attach data to the user instance
            $user->setFullname($fullName)->setCountry($country);

            // checks whether user instance is valid
            if ($this->isValid($user)) {
                // perform create user operation
                $serviceProvider->setUser($user)->execute();

                // everything went smooth; success response
                return $this->successResponse($user->toArray());
            }

            // ohoo... validation failed; error response with validation errors
            return $this->validationErrorResponse($this->errors());
        } catch (EntitySaveException $exception) {
            // something went wrong while saving user; error response with save failure message
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
