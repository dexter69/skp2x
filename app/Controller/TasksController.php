<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP TasksController
 * @author dexter
 */
class TasksController extends AppController {
    
    //testowa metoda
    public function index() {
        
        $active = $this->Task->getActive();
        $this->set( compact('active' ) );
    }

}
