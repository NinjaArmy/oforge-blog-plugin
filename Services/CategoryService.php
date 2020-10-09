<?php

namespace Blog\Services;

use Doctrine\ORM\ORMException;
use Oforge\Engine\Modules\Core\Abstracts\AbstractDatabaseAccess;
use Blog\Models\Category;


/**
 * Class CategoryService
 *
 * @package Blog\Services
 */
class CategoryService extends AbstractDatabaseAccess {

    /** @inheritDoc */
    public function __construct() {
        parent::__construct(['default'=> Category::class, 'categories' => Category::class]);


    }


    /**
     * Get Category by ID.
     * @param int $categoryID
     * @return Category | null
     * @throws ORMException
     *
     */
    public function getCategoryByID(int $categoryID): ?Category{
        /** @var Category | null $category */

        $category = $this->repository()->find($categoryID);

        return $category;

    }


    /**
     * @return array
     * @throws ORMException
     */
    public function getAllCategories()  {
        $result = [];
        /** @var Category[] $categories */
        $categories = $this->repository('categories')->findAll();

        foreach ($categories as $category) {
            $result[$category->getId()] = $category->getName();
        }

        return $result;
    }





}
