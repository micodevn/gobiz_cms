<?php

namespace App\Http\Services;

use App\Exceptions\PermissionException;
use App\Http\Controllers\Controller;
use App\Http\Services\Service as BaseService;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionService extends BaseService
{
    private static function checkDefaultMethod(array $caller, User $user)
    {
        $method = \Arr::get($caller, 'function');
        $class = \Arr::get($caller, 'class');

        if (!$method || !$class) {
            return false;
        }

        if (!is_subclass_of($class, Controller::class, true)) {
            return false;
        }

        $permission = null;

        switch ($method) {
            case 'index':
                $permission = 'list'; break;
            case 'show':
                $permission = 'show'; break;
            case 'create':
            case 'store':
                $permission = 'create'; break;
            case 'edit':
            case 'update':
                $permission = 'update'; break;
            case 'destroy':
                $permission = 'delete'; break;
        }

        if (!$permission) {
            return false;
        }

        //Remove suffix controller and convert string to snake_case
        $parts = explode('\\', $class);
        $controllerName = \Arr::last($parts);

        $permissionPrefix = str_replace('Controller', '', $controllerName);
        $permissionPrefix = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $permissionPrefix));

        return $user->can($permissionPrefix.'.'.$permission) || $user->hasPermissionTo($permissionPrefix.'.'.$permission, 'web');
    }

    public static function check($permission = null, User $user = null) {
        if (!$user) {
            $user = \Auth::user();
        }

        if (!$permission) {
            $isAllow = self::checkDefaultMethod(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1], $user);

            if (!$isAllow) {
                throw new PermissionException('Permission Denied');
            }
        }

        if ($user->cant($permission)) {
            throw new PermissionException('Permission Denied');
        }
    }

    public static function checkByControllerMethod($method, $controller)
    {
        $caller = [
            'function' => $method,
            'class' => $controller
        ];

        $isAllow = self::checkDefaultMethod($caller, \Auth::user());

        if (!$isAllow) {
            throw new PermissionException('Permission Denied');
        }
    }
}
