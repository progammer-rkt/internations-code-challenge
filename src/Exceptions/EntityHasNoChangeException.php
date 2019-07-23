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

namespace App\Exceptions;

/**
 * EntityHasNoChangeException
 *
 * Throws when there is no change in the data of an entity
 */
class EntityHasNoChangeException extends EntityException
{

    /**
     * Custom exception message
     *
     * @return string
     */
    public function message(): string
    {
        return 'There is no change in the entity: ' . ucfirst(strtolower($this->getEntity())) . '.';
    }
}
