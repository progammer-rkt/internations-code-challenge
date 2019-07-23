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

namespace App\Entity\Group\ResourceModel;

use App\Entity\Group as GroupEntity;
use App\Entity\UserGroupRelation;
use App\Exceptions\EntityNotFoundException;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Group extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GroupEntity::class);
    }

    /**
     * Create new group
     *
     * @param  \App\Entity\Group $group
     * @return \App\Entity\Group
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(GroupEntity $group): ?GroupEntity
    {
        $currentTime = new DateTime();
        $group->setCreatedAt($currentTime)->setUpdatedAt($currentTime);

        $this->_em->persist($group);
        $this->_em->flush();

        return $group;
    }

    /**
     * Update group details
     *
     * @param  \App\Entity\Group $group
     * @return \App\Entity\Group|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(GroupEntity $group): ?GroupEntity
    {
        if ($group->getId()) {
            $currentTime = new DateTime();
            $group->setUpdatedAt($currentTime);

            $this->_em->persist($group);
            $this->_em->flush();
        }

        return $group;
    }

    /**
     * Delete a group by ID
     *
     * @param  int $groupId
     * @return \App\Entity\Group\ResourceModel\Group
     * @throws \App\Exceptions\EntityNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteById(int $groupId): self
    {
        $group = $this->find($groupId);

        if ($group && $group->getId()) {
            // find the group relation entries and add them for removal
            $groupRelations = $this->getGroupRelations($groupId);
            foreach ($groupRelations as $ugRelation) {
                $this->_em->remove($ugRelation);
            }

            // add group itself for removal and perform removal
            $this->_em->remove($group);
            $this->_em->flush();
        } else {
            $groupNotFoundException = new EntityNotFoundException();
            $groupNotFoundException->setMessage('Group does not exist');
            throw $groupNotFoundException;
        }
        return $this;
    }

    /**
     * Delete a group by it's instance reference
     *
     * @param  \App\Entity\Group $group
     * @return $this
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(GroupEntity $group): self
    {
        if ($group->getId()) {
            $this->_em->remove($group);
            $this->_em->flush();
        }

        return $this;
    }

    /**
     * Collecting user_group_relation entries belong to the group
     *
     * @param  int $groupId
     * @return array
     */
    public function getGroupRelations(int $groupId) : ?array
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder
            ->select('ugr')
            ->from(UserGroupRelation::class, 'ugr')
            ->where('ugr.group_id = ' . $groupId);

        return $queryBuilder->getQuery()->getResult();
    }
}
