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

use App\Api\Search\CriteriaInterface;
use App\Api\User\Data\UserInterface;
use App\Core\Controller\BaseController;
use App\Service\User\CollectUsersServiceProvider;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * CollectUsersController
 *
 * API endpoint to get the list of users based on the search criteria
 */
class CollectUsersController extends BaseController
{

    /**
     * Collect user list
     *
     * @Route("/api/users", name="getUserList", methods={"GET"})
     * @param  \App\Service\User\CollectUsersServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute(CollectUsersServiceProvider $serviceProvider)
    {
        // filtering options which may present in the request
        $limit = (int)$this->request()->query->get(CriteriaInterface::LIMIT, false);
        $start = (int)$this->request()->query->get(CriteriaInterface::START, false);
        $sortOrder = $this->request()->query->get(CriteriaInterface::SORT_ORDER, false);

        // set filters based on it's presence
        $filterParam = [
            CriteriaInterface::LIMIT => $limit,
            CriteriaInterface::START => $start,
        ];

        if ($sortOrder) {
            $filterParam[CriteriaInterface::SORT_ORDER] = [UserInterface::ENTITY_ID => $sortOrder];
        }

        try {
            // service to collect users
            $users = $serviceProvider->setFilterParams($filterParam)->execute();

            // everything went smooth; success response
            return $this->successResponse($users);
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
