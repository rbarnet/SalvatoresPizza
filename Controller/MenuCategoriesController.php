<?php

App::uses('AppController', 'Controller', 'CakeEmail', 'Network/Email');

/**
 * MenuCategories Controller
 *
 * @property MenuCategory $MenuCategory
 * @property PaginatorComponent $Paginator
 */
class MenuCategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    
     public function beforeFilter() {
    parent::beforeFilter();

    // For CakePHP 2.0
    //$this->Auth->allow('*');

    // For CakePHP 2.1 and up
    App::uses('CakeEmail', 'Network/Email');
    $this->Auth->allow('home', 'menu', 'index', 'mobile_menu', 'm_index');
}

    public function home() {
        $this->layout = 'customer';
    }
    public function testemail(){
        $to = "bob3000000@aol.com";
$subject = "Daily Specials for Salvatores!";
$body = "The daily special are: ";
$this->loadModel('MenuItem');
$menuItems = $this->MenuItem->find('all', array('conditions' => array('MenuItem.menu_category_id' => 29, 'MenuItem.dateforspecial' => "2014-05-10 00:00:00")));
$count = 0;
while($count < count($menuItems)){
    $body .= $menuItems[$count]['MenuItem']['title'] . " and the price is " . $menuItems[$count]['MenuItem']['price'] . ".\n";
    $count++;
}
$headers = "From: bobbarnett60@gmail.com" . "\r\n";

if (mail($to, $subject, $body, $headers)) {
    $this->Session->setFlash(__('Message successfully sent'));
} else {
    echo ("Message delivery failed...");
}
return $this->redirect(array('action' => 'index'));
    }

    public function menu($category_id = null) {
        $this->layout = 'customer';
       
        if ($category_id == null)
            return $this->redirect(array('action' => 'home'));
        $category = $this->MenuCategory->read(null, $category_id);
        $this->set(compact('category'));
        $menuItems = $this->MenuCategory->MenuItem->find('all', array('conditions' => array('MenuItem.menu_category_id=' . $category_id)));
        if ($menuItems) {
            // this means there ARE items for this category (ignore sub-categories ... should not exist)
            if($category_id == 29){
                $date = "2014-05-10 00:00:00";//A daily special will be shown if it is added to the time of Zach's birthday.  I will change this later, but
                //that might entail a database modification
                $menuItems = $this->MenuCategory->MenuItem->find('all', array('conditions' => array('MenuItem.menu_category_id=' . $category_id,
                    'MenuItem.dateforspecial' => $date)));
            }
            
            $this->set(compact('menuItems'));
            
        } else {
            $subCategories = $this->MenuCategory->find('all', array('conditions' => array('MenuCategory.parent_id=' . $category_id)));
            $this->set(compact('subCategories'));
        }
    }

        public function mobile_menu($category_id = null) {
             $this->layout = 'customermobile';
        if ($category_id == null)
            return $this->redirect(array('action' => 'home'));
        $category = $this->MenuCategory->read(null, $category_id);
        $this->set(compact('category'));
        $menuItems = $this->MenuCategory->MenuItem->find('all', array('conditions' => array('MenuItem.menu_category_id=' . $category_id)));
        if ($menuItems) {
            // this means there ARE items for this category (ignore sub-categories ... should not exist)
            
            $this->set(compact('menuItems'));
        } else {
            $subCategories = $this->MenuCategory->find('all', array('conditions' => array('MenuCategory.parent_id=' . $category_id)));
            $this->set(compact('subCategories'));
        }
            
        }
        
        public function m_index() {
        $this->layout = 'customermobile';
    }
        
        
        public function m_rootmenu() {
            echo json_encode($this->menuCategories);
            exit;
        }
        
        public function m_entreesmenu(){
            $this->MenuCategory->recursive = 0;
            $entreecategories = $this->MenuCategory->find('all', array(
            'conditions' => array('ParentMenuCategory.title' => 'Entrees')));
            echo json_encode($entreecategories);
                exit;
        }
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->layout = 'customer';
    }

    public function index_backoffice() {
        $this->layout = 'customer';
        $this->MenuCategory->recursive = 0;
        $this->set('menuCategories', $this->Paginator->paginate());
    }

    /**
     * index method
     *
     * @return void
     */
    public function build($category_id = null) {
        $this->layout = 'customer';
        $this->MenuCategory->recursive = 0;
        $this->set('menuCategories', $this->Paginator->paginate());
        $category = $this->MenuCategory->read(null, $category_id);
        $this->set(compact('category'));
        $menuItems = $this->MenuCategory->MenuItem->find('all', array('conditions' => array('MenuItem.menu_category_id=' . $category_id)));
        if ($menuItems) {
            // this means there ARE items for this category (ignore sub-categories ... should not exist)
            $this->set(compact('menuItems'));
        } else {
            $subCategories = $this->MenuCategory->find('all', array('conditions' => array('MenuCategory.parent_id=' . $category_id)));
            $this->set(compact('subCategories'));
            $this->set('subCategories', $this->Paginator->paginate());
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->MenuCategory->exists($id)) {
            throw new NotFoundException(__('Invalid menu category'));
        }
        $options = array('conditions' => array('MenuCategory.' . $this->MenuCategory->primaryKey => $id));
        $this->set('menuCategory', $this->MenuCategory->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->MenuCategory->create();
            if ($this->MenuCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The menu category has been saved'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The menu category could not be saved. Please, try again.'));
            }
        }
        $parents = $this->MenuCategory->ParentMenuCategory->find('list');
        $this->set(compact('parents'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->MenuCategory->exists($id)) {
            throw new NotFoundException(__('Invalid menu category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->MenuCategory->save($this->request->data)) {
                $this->Session->setFlash(__('The menu category has been saved'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The menu category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('MenuCategory.' . $this->MenuCategory->primaryKey => $id));
            $this->request->data = $this->MenuCategory->find('first', $options);
        }
        $parentMenuCategories = $this->MenuCategory->ParentMenuCategory->find('list');
        $this->set(compact('parentMenuCategories'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->MenuCategory->id = $id;
        if (!$this->MenuCategory->exists()) {
            throw new NotFoundException(__('Invalid menu category'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->MenuCategory->delete()) {
            $this->Session->setFlash(__('Menu category deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Menu category was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}
