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

namespace App\Entity\User\Collection;

use App\Api\User\Data\SearchResultInterface;
use App\Core\DataObject;

/**
 * UserCollectionSearchResult
 *
 * User collection that will be used by a user repository
 */
class UserCollectionSearchResult implements SearchResultInterface
{

    /**
     * @var array
     */
    private $items = [];

    /**
     * @param  array $items
     * @return \App\Entity\User\Collection\UserCollectionSearchResult
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Convert Collection objects to json objects
     *
     * @return array
     */
    public function toArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            if ($item instanceof DataObject) {
                $items[] = $item->toArray();
            } else {
                $items[] = $item;
            }
        }

        return $items;
    }
}
