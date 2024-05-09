<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class PermissionGroup extends BaseComponent
{

    /**
     * @var bool
     */
    public bool $editable = true;

    /**
     * @var Model
     */
    public Model $model;

    /**
     * @var string
     */
    public string $inUserAction = 'default';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $editable = true, $id = '', $class = '',$inUserAction = 'default')
    {
        parent::__construct($id, $class);
        $this->model = unserialize($model);
        $this->editable = $editable;
        $this->inUserAction = $inUserAction;
    }

    function assignArrayByPath(&$arr, $path, $value, $separator='.') {
        $keys = explode($separator, $path);

        foreach ($keys as $key) {
            $arr = &$arr[$key];
        }

        $arr = $value;
    }

    private function extractWildcardArr($arr)
    {
        $result = [];
        foreach ($arr as $item => $value) {
            $this->assignArrayByPath($result, $value, []);
        }

        return $result;
    }

    /**
     * @param Role|HasRoles $model
     * @return array
     */
    private function getPermissions(mixed $model) : array
    {
        $permissions = [];

        $permissions['all'] = Permission::query()->pluck('name')->toArray();
        $permissions['currents'] = $model->permissions()->pluck('name')->toArray();
        $classUses = class_uses($this->model);
        if (in_array(HasRoles::class, $classUses)) {
            $permissions['currents'] = $model->getAllPermissions()->pluck('name')->toArray();
        }

        return $permissions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render() : \Illuminate\Contracts\View\View|\Closure|string
    {
        $classUses = class_uses($this->model);
        if (!$this->model instanceof Role && !in_array(HasRoles::class, $classUses)) {
            return "This model doesn't has HasRoles Trait";
        }
        $permissions = $this->getPermissions($this->model);
        $permissions['allExtract'] = $this->extractWildcardArr($permissions['all']);
        $inUserAction = $this->inUserAction;
        return view('components.permission-group', compact('permissions','inUserAction'));
    }
}
