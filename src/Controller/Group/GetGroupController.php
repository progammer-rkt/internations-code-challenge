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

use App\Exceptions\EntityNotFoundException;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Controller\BaseController;

use App\Service\Group\GetGroupServiceProvider;

/**
 * GetGroupController
 *
 * API endpoint that collect group details based on ID
 *
 * @package App\Controller\Group
 */
class GetGroupController extends BaseController
{

    /**
     * Get group details
     *
     * @Route("/api/group/{groupId}", name="getGroupDetails", methods={"GET"})
     * @param  int $groupId
     * @param  \App\Service\Group\GetGroupServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute($groupId, GetGroupServiceProvider $serviceProvider)
    {
        try {
            // collect group based on id
            $group = $serviceProvider->setGroupId((int)$groupId)->execute();

            // everything went smooth; success response
            return $this->successResponse($group->toArray());
        } catch (EntityNotFoundException $exception) {
            // requested group could not found; so send "not-found" error response
            return $this->customFailureResponse($exception->message());
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
