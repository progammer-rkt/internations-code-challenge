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

namespace App\Api\Group\Data;

use DateTimeInterface;

/**
 * Interface GroupInterface
 *
 * Abstraction layer that is supposed to implemented by an Group implementation
 *
 * @api
 * @version 100.0.0
 */
interface GroupInterface
{
    /**
* #@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY = 'user_group';
    const ENTITY_ID = 'id';
    const NAME = 'name';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * Get Group Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Group Id
     *
     * @param  int $id
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function setId(int $id);

    /**
     * Get Group name
     *
     * @return string
     */
    public function getName();

    /**
     * Set group name
     *
     * @param  string $name
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function setName(string $name);

    /**
     * Get group created time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set group created time
     *
     * @param  \DateTimeInterface $createdAt
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function setCreatedAt(DateTimeInterface $createdAt);

    /**
     * Get group last updated time
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set group last updated time
     *
     * @param  \DateTimeInterface $updatedAt
     * @return \App\Api\Group\Data\GroupInterface
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt);
}
