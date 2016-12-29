<?php
App::uses('AppModel', 'Model');
/**
 * Job Model
 *
 * @property User $User
 * @property Card $Card
 * @property Event $Event
 */
class Job extends AppModel {
	
	
	public function findJobByNr($param = NULL) {
		
		if( $param != NULL ) {
                    $this->Behaviors->attach('Containable');
                    $zlecenie = $this->find('first', array(
                            'conditions' => array( 'Job.nr' => $param),
                            'fields' => array('Job.id', 'Job.nr', 'Job.stop_day'),
                            'contain' => array( 'Card.id' , 'Card.name' )
                    ));
                    return $zlecenie;
                }
		return null;
	}
		
		
		public function get_view_options() {
   			
			//return array_merge($this->view_options,$this->AdresDostawy->view_options,$this->Card->view_options);
			return $this->view_options;
			
		}
		
				
		
		
		public function prepareData($rqdata = array()) {
			
			if( !$rqdata['Job']['user_id'] )
				$rqdata['Job']['user_id'] = AuthComponent::user('id'); //zalogowany użytkownik
			$i=0;
			foreach( $rqdata['Card'] as &$card ) {
				
				if( $card['checked'] ) {
					if( $card['job_id'] ) {// EDYCJA karty już podpiętej, czili pawd. ikna
						$card['bylem'] = 1;
					} else {				// dopinamy inną luźną kartę
						$card['bylem'] = 2;
						//$card['status'] = JOBED;
						if( array_key_exists('id', $rqdata['Job']) ) 
							$card['job_id'] = $rqdata['Job']['id']; //edycja joba
					}
				} else {
					if( $card['job_id'] ) { //odpinamy kartę
						$card['job_id'] = 0;
						$card['status'] = R2BJ;
						$card['ikna'] = null;
						$card['bylem'] = 3;
					} else { // wolna niepodpieta (do joba) i nie wybrana karta
						$card['bylem'] = 4;
						unset($rqdata['Card'][$i]);
					}
				}
				$i++;
			}
			return $rqdata;
		}

		public $jedErr = 0;
		
		public $jedMsg = 'ZLECENIE ZAPISANE.';

		public function saveEdit( $rqdata = array() ) {
			
			if( $this->Card->saveMany($rqdata['Card']) ) {
				// sprawdź ile kart ma job_id != 0, bo jeżeli żadna, tzn. że
				// wszystkie zostały odczepione i trzeba usunąć zlecenie
				$hma = $this->policz($rqdata['Card']);
				unset($rqdata['Card']);
				if( $hma ) { //są jakieś karty doczepione - zapisz zlecenie
					if( $this->save($rqdata) ) {
						return true;
					} else {
						$this->jedErr=3;
					}
				} else {// nie ma doczepionych kart - puste zlecenie - trzeba 
						// je usunąć
					$this->delete($rqdata['Job']['id'], false);
					$this->jedMsg = 'ZLECENIE USUNIĘTE.';
					return true;
				}
			}
			else {
				$this->jedErr=2;	
			}
			return false;
		}
		
		private function policz( $karty = array()) {
			
			$wynik = 0;
			foreach( $karty as $card ) {
				if( $card['job_id'] ) ++$wynik;
			}
			
			return $wynik;
		}
		
		public function findCards($rqdata = array()) { //szuka karty do add & edit
		
			
			if( !empty($rqdata) ) //czyli edycja w tablicy mamy $this->request->data
				$conditions = array(
								'OR' => array( 
											'Card.job_id' => $rqdata['Job']['id'],
											array( 'Card.status' => R2BJ, 'Card.job_id' => 0)
				));
				/*
				$conditions = array(
								'OR' => array( 
											'Card.job_id' => $rqdata['Job']['id'],
											array( 	'Card.status' => array(D_OK, P_OK),
													'Card.job_id' => 0,
													'Order.status' => ORD_OK
				
				)));
				*/
			else // nowe zlecenie
				
				//$conditions = array( 'Card.status' => array(DOK, DOKPOK), 'Card.job_id' => 0, 'Order.status' => O_ACC);
				
				$conditions = array( 'Card.status' => R2BJ, 'Card.job_id' => 0, 'Order.status' => O_ACC);
			
			$cards = $this->Card->find('all', array(
				'conditions' => $conditions,
				'order' => array('Card.order_id')
			));
			
			return $cards;
			
		}

	
	public $JobError;

	// nadaj zleceniu numer po publikacji, zakładamy, że id właśnie zapisanego rekordu jest w $this->id
	public function set_job_number() {
		
            $this->JobError = 0; //brak błędu
            $id = $this->id;
            if( $id ) {
                if( $this->exists($id) ) {
                    //znajdz ostatni nr
                    $lastWithNr = $this->find('first', array(
                        'conditions' => array('OR' => array(
                                'Job.nr !=' => null,
                                'Job.id' => 1
                        )),
                        'order' => array('Job.nr' => 'desc')
                    ));
                    if( !empty($lastWithNr) ) {
						$new_nr = $this->skalkulujNr($lastWithNr, $id);                        					
                        $dane = array( 
							'Job' => array(
									'id' => $id,
									'nr' => $new_nr
                        ));

                        if( $this->save($dane) ) 
                                return true;
                        else {
                                $this->JobError = 1;
                                return false;
                        }
                    } else {
                            $this->JobError = 2;
                            return false;
                    }
                } else {
                        $this->JobError = 3;
                        return false;
                }
                return true;
            } else {
                    $this->JobError = 4;
                    return false;
            }
	
	}

	// oblicza nr kolejnego ZLEcenia, $row - tablica z danymi ostatniego ZLEcenia, które ma nr
	// $id - id rekordu, dla którego musimy znaleźć nr ZLEcenia
	private function skalkulujNr( $row = array(), $id = null ) {

		//pierwszy numer ever
		if( $row['Job']['id'] == 1 && $row['Job']['nr'] == null ) {
			return FIRST_JOB_NR; 
		}

		$nowrec = $this->find('first', array(
			'conditions' => array('Job.id' => $id)
		));
		if( empty($nowrec) ) { //coś nie tak
			return null;
		}

		// data publikacji (rok) ostatniego ZLEcenia z numerem
		$lastYear = (int)substr($row['Job']['data_publikacji'],0,4);
		// data publikacji (rok) nowego ZLEcenia
		$nowYear = (int)substr($nowrec['Job']['data_publikacji'],0,4);

		if( $nowYear > $lastYear) { // zmiana roku, konieczny reset numeru
			return (int)(substr($nowYear,2) . BASE_ZERO) + 1;
		}
		// zazwyczaj
		return $row['Job']['nr']+1;
	}


	// formatowania do views
	public $view_options = 
		array (
			'rodzaj_arkusza' =>	array( 
								//'label' => '?',
							 	//'div' => false,
								'options' => array( BIG_SHEET=>'OSOBNO', SMALL_SHEET=>'PRZEWROTKA', OTHER_SHEET => 'INNY' ),
								'default' => BIG_SHEET 
							),
			'arkusze_netto' =>	array( 
								//'div' => array('ark-nr' => 1),
								'ark-nr' => 1,
								'default' => 0,
								'min' => 0
							),
			'dla_laminacji' =>	array( 
								//'div' => array('ark-nr' => 1),
								'ark-nr' => 1,
								'default' => 0
							),
			'dla_drukarzy' =>	array( 
								//'div' => array('ark-nr' => 1),
								'ark-nr' => 1,
								'default' => 0
							),
			'stop_day' =>	array( 
							'label' => 'Data zakończenia',
							'dateFormat' => 'DMY',
							'monthNames' => array(
										1=>'Styczeń',
										2=>'Luty',
										3=>'Marzec',
										4=>'Kwiecień',
										5=>'Maj',
										6=>'Czerwiec',
										7=>'Lipiec',
										8=>'Sierpień',
										9=>'Wrzesień',
										10=>'Październik',
										11=>'Listopad',
										12=>'Grudzień'
								)
								
							),
			'comment' =>	array( 
								'label' => 'Uwagi',
								'rows' => '3'
							)
			
		);


		
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rodzaj_arkusza' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'arkusze_netto' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dla_laminacji' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dla_drukarzy' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),/*
		'comment' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Card' => array(
			'className' => 'Card',
			'foreignKey' => 'job_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'job_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'job_id',
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

}
