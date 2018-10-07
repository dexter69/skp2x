<?php
/*
Twórca zamówienia, ten, który wpisał zamówienie do bazy.
Nie jest tożsamy z Właścicielem czy Opiekunem zamówienia - czyli tym,
który na stałe dba o klienta, który to zamówienie zlecił */
App::uses('AppModel', 'Model');

class WebixOrderCreator extends AppModel {

    public $useTable = 'users'; // No bo to tylko wrap dla Webix'a

    public $hasMany = ['WebixOrder'];
}