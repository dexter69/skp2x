<?php

/*
Zamówienie prywatne (status=0) */

App::uses('AppModel', 'Model');

class WebixPrivateOrder extends AppModel {

    public $useTable = 'orders'; // No bo to tylko wrap dla Webix'a

    public $defaultConditions = [
        'status' => 0 // prywatne zamówienie
    ];//array(‘Course.semester_id’ => SEMESTER_ID);

}
