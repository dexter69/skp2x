<?php
App::uses('AppModel', 'Model');

/**
 * Address Model
 *
 * @property 
 * @property 
 * @property 
 * @property 
 * @property 
 */
class Address extends AppModel {
	
	
/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */
	
	// formatowania do views
	public $view_options = 
		array (
			'nazwa'=>	array( 
								'label' => 'Nazwa',
							 	'div' => array('id' => 'name_div', 'class' => 'input text extadd'),
							 	//array('gibon' => 'ble2')
							 	'disabled' => true
							),							
			'ulica'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'ulica_div', 'class' => 'input text extadd'),
							 	'disabled' => true
							),							
			'nr_budynku'=>	array( 
								'label' => 'Nr',
							 	'div' => array('id' => 'nr_budynku_div', 'class' => 'input text extadd'),
							 	'disabled' => true
							),						
			'kod'=>	array( 
								//'label' => 'Kod pocztowy',
								'label' => 'Kod',
							 	'div' => array('id' => 'kod_div', 'class' => 'input text extadd'),
							 	'disabled' => true
							),	
			'miasto'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'miasto_div', 'class' => 'input text extadd'),
							 	'disabled' => true
							),
			'kraj'=>	array( 
								//'label' => '...',
							 	'div' => array('id' => 'kraj_div', 'class' => 'input text extadd'),
							 	'disabled' => true
							)				
		);	
	
	

/**
 * Validation rules
 *
 * @var array
 */
	public $validate_ = array(
	
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ulica' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nr_budynku' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'miasto' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'kod' => array(
			//'notEmpty' => array(
				//'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		),
		'kraj' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
		

	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ZlecenieWyslaneNa' => array(
			'className' => 'Order',
			'foreignKey' => 'wysylka_id'
	
		),
		'ZlecenieFakturowaneNa' => array(
			'className' => 'Order',
			'foreignKey' => 'siedziba_id'
	
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	
	public $belongsTo = array(
        'Customer' => array(
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        )
    );
	




}
