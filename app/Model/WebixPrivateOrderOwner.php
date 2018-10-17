<?php

/*
Użytkownik, który posiada przynajmniej jedno zamówienie prywatne */

App::uses('AppModel', 'Model');

class WebixPrivateOrderOwner extends AppModel {

    public $useTable = 'users'; // No bo to tylko wrap dla Webix'a

    public $hasMany = ['WebixPrivateOrder'];
}