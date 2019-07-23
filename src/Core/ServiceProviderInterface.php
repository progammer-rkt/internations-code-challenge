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

namespace App\Core;

/**
 * Interface ServiceProviderInterface
 *
 * All application service providers are supposed to be an implementation
 * of this abstraction layer
 */
interface ServiceProviderInterface
{
    /**
     * All service providers are providing their service through
     * this method.
     *
     * @return mixed
     */
    public function execute();
}
