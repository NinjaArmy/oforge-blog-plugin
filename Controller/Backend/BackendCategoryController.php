<?php

namespace Blog\Controller\Backend;

use Blog\Models\Category;
use Oforge\Engine\Modules\CRUD\Controller\Backend\BaseCrudController;
use Doctrine\ORM\Mapping as ORM;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointAction;
use Oforge\Engine\Modules\Core\Annotation\Endpoint\EndpointClass;
use Oforge\Engine\Modules\CRUD\Enum\CrudDataTypes;
use Oforge\Engine\Modules\CRUD\Enum\CrudGroupByOrder;

/**
 * Class BackendCategoryController
 *
 * @package Blog\Controller\Backend
 * @EndpointClass(path="/backend/blog/categories", name="backend_blog_categories", assetScope="Backend")
 */
class BackendCategoryController extends BaseCrudController {
    /** @var string $model */
    protected $model = Category::class;

    /** @var array $modelProperties */
    protected $modelProperties = [
        'name' => 'name',
        'type' => CrudDataTypes::SELECT,
        'label' => 'plugin_blog_property_category_name',
        'crud' => [
            'index'  => 'readonly',
            'view'   => 'readonly',
            'create' => 'editable',
            'update' => 'editable',
            'delete' => 'readonly',
        ], # name

    ];

    /**
     * @var array $crudActions Keys of 'add|edit|delete'
     */
    protected $crudActions = [
        'index'  => true,
        'create' => true,
        'view'   => true,
        'update' => true,
        'delete' => true,
    ];


    /** @var array $indexOrderBy */
    protected $indexOrderBy = [
        'id' => CrudGroupByOrder::ASC,
    ];


    public function __construct() {
        parent::__construct();
    }





}
