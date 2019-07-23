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

namespace App\Core;

/**
 * Class DataObject
 *
 * Every model entity has to be a child of DataObject
 */
abstract class DataObject
{
    /**
     * Convert Object to Array
     *
     * @return array
     */
    public function toArray() : array
    {
        return get_object_vars($this);
    }
}
