<?php
/**
 * Model kart, które podlegają serwisowi, są na magazynie, czyli Card.left > 0 */

App::uses('AppModel', 'Model');

class ServoCard extends AppModel {

    public $useTable = 'cards'; // No bo to tylko wrap dla Webix'a
}