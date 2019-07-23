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

use App\Api\User\Data\SearchResultInterface;
use App\Exceptions\EntityDeletionFailed;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\EntitySaveException;
use Exception;
use App\Api\Search\CriteriaInterface;
use App\Api\User\Data\UserInterface;
use App\Api\User\UserRepositoryInterface;
use App\Entity\User\ResourceModel\User;

/**
 * UserRepository
 *
 * Stable API methods to perform CRUD operation on User entity
 */
class UserRepository implements UserRepositoryInterface
{

    /**
     * @var \App\Entity\User\ResourceModel\User
     */
    private $userResourceModel;

    /**
     * @var \App\Api\User\Data\SearchResultInterface
     */
    private $userCollectionResult;

    /**
     * UserRepository constructor.
     *
     * @param \App\Entity\User\ResourceModel\User      $userResourceModel
     * @param \App\Api\User\Data\SearchResultInterface $userCollectionResult
     */
    public function __construct(
        User $userResourceModel,
        SearchResultInterface $userCollectionResult
    ) {
        $this->userResourceModel = $userResourceModel;
        $this->userCollectionResult = $userCollectionResult;
    }

    /**
     * Get user by id
     *
     * @param  int $userId
     * @return \App\Api\User\Data\UserInterface|null
     * @throws \App\Exceptions\EntityNotFoundException
     */
    public function getById(int $userId): ?UserInterface
    {
        try {
            $user = $this->userResourceModel->find($userId);

            if (!$user) {
                throw new Exception('User not found');
            }

            return $user;
        } catch (Exception $e) {
            $userNotFoundException = new EntityNotFoundException();
            $userNotFoundException->setMessage(
                'Could not find the user with id: ' . $userId . '. Please try later'
            );
            throw $userNotFoundException;
        }
    }

    /**
     * Delete user by IDint $userId
     *
     * @return bool|null
     * @throws \App\Exceptions\EntityDeletionFailed
     * @throws \App\Exceptions\EntityNotFoundException
     */
    public function deleteById($userId): ?bool
    {
        try {
            $this->userResourceModel->deleteById($userId);
            return true;
        } catch (EntityNotFoundException $exception) {
            throw $exception;
        } catch (Exception $e) {
            $userDeleteFailureException = new EntityDeletionFailed();
            $userDeleteFailureException->setMessage(
                'Could not delete the user with id: ' . $userId . '. Please try later'
            );
            throw $userDeleteFailureException;
        }
        return false;
    }

    /**
     * @param  \App\Api\User\Data\UserInterface $user
     * @return bool|null
     * @throws \App\Exceptions\EntityDeletionFailed
     */
    public function delete(UserInterface $user): ?bool
    {
        try {
            $this->userResourceModel->delete($user);
            return true;
        } catch (Exception $e) {
            throw new EntityDeletionFailed(
                'Could not delete the user with id: ' . $user->getId() . '. Please try later'
            );
        }
        return false;
    }

    /**
     * Create/Update a user
     *
     * @param  \App\Api\User\Data\UserInterface $user
     * @return \App\Api\User\Data\UserInterface|\App\Entity\User
     * @throws \App\Exceptions\EntitySaveException
     */
    public function save(UserInterface $user): ?UserInterface
    {
        try {
            if ($user->getId()) {
                return $this->userResourceModel->update($user);
            } else {
                // create new user
                return $this->userResourceModel->create($user);
            }
        } catch (Exception $exception) {
            $entitySaveException = new EntitySaveException();
            $entitySaveException->setEntity(UserInterface::ENTITY);
            throw $entitySaveException;
        }
    }

    /**
     * Collect users list
     *
     * @param  \App\Api\Search\CriteriaInterface $searchCriteria
     * @return \App\Api\User\Data\SearchResultInterface
     * @throws \Exception
     */
    public function getList(CriteriaInterface $searchCriteria)
    {
        try {
            $users = (array)$this->userResourceModel->findBy(
                $searchCriteria->getFilters(),
                $searchCriteria->getSortOrder(),
                $searchCriteria->getLimit(),
                $searchCriteria->getStart()
            );

            return $this->userCollectionResult->setItems($users);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
