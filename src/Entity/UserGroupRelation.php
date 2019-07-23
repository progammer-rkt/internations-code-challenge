<?php

namespace App\Entity;

use App\Api\User\Data\UserGroupRelationInterface;
use App\Core\DataObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Entity\User\ResourceModel\UserGroupRelation")
 */
class UserGroupRelation extends DataObject implements UserGroupRelationInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="user")
     * @ORM\JoinColumn(name="user_id",     referencedColumnName="id")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="user_group")
     * @ORM\JoinColumn(name="group_id",          referencedColumnName="id")
     */
    private $group_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->group_id;
    }

    public function setGroupId(int $group_id): self
    {
        $this->group_id = $group_id;

        return $this;
    }
}
