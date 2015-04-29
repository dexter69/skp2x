<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property Card $Card
 * @property Upload $Upload
 */
class Project extends AppModel {
	
	
/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */
	public $farby_na_sito = array (
									'0'	=>	'BRAK',	//nie ma podkładu z sita
									'2'	=>	'SREBRO 303',
									'3'	=>	'ZŁOTO 3600',
									'4'	=>	'ZŁOTO 4320',
									'5'	=>	'ZŁOTO 5013',
									'6'	=>	'PERŁA 38001',
									'7'	=>	'PERŁA 44001',
									'1'	=>	'INNY'	//inny kolor - uwagi												
								);
								
	// formatowania do views
	public $view_options = 
		array (
			'x_material'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								'default' => 1 //
							),
			// x_c, x_m, x_y, x_k - CMYK dla awers i rewers
			'x_c'=>	array( 
								'label' => 'C',
							 	//'div' => array('id' => 'user_id_div'),
								//'options' => array(), 
								'type' => 'checkbox',
								'default' => 1 //
							),
			'x_m'=>	array( 
								'label' => 'M',
							 	//'div' => array('id' => 'user_id_div'),
								//'options' => array(), 
								'type' => 'checkbox',
								'default' => 1 //
							),
			'x_y'=>	array( 
								'label' => 'Y',
							 	//'div' => array('id' => 'user_id_div'),
								//'options' => array(), 
								'type' => 'checkbox',
								'default' => 1 //
							),
			'x_k'=>	array( 
								'label' => 'K',
							 	//'div' => array('id' => 'user_id_div'),
								//'options' => array(), 
								'type' => 'checkbox',
								'default' => 1 //
							),
			'x_pant'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(0,1,2,3,4), 
								//'default' => 2 //
							),
			'x_lam'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array('2'=>'BŁYSZCZĄCY', '3'=>'GŁADKI', '4'=>'CHROPOWATY'), 
								'default' => 2 //
							),
			'mag'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array('0'=>'BRAK', '1'=>'HiCo', '2'=>'LoCo'), 
								'default' => 0 //
							),
			'x_sito'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(), 
								'default' => 0 //
							),
			'x_podpis'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
									'0'	=>	'BRAK',	
									//'1' =>	'INNY', /* zarezerwowane */
									'2'	=>	'PRZEŹROCZYSTY', //Pasek do podpisu - przeźroczysty
									'3'	=>	'BIAŁY', //Pasek do podpisu - biały
								), 
								'default' => 0 //
							),
			'dziurka'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'BRAK',	//nie ma 
												'2'	=>	'OKRĄGŁA',
												'3'	=>	'OWALNA',
												'4' =>	'EURO',
												'1'	=>	'INNA'
											), 
								'default' => 0 //
							),
			'chip'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'BRAK',	//nie ma 
												'2'	=>	'UNIQUE',
												'3'	=>	'MIFARE',
												'4'	=>	'SLE',
												'1' =>	'INNY'
											), 
								'default' => 0 //
							),
			'ksztalt'=>	array( 
								//'label' => 'PASEK DO PODPISU',
							 	//'div' => array('id' => 'user_id_div'),
								'options' => array(
												'0'	=>	'STANDARD',
												'2'	=>	'"2+1"',
												'3' =>	'"Brelokx3"',
												'1'	=>	'INNY'
											), 
								'default' => 0 //
							),
			'yesno'=>	array( 
								//
							 	//
								'options' => array(
												'0'	=>	'NIE',
												'2'	=>	'TAK' //1 - zarezerw na inny
											), 
								'default' => 0 //
							)																																						
		);
		
		public function get_view_options() {
   
			// 
			$this->view_options['x_sito']['options'] = $this->farby_na_sito;
			$this->view_options['name'] = $this->Card->view_options['name'];
			return $this->view_options;
		}
	
	

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		/*'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'a_material' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_material' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_c' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_c' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_m' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_m' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_y' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_y' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_k' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_k' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_pant' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_pant' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lam' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lam' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mag' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_podklad' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_wybr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_podklad' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_wybr' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_zadruk' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_zadruk' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_podpis' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_podpis' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_zdrapka' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_zdrapka' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lakpuch' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lakpuch' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'a_lakblys' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'r_lakblys' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'isperso' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dziurka' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'chip' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ksztalt' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hologram' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Card' => array(
			'className' => 'Card',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Upload' => array(
			'className' => 'Upload',
			'joinTable' => 'projects_uploads',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'upload_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	
	public function saveitAll( $puc = array() , &$errno ) { 
		
		// puc <=> project, upload and card data
		/*
			$errno - numery błędów:
			
			0 - bez błędu
			1 - inny błąd
			2 - pusta tablica wejściowa
			3 - błąd przetworzenia/przeniesienia wysłanych plików
			4 - pliki przeniesione do uploads, ale nie udało się w bazie zapisac info
			5 - liczba wysłanych plików różna od liczby zapisanych
			6 - nie udało się projektu zapisać
		*/
		
		$errno=0;
		if ( empty($puc) ) {
			$errno = 2;
			return FALSE; 
		}
		
		// prubujemy zapisać uploadowane pliki 
		$out = array();
		if ( count($puc['Upload']['files'])!=1 || $puc['Upload']['files'][0]['error']!=UPLOAD_ERR_NO_FILE ) {
			//tzn. załączono jakies pliki
		
			$in = $this->Upload->manage_posted_files($puc);
			if( !empty($in) ) {
				$out = $this->Upload->my_saveMany( $in );
				if( empty($out) ) {
					$errno = 4;
					return FALSE; 
				}
				if( count($in)!= count($out) ) {
					$errno = 5;
					return FALSE;
				}
			}
			else {
				$errno = 3;
				return FALSE;
			}
		}
		// zapisaliśmy z sukcesem pliki powyżej, w $out mamy tablice z identy-
		// fikatorami zapisanych rekorów w uploads
		
		
		
		// przepisujemy project
		$ready = array();
		$ready['Project'] = $puc['Project'];
		
		// teraz chcemy połączyć te dane z ewentylanymi starymi plikami (od innych)
		// kart dołączonymi do tego projektu
		$ready['Upload'] = array('Upload' => array());
		if( !empty($puc['Upload']['Upload']) ) { 
			// znaczy mamy jakies pliki z bazy
			$ready['Upload']['Upload'] = $puc['Upload']['Upload'];
		}
		
		
		$ready['Upload']['Upload'] = array_merge($ready['Upload']['Upload'],$out);
		$this->create();
		if( $this->save($ready) ) {
			//zapisaliśmy projekt, to czas na dane karty
			$karta = array('Card'=> array());
			$karta['Card'] = $puc['Card'];
			//id właśnie zapisanego projektu
			$karta['Card']['project_id'] = $this->id;
			//$this->print_r2($karta);
			$this->Card->create();
			if( $this->Card->save($karta, false) ) return TRUE; 
			return FALSE; 
		}
		else {
			$errno = 6;
			return FALSE;
		}
			
		
	}
	
}
