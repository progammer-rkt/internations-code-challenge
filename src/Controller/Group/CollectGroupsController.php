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
use App\Api\Search\CriteriaInterface;
use App\Core\Controller\BaseController;
use App\Service\Group\CollectGroupsServiceProvider;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * CollectGroupsController
 *
 * API endpoint to get the list of groups based on the search criteria
 */
class CollectGroupsController extends BaseController
{

    /**
     * Collect group list
     *
     * @Route("/api/groups", name="getGroupList", methods={"GET"})
     * @param  \App\Service\Group\CollectGroupsServiceProvider $serviceProvider
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function execute(CollectGroupsServiceProvider $serviceProvider)
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
            $filterParam[CriteriaInterface::SORT_ORDER] = [GroupInterface::ENTITY_ID => $sortOrder];
        }

        try {
            // service to collect groups
            $groups = $serviceProvider->setFilterParams($filterParam)->execute();

            // everything went smooth; success response
            return $this->successResponse($groups);
        } catch (Exception $exception) {
            // something unknown happened. error response with internal failure message
            return $this->serverFailureResponse();
        }
    }
}
