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

namespace App\Repository;

use App\Api\Group\Data\SearchResultInterface;
use App\Exceptions\EntityDeletionFailed;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\EntitySaveException;
use Exception;
use App\Api\Search\CriteriaInterface;
use App\Api\Group\Data\GroupInterface;
use App\Api\Group\GroupRepositoryInterface;
use App\Entity\Group\ResourceModel\Group;

/**
 * GroupRepository
 *
 * Stable API methods to perform CRUD operation on Group entity
 */
class GroupRepository implements GroupRepositoryInterface
{

    /**
     * @var \App\Entity\Group\ResourceModel\Group
     */
    private $groupResourceModel;

    /**
     * @var \App\Api\Group\Data\SearchResultInterface
     */
    private $groupCollectionResult;

    /**
     * GroupRepository constructor.
     *
     * @param \App\Entity\Group\ResourceModel\Group     $groupResourceModel
     * @param \App\Api\Group\Data\SearchResultInterface $groupCollectionResult
     */
    public function __construct(
        Group $groupResourceModel,
        SearchResultInterface $groupCollectionResult
    ) {
        $this->groupResourceModel = $groupResourceModel;
        $this->groupCollectionResult = $groupCollectionResult;
    }

    /**
     * Get group by id
     *
     * @param  int $groupId
     * @return \App\Api\Group\Data\GroupInterface|null
     * @throws \App\Exceptions\EntityNotFoundException
     */
    public function getById(int $groupId): ?GroupInterface
    {
        try {
            $group = $this->groupResourceModel->find($groupId);
            if (!$group) {
                $groupNotFoundException = new EntityNotFoundException();
                $groupNotFoundException->setMessage(
                    'Request group does not exists'
                );
                throw $groupNotFoundException;
            }
            return $group;
        } catch (Exception $e) {
            $groupNotFoundException = new EntityNotFoundException();
            $groupNotFoundException->setMessage(
                'Could not find the group with id: ' . $groupId . '. Please try later'
            );
            throw $groupNotFoundException;
        }
    }

    /**
     * Delete group by IDint $groupId
     *
     * @return bool|null
     * @throws \App\Exceptions\EntityDeletionFailed
     * @throws \App\Exceptions\EntityNotFoundException
     */
    public function deleteById($groupId): ?bool
    {
        try {
            $this->groupResourceModel->deleteById($groupId);
            return true;
        } catch (EntityNotFoundException $exception) {
            throw $exception;
        } catch (Exception $e) {
            $groupDeleteFailureException = new EntityDeletionFailed();
            $groupDeleteFailureException->setMessage(
                'Could not delete the group with id: ' . $groupId . '. Please try later'
            );
            throw $groupDeleteFailureException;
        }
        return false;
    }

    /**
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return bool|null
     * @throws \App\Exceptions\EntityDeletionFailed
     */
    public function delete(GroupInterface $group): ?bool
    {
        try {
            $this->groupResourceModel->delete($group);
            return true;
        } catch (Exception $e) {
            throw new EntityDeletionFailed(
                'Could not delete the group with id: ' . $group->getId() . '. Please try later'
            );
        }
        return false;
    }

    /**
     * Create/Update a group
     *
     * @param  \App\Api\Group\Data\GroupInterface $group
     * @return \App\Api\Group\Data\GroupInterface|\App\Entity\Group
     * @throws \App\Exceptions\EntitySaveException
     */
    public function save(GroupInterface $group): ?GroupInterface
    {
        try {
            if ($group->getId()) {
                return $this->groupResourceModel->update($group);
            } else {
                // create new group
                return $this->groupResourceModel->create($group);
            }
        } catch (Exception $exception) {
            $entitySaveException = new EntitySaveException();
            $entitySaveException->setEntity(GroupInterface::ENTITY);
            throw $entitySaveException;
        }
    }

    /**
     * Collect groups list
     *
     * @param  \App\Api\Search\CriteriaInterface $searchCriteria
     * @return \App\Api\Group\Data\SearchResultInterface
     * @throws \Exception
     */
    public function getList(CriteriaInterface $searchCriteria)
    {
        try {
            $groups = (array)$this->groupResourceModel->findBy(
                $searchCriteria->getFilters(),
                $searchCriteria->getSortOrder(),
                $searchCriteria->getLimit(),
                $searchCriteria->getStart()
            );

            return $this->groupCollectionResult->setItems($groups);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
