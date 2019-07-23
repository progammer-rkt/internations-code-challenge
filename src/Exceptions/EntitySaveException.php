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
 * Exception: EntitySaveException
 *
 * Asserted when an entity save is encountered by an issue
 */
class EntitySaveException extends EntityException
{

    /**
     * Custom exception message
     *
     * @return string
     */
    public function message(): string
    {
        return 'Saving of entity: ' . ucfirst(strtolower($this->getEntity())) . ' has encountered some issue';
    }
}
