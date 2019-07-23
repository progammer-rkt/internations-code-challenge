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

use App\Service\User\GetUserServiceProvider;

/**
 * GetUserController
 *
 * API endpoint that collect user details based on ID
 *
 * @package App\Controller\User
 */
class GetUserController extends BaseController
{

    /**
     * Get user details
     *
     * @Route("/api/user/{userId}", name="getUserDetails", methods={"GET"})
     * @param  int $userId
     * @param  \App\Service\User\GetUserServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute($userId, GetUserServiceProvider $serviceProvider)
    {
        try {
            // collect user based on id
            $user = $serviceProvider->setUserId((int)$userId)->execute();

            // everything went smooth; success response
            return $this->successResponse($user->toArray());
        } catch (EntityNotFoundException $exception) {
            // requested user could not found; so send "not-found" error response
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
