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
use App\Api\User\Data\UserInterface;
use App\Api\User\UserRepositoryInterface;
use App\Core\ServiceProviderInterface;
use Exception;

class CollectUsersServiceProvider implements ServiceProviderInterface
{
    /**
     * User repository
     *
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * @var \App\Api\Search\CriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var array
     */
    private $filterParams = [];


    /**
     * CollectUsersServiceProvider constructor.
     *
     * @param \App\Api\User\UserRepositoryInterface $userRepository
     * @param \App\Api\Search\CriteriaInterface     $searchCriteria
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CriteriaInterface $searchCriteria
    ) {
        $this->userRepository = $userRepository;
        $this->searchCriteria = $searchCriteria;

        $this->searchCriteria
            ->setSortOrder([UserInterface::ENTITY_ID => CriteriaInterface::DESCENDING])
            ->setStart(0)
            ->setLimit(100);
    }

    /**
     * Collect user details
     *
     * @return array
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $searchCriteria = $this->prepareSearchCriteria();
            return $this->userRepository->getList($searchCriteria)->toArray();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set limit, start, sort order search filters if any
     *
     * @param  array $params
     * @return \App\Service\User\CollectUsersServiceProvider
     */
    public function setFilterParams(array $params) : self
    {
        $this->filterParams = $params;
        return $this;
    }

    /**
     * Prepare search criteria to filter out users
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
