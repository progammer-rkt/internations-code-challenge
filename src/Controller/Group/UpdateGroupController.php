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

namespace App\Controller\Group;

use App\Api\Group\Data\GroupInterface;
use App\Core\Controller\PostController;
use App\Exceptions\EntityHasNoChangeException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\EntitySaveException;
use App\Service\Group\UpdateGroupServiceProvider;
use Exception;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UpdateGroupController
 *
 * Deals with group update action
 *
 * - Validate inputs
 * - Make sure group exists
 * - Perform group update
 * - Returns a suitable json response
 */
class UpdateGroupController extends PostController
{
    /**
     * API Endpoint that handles updating a group
     *
     * @Route("/api/group/{groupId}", name="updateGroup", methods={"PUT"})
     * @param  string $groupId
     * @param  \App\Service\Group\UpdateGroupServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function execute(
        $groupId,
        UpdateGroupServiceProvider $serviceProvider
    ) {
        try {
            // load group by id
            $group = $serviceProvider->getGroupById((int)$groupId);

            // checks data has any change
            if (!$this->isGroupDataChanged($group)) {
                $noChangeException = new EntityHasNoChangeException();
                $noChangeException->setEntity(GroupInterface::ENTITY);
                throw $noChangeException;
            }

            // setting new data to the group instance
            $data = $this->requestData();
            $group->setName($data[GroupInterface::NAME]);

            // checks whether changed entity is valid
            if ($this->isValid($group)) {
                // updating group
                $serviceProvider->execute();

                // success response
                return $this->successResponse($group->toArray());
            }

            // validation error occurred; so send validation error response
            return $this->validationErrorResponse($this->errors());
        } catch (EntityNotFoundException $exception) {
            // requested group could not found; so send "not-found-error" error response
            return $this->customFailureResponse($exception->message());
        } catch (EntitySaveException $exception) {
            // Some error occurred while saving; sends an "entity-save-failure" error response
            return $this->customFailureResponse($exception->message());
        } catch (EntityHasNoChangeException $exception) {
            // There is no change to the group; sends a "no-change-in-entity" error response
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // Request failed due to unknown reason; sends server failure response
            return $this->serverFailureResponse();
        }
    }

    /**
     * Checks group data has any change
     *
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return bool
     */
    private function isGroupDataChanged(GroupInterface $group): bool
    {
        $data = $this->requestData();

        if ($data[GroupInterface::NAME] !== $group->getName()) {
            return true;
        }

        return false;
    }

    /**
     * Prepare an array based on the request body
     *
     * Request Data
     *
     * @return array
     */
    private function requestData(): array
    {
        $body = json_decode($this->request()->getContent(), true);
        $groupName = $body[GroupInterface::NAME] ?? '';
        return [
            GroupInterface::NAME => $groupName,
        ];
    }
}
