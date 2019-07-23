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

use App\Exceptions\EntityNotFoundException;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Controller\BaseController;
use App\Exceptions\EntityDeletionFailed;
use App\Service\User\DeleteUserServiceProvider;

/**
 * DeleteUserController
 *
 * API endpoint to remove a user
 */
class DeleteUserController extends BaseController
{

    /**
     * Remove an User
     *
     * @Route("/api/user/{userId}", name="deleteUserDetails", methods={"DELETE"})
     * @param  int $userId
     * @param  \App\Service\User\DeleteUserServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function execute($userId, DeleteUserServiceProvider $serviceProvider)
    {
        try {
            // trying to remove the user instance
            $serviceProvider->setUserId((int)$userId)->execute();

            // success response
            return $this->successResponse();
        } catch (EntityDeletionFailed $exception) {
            // could not delete the entity; error response with valid message
            return $this->customFailureResponse($exception->message());
        } catch (EntityNotFoundException $exception) {
            // could not find the entity requested; error response with valid message
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
