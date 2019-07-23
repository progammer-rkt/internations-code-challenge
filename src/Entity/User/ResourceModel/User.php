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

namespace App\Entity\User\ResourceModel;

use DateTime;
use App\Entity\User as UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Exceptions\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * User Resource Model
 *
 * This is what communicates to the DB using Doctrine
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class User extends ServiceEntityRepository
{

    /**
     * User constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    /**
     * Create new user
     *
     * @param  \App\Entity\User $user
     * @return \App\Entity\User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(UserEntity $user): ?UserEntity
    {
        $currentTime = new DateTime();
        $user->setCreatedAt($currentTime)->setUpdatedAt($currentTime);

        $this->_em->persist($user);
        $this->_em->flush();

        return $user;
    }

    /**
     * Update user details
     *
     * @param  \App\Entity\User $user
     * @return \App\Entity\User|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(UserEntity $user): ?UserEntity
    {
        if ($user->getId()) {
            $currentTime = new DateTime();
            $user->setUpdatedAt($currentTime);

            $this->_em->persist($user);
            $this->_em->flush();
        }

        return $user;
    }

    /**
     * Delete a user by ID
     *
     * @param  int $userId
     * @return \App\Entity\User\ResourceModel\User
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteById(int $userId): self
    {
        $user = $this->find($userId);

        if ($user && $user->getId()) {
            // find the group relation entries and add them for removal
            $userRelations = $this->getUserRelations($userId);
            foreach ($userRelations as $ugRelation) {
                $this->_em->remove($ugRelation);
            }

            // adding user itself for removal
            $this->_em->remove($user);
            $this->_em->flush();
        } else {
            $userNotFoundException = new EntityNotFoundException();
            $userNotFoundException->setMessage('User does not exist');
            throw $userNotFoundException;
        }
        return $this;
    }

    /**
     * Delete a user by it's instance reference
     *
     * @param  \App\Entity\User $user
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(UserEntity $user): self
    {
        if ($user->getId()) {
            $this->_em->remove($user);
            $this->_em->flush();
        }

        return $this;
    }

    /**
     * Collecting user_group_relation entries belong to the user
     *
     * @param  int $userId
     * @return array
     */
    public function getUserRelations(int $userId) : ?array
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder
            ->select('ugr')
            ->from(\App\Entity\UserGroupRelation::class, 'ugr')
            ->where('ugr.user_id = ' . $userId);

        return $queryBuilder->getQuery()->getResult();
    }
}
