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

use App\Exceptions\EntitySaveException;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Group\CreateGroupServiceProvider;
use App\Api\Group\Data\GroupInterface;
use App\Core\Controller\PostController;

/**
 * Controller that deals with creating a Group
 *
 * It's job involves:
 * - Validating the inputs
 * - Perform saving by means of a service provider
 * - Finally provide the response
 */
class CreateGroupController extends PostController
{

    /**
     * API Endpoint that handles create group action
     *
     * @Route("/api/group", name="createGroup", methods={"POST"})
     * @param  \App\Api\Group\Data\GroupInterface            $group
     * @param  \App\Service\Group\CreateGroupServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute(
        GroupInterface $group,
        CreateGroupServiceProvider $serviceProvider
    ) {
        // collect request data
        $groupName = $this->request()->get(GroupInterface::NAME, '');

        try {
            // attach data to the group instance
            $group->setName($groupName);

            // checks whether group instance is valid
            if ($this->isValid($group)) {
                // perform create group operation
                $serviceProvider->setGroup($group)->execute();

                // everything went smooth; success response
                return $this->successResponse($group->toArray());
            }

            // ohoo... validation failed; error response with validation errors
            return $this->validationErrorResponse($this->errors());
        } catch (EntitySaveException $exception) {
            // something went wrong while saving group; error response with save failure message
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
