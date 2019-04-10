<?php

namespace App\Helpers\View;

use App\Http\Controllers\CommentsController;
use App\Models\Adminuser;
use Illuminate\Support\Facades\Auth;
use Unckleg\Helpers\Factory\Action\ActionHelper;

class Sidebar extends ActionHelper
{
    /**
     * @var string - Name of current controller
     */
    private $controller;

    /**
     * @var string - Name of current action
     */
    private $action;

    /**
     * @var string - Name of logged-in user role
     */
    private $role;

    /**
     *  @param  string $controller
     *  @throws \Exception
     *
     *  @return mixed
     *  @access public
     */
    public function active($controller, $action = NULL)
    {
        if (!auth()->user()) {
            return Auth::logout();
        }

        $this->role = auth()->user()->role;

        $this->resolveProperties();

        if ($this->controller == $this->normalizedControllerName($controller)) {
            if(!empty($action)){
                if($this->action != $action){
                    return "";
                }
            }
            
            return 'active';
        }
    }
    
    public function display($controller, $action = NULL) 
    {
        $display = 'd-none';
        
        if($this->active($controller, $action) == 'active') {
            $display = '';
        }
        
        return $display;
    } 

    /**
     * Method resolveProperties used to define controller & action class property values with
     * controller & action name fetched from request.
     *
     * @return void
     */
    private function resolveProperties()
    {
        $action = $this->request->route()->getAction();
        $controller = class_basename($action['controller']);

        list($controller, $action) = explode('@', $controller);

        $this->controller = $this->normalizedControllerName($controller);
        $this->action = $action;
    }

    /**
     * @param  $ctrlName | Full controller name
     * @return mixed     | string
     */
    private function normalizedControllerName($ctrlName)
    {
        return (mb_strtolower(
            str_replace('Controller', '', (string) $ctrlName)
        ));
    }
}