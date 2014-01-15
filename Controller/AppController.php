<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller', 'CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    var $menuCategories;
    
     public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')),
                'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            )
            )
        ),
        'Session'
    );
     
    public $helpers = array('Html', 'Form', 'Session');
    
    public function beforeFilter() {
        $this->Auth->loginAction = array(
          'controller' => 'users',
          'action' => 'login'
        );
        $this->Auth->logoutRedirect = array(
          'controller' => 'users',
          'action' => 'login'
        );
        $this->Auth->loginRedirect = array(
          'controller' => 'menucategories',
          'action' => 'menu'
        );
        $this->loadModel('User');
        $group = $this->User->Group;
        //allow admins access to everything
        $group->id = 2;
        $this->Acl->allow($group, 'controllers');
        $group->id = 5;
        //allow customers the ability to add to cart and view cart and logout and remove items from cart
        $this->Acl->allow($group, 'controllers/OrderDetails/addtocart');
        $this->Acl->allow($group, 'controllers/OrderDetails/viewcart');
        $this->Acl->allow($group, 'controllers/OrderDetails/deleteitemcustomer');
        $this->Acl->allow($group, 'controllers/OrderDetails/addtopping');
        $this->Acl->allow($group, 'controllers/OrderDetailToppings/deletetoppingcustomer');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->loadModel('MenuCategory');
        $this->MenuCategory->recursive = 0;
        $this->menuCategories = $this->MenuCategory->find('all',array('conditions'=>array('MenuCategory.parent_id IS NULL'),'order'=>array('MenuCategory.order')));
        $this->set('menuCategories', $this->menuCategories);            
    }
    
}
