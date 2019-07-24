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

use App\Api\Search\CriteriaInterface;
use App\Api\User\Data\UserGroupRelationInterface;
use App\Exceptions\EntitySaveException;
use Exception;
use App\Api\User\UGRelationRepositoryInterface;
use App\Entity\User\ResourceModel\UserGroupRelation;
use App\Exceptions\EntityNotFoundException;

/**
 * User Group Relation Repository
 */
class UGRelationRepository implements UGRelationRepositoryInterface
{

    /**
     * @var \App\Entity\User\ResourceModel\UserGroupRelation
     */
    private $ugRelationResourceModel;

    /**
     * UGRelationRepository constructor.
     *
     * @param \App\Entity\User\ResourceModel\UserGroupRelation $ugRelationResourceModel
     */
    public function __construct(UserGroupRelation $ugRelationResourceModel)
    {
        $this->ugRelationResourceModel = $ugRelationResourceModel;
    }

    /**
     * Get a user group relation entry by its ID
     *
     * @param  int $id
     * @return \App\Api\User\Data\UserGroupRelationInterface|null
     * @throws \Exception
     */
    public function getById(int $id) : ?UserGroupRelationInterface
    {
        try {
            $ugRelation = $this->ugRelationResourceModel->find($id);

            if (!$ugRelation) {
                $ugRelationNotFoundException = new EntityNotFoundException();
                $ugRelationNotFoundException->setMessage(
                    'Requested group relation does not exist'
                );
            }

            return $ugRelation;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Get user group relations based on the search criteria
     *
     * @param  \App\Api\Search\CriteriaInterface $criteria
     * @return array
     * @throws \Exception
     */
    public function getBy(CriteriaInterface $criteria) : ?array
    {
        try {
            $ugRelations = $this->ugRelationResourceModel->findBy(
                $criteria->getFilters(),
                $criteria->getSortOrder(),
                $criteria->getLimit(),
                $criteria->getStart()
            );
            return $ugRelations;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Add a user-group relation
     *
     * @param  \App\Api\User\Data\UserGroupRelationInterface $userManagement
     * @return bool|null
     */
    public function create(UserGroupRelationInterface $userManagement): ?bool
    {
        try {
            $this->ugRelationResourceModel->assign($userManagement);
            return true;
        } catch (Exception $exception) {
            $relationSaveFailureException = new EntitySaveException();
            $relationSaveFailureException->setMessage(
                'User assignment to group is failed'
            );
        }
        return false;
    }

    /**
     * Remove a user-group relation
     *
     * @param  \App\Api\User\Data\UserGroupRelationInterface $userManagement
     * @return bool|null
     */
    public function delete(UserGroupRelationInterface $userManagement): ?bool
    {
        try {
            $this->ugRelationResourceModel->unAssign($userManagement);
            return true;
        } catch (Exception $exception) {
            $relationSaveFailureException = new EntitySaveException();
            $relationSaveFailureException->setMessage(
                'User un-assignment to group is failed'
            );
        }
        return false;
    }
}
