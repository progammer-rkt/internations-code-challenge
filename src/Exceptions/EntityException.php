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

use Exception;

/**
 * EntityException
 */
class EntityException extends Exception
{

    /**
     * Indicates the entity
     *
     * @var string
     */
    public $entity;

    /**
     * Message
     *
     * @var string
     */
    public $message;

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Set the entity in context
     *
     * @param  string $entity
     * @return \App\Exceptions\EntityException
     */
    public function setEntity(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Custom exception message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message ?? 'Some problem occurred with the entity: ' . ucfirst(strtolower($this->entity));
    }

    /**
     * @param  string $message
     * @return \App\Exceptions\EntityException
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}
