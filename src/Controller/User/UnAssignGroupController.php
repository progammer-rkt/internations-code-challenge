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

use App\Exceptions\EntityDeletionFailed;
use App\Service\User\UnAssignGroupServiceProvider;
use Exception;
use App\Api\User\Data\UserGroupRelationInterface;
use App\Core\Controller\BaseController;
use App\Exceptions\EntityNotFoundException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UnAssignGroupController
 *
 * API endpoint that will un-assign a group from a user
 */
class UnAssignGroupController extends BaseController
{
    /**
     * Unassigns a group from a user.
     *
     * @Route("/api/group/unassign", name="unAssignGroupToUser", methods={"POST"})
     * @param  \App\Service\User\UnAssignGroupServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse|null
     */
    public function execute(UnAssignGroupServiceProvider $serviceProvider)
    {
        $groupId = (int)$this->request()->get(UserGroupRelationInterface::GROUP_ID, false);
        $userId = (int)$this->request()->get(UserGroupRelationInterface::USER_ID, false);

        if (!$groupId) {
            return $this->validationErrorResponse([
                UserGroupRelationInterface::GROUP_ID => 'Group ID is not present in the request'
            ]);
        }

        if (!$userId) {
            return $this->validationErrorResponse([
                UserGroupRelationInterface::USER_ID => 'User ID is not present in the request'
            ]);
        }

        try {
            $serviceProvider->setGroupId($groupId)->setUserId($userId);
            $serviceProvider->execute();
            return $this->successResponse();
        } catch (EntityDeletionFailed $exception) {
            return $this->customFailureResponse($exception->message());
        } catch (EntityNotFoundException $exception) {
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            return $this->serverFailureResponse();
        }
    }
}
