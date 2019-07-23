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
use App\Service\User\CollectUserGroupsServiceProvider;

/**
 * CollectUserGroupsController
 *
 * API endpoint that provides groups list that is assigned to a user
 */
class CollectUserGroupsController extends BaseController
{

    /**
     * Collect groups belong to a user
     *
     * @Route("/api/user/groups/{userId}", name="getUserGroups", methods={"GET"})
     * @param  string $userId
     * @param  \App\Service\User\CollectUserGroupsServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute($userId, CollectUserGroupsServiceProvider $serviceProvider)
    {
        try {
            $ugRelations = $serviceProvider->setUserId((int)$userId)->execute((int)$userId);
            return $this->successResponse($ugRelations);
        } catch (EntityNotFoundException $exception) {
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            return $this->serverFailureResponse();
        }
    }
}
