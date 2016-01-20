<?php

namespace NilPortugues\Example\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\ReadRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository;

interface ColorRepositoryInterface extends ReadRepository, WriteRepository, PageRepository
{
    /**
     * Returns a Color.
     *
     * @param Identity $id
     * @param Fields|null     $fields
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function find(Identity $id, Fields $fields = null);

    /**
     * Returns an array of Colors based on the filtering conditions.
     *
     * @param Filter|null $filter
     * @param Sort|null   $sort
     * @param Fields|null $fields
     *
     * @return Color[]
     */
    public function findBy(Filter $filter = null, Sort $sort = null, Fields $fields = null);

    /**
     * Adds or modifies a Color.
     *
     * @param Color $value
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function persist($value);

    /**
     * Delete a Color.
     *
     * @param Identity $id
     *
     * @throws ColorNotFoundException
     */
    public function delete(Identity $id);
}

