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

namespace App\Api\User\Data;

use DateTimeInterface;

/**
 * Interface UserInterface
 *
 * Abstraction layer that is supposed to implemented by an User implementation
 *
 * @api
 * @version 100.0.0
 */
interface UserInterface
{
    /**
* #@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY = 'user';
    const ENTITY_ID = 'id';
    const FULLNAME = 'fullname';
    const COUNTRY = 'country';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * Get User Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set User Id
     *
     * @param  int $id
     * @return \App\Api\User\Data\UserInterface
     */
    public function setId(int $id);

    /**
     * Get User Full name
     *
     * @return string
     */
    public function getFullname();

    /**
     * Set user full name
     *
     * @param  string $fullname
     * @return \App\Api\User\Data\UserInterface
     */
    public function setFullname(string $fullname);

    /**
     * Get user's country
     *
     * @return string|null
     */
    public function getCountry();

    /**
     * Set user's country
     *
     * @param  string $country
     * @return \App\Api\User\Data\UserInterface
     */
    public function setCountry(string $country);

    /**
     * Get user created time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set user created time
     *
     * @param  \DateTimeInterface $createdAt
     * @return \App\Api\User\Data\UserInterface
     */
    public function setCreatedAt(DateTimeInterface $createdAt);

    /**
     * Get user last updated time
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set user last updated time
     *
     * @param  \DateTimeInterface $updatedAt
     * @return \App\Api\User\Data\UserInterface
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt);
}
