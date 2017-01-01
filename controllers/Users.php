<?php namespace October\Test\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use October\Test\Models\Role;
use October\Test\Widgets\Dropdown;

/**
 * Users Back-end Controller
 */
class Users extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    protected $dropdownWidget;

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.Test', 'test', 'users');

        $this->dropdownWidget = new Dropdown($this);
        $this->dropdownWidget->alias = 'roles';
        $this->dropdownWidget->setListItems(Role::lists('name', 'id'));
        $this->dropdownWidget->setErrorMessage('Items list empty. First add items to the roles model.');
        $this->dropdownWidget->bindToController();
    }

    public function listExtendQuery($query)
    {
        $query->withRole($this->dropdownWidget->getActiveIndex());
    }
}
