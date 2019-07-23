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

namespace App\Service\Group;

use App\Api\Group\Data\GroupInterface;
use App\Api\Group\GroupRepositoryInterface;
use App\Api\Search\CriteriaInterface;
use App\Core\ServiceProviderInterface;
use Exception;

class CollectGroupsServiceProvider implements ServiceProviderInterface
{
    /**
     * Group repository
     *
     * @var \App\Repository\GroupRepository
     */
    private $groupRepository;

    /**
     * @var \App\Api\Search\CriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var array
     */
    private $filterParams = [];

    /**
     * CollectGroupsServiceProvider constructor.
     *
     * @param \App\Api\Group\GroupRepositoryInterface $groupRepository
     * @param \App\Api\Search\CriteriaInterface       $searchCriteria
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository,
        CriteriaInterface $searchCriteria
    ) {
        $this->groupRepository = $groupRepository;
        $this->searchCriteria = $searchCriteria;

        // setting default criterias
        $this->searchCriteria
            ->setStart(0)
            ->setSortOrder([GroupInterface::ENTITY_ID => CriteriaInterface::DESCENDING])
            ->setLimit(100);
    }

    /**
     * Collect group details
     *
     * @return array
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $searchCriteria = $this->prepareSearchCriteria();
            return $this->groupRepository->getList($searchCriteria)->toArray();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set limit, start, sort order search filters if any
     *
     * @param  array $params
     * @return \App\Service\Group\CollectGroupsServiceProvider
     */
    public function setFilterParams(array $params) : self
    {
        $this->filterParams = $params;
        return $this;
    }

    /**
     * Prepare search criteria to filter out groups
     *
     * @return \App\Api\Search\CriteriaInterface
     */
    private function prepareSearchCriteria() : CriteriaInterface
    {
        $sortOrder = $this->filterParams[CriteriaInterface::SORT_ORDER];
        $limit = $this->filterParams[CriteriaInterface::LIMIT];
        $start = $this->filterParams[CriteriaInterface::START];

        if ($sortOrder) {
            $this->searchCriteria->setSortOrder($sortOrder);
        }

        if ($limit) {
            $this->searchCriteria->setLimit($limit);
        }

        if ($start) {
            $this->searchCriteria->setStart($start);
        }

        return $this->searchCriteria;
    }
}
