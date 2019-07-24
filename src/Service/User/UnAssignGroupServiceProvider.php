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

namespace App\Service\User;

use App\Api\Search\CriteriaInterface;
use App\Api\User\UGRelationRepositoryInterface;
use Exception;
use App\Api\User\Data\UserGroupRelationInterface;
use App\Core\ServiceProviderInterface;

/**
 * UnAssignGroupServiceProvider
 *
 * Service provider that will remove a user-group relation
 */
class UnAssignGroupServiceProvider implements ServiceProviderInterface
{

    /**
     * @var int
     */
    private $groupId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var \App\Api\User\UGRelationRepositoryInterface
     */
    private $ugRelationRepository;

    /**
     * @var \App\Api\Search\CriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var array
     */
    private $filterParams = [];

    /**
     * UnAssignGroupServiceProvider constructor.
     *
     * @param \App\Api\User\UGRelationRepositoryInterface $ugRelationRepository
     * @param \App\Api\Search\CriteriaInterface           $searchCriteria
     */
    public function __construct(
        UGRelationRepositoryInterface $ugRelationRepository,
        CriteriaInterface $searchCriteria
    ) {
        $this->ugRelationRepository = $ugRelationRepository;
        $this->searchCriteria = $searchCriteria;

        $this->searchCriteria
            ->setStart(0)
            ->setLimit(100)
            ->setSortOrder([
                UserGroupRelationInterface::ENTITY_ID => CriteriaInterface::DESCENDING
            ]);
    }

    /**
     * Unassign group against user
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        try {
            // collect relations specific to the user and group
            $searchCriteria = $this->prepareSearchCriteria();
            $ugRelations = $this->ugRelationRepository->getBy($searchCriteria);

            // Loop through relations and remove one by one
            // Though we perform deletion in a loop, this will be executed only once
            // as there can be only one-to-one relation exists against user and group
            foreach ($ugRelations as $ugRelation) {
                $this->ugRelationRepository->delete($ugRelation);
            }
            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param  int $groupId
     * @return \App\Service\User\UnAssignGroupServiceProvider
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @param  int $userId
     * @return \App\Service\User\UnAssignGroupServiceProvider
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }


    /**
     * Set limit, start, sort order search filters if any
     *
     * @param  array $params
     * @return \App\Service\User\UnAssignGroupServiceProvider
     */
    public function setFilterParams(array $params) : self
    {
        $this->filterParams = $params;
        return $this;
    }

    /**
     * Prepare search criteria to filter out user group relations
     *
     * @return \App\Api\Search\CriteriaInterface
     */
    private function prepareSearchCriteria() : CriteriaInterface
    {
        $filters = [];
        $sortOrder = $this->filterParams[CriteriaInterface::SORT_ORDER] ?? false;
        $limit = $this->filterParams[CriteriaInterface::LIMIT] ?? false;
        $start = $this->filterParams[CriteriaInterface::START] ?? false;

        if ($this->groupId) {
            $filters[UserGroupRelationInterface::GROUP_ID] = $this->groupId;
        }

        if ($this->userId) {
            $filters[UserGroupRelationInterface::USER_ID] = $this->userId;
        }

        if ($sortOrder) {
            $this->searchCriteria->setSortOrder($sortOrder);
        }

        if ($limit) {
            $this->searchCriteria->setLimit((int)$limit);
        }

        if ($start) {
            $this->searchCriteria->setStart((int)$start);
        }

        $this->searchCriteria->setFilters($filters);

        return $this->searchCriteria;
    }
}
