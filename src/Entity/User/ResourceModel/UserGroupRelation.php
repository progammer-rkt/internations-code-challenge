<?php

namespace App\Entity\User\ResourceModel;

use App\Api\Group\Data\GroupInterface;
use App\Api\User\Data\UserGroupRelationInterface;
use App\Entity\Group;
use App\Entity\UserGroupRelation as UserGroupRelationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Resource Model for User Group Relation Entity
 *
 * @method UserGroupRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroupRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroupRelation[]    findAll()
 * @method UserGroupRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupRelation extends ServiceEntityRepository
{

    /**
     * UserGroupRelation constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserGroupRelationEntity::class);
    }

    /**
     * Create a user-group relation
     *
     * @param  \App\Entity\UserGroupRelation $ugRelation
     * @return \App\Entity\UserGroupRelation|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function assign(UserGroupRelationEntity $ugRelation) : ?UserGroupRelationEntity
    {
        $this->_em->persist($ugRelation);
        $this->_em->flush();

        return $ugRelation;
    }

    /**
     * Remove a user-group relation
     *
     * @param  \App\Entity\UserGroupRelation $ugRelation
     * @return \App\Entity\User\ResourceModel\UserGroupRelation|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function unAssign(UserGroupRelationEntity $ugRelation) : ?self
    {
        if ($ugRelation->getId()) {
            $this->_em->remove($ugRelation);
            $this->_em->flush();
        }

        return $this;
    }

    /**
     * Provide groups collection which is belonged to a user
     *
     * @param  int $userId
     * @return mixed
     */
    public function findGroupsBelongToUser(int $userId)
    {
        $groupAlias = 'g';
        $relationAlias = 'ugr';
        $ugRelationUserId = $relationAlias . '.' . UserGroupRelationInterface::USER_ID;
        $ugRelationGroupId = $relationAlias . '.' . UserGroupRelationInterface::GROUP_ID;
        $joinCond = $ugRelationGroupId . ' = ' . $groupAlias .  '.' . GroupInterface::ENTITY_ID;

        // Preparing a left join query to collect groups
        $queryBuilder = $this->createQueryBuilder($relationAlias);
        $queryBuilder
            ->select($groupAlias)
            ->where($queryBuilder->expr()->eq($ugRelationUserId, $userId))
            ->leftJoin(Group::class, $groupAlias, Join::WITH, $joinCond)
            ->orderBy($groupAlias . '.' . GroupInterface::CREATED_AT, 'DESC')
            ->setMaxResults(100);

        return $queryBuilder->getQuery()->getResult();
    }
}
