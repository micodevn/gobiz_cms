<?php

namespace App\Http\Controllers;

use App\Http\Services\PermissionService;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    protected $defaultCheckMethods = [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'show'
    ];

    protected $excludeDefaultCheckMethods = [];

    public function sendResponse($result, $message)
    {
        return response_success($result, $message);
    }

    public function sendError($error, $code = 404)
    {
        return response_error("", $code, $error);
    }

    public function sendSuccess($message)
    {
        return response_success([], $message);
    }

    /**
     *
     * Check permission for default actions in controller
     *
     * @param $method
     * @param $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\PermissionException
     */
    public function callAction($method, $parameters)
    {
        $action = request()->route()->getAction();
        $controller = explode('@', $action['controller'])[0];
        $methodsToCheck = array_diff($this->defaultCheckMethods, $this->excludeDefaultCheckMethods);
        if (in_array($method, $methodsToCheck)) {
            // TODO
//            PermissionService::checkByControllerMethod($method, $controller);
        }

        return parent::callAction($method, $parameters);
    }
}
