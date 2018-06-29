<?php
App::uses('AppModel', 'Model');
/**
 * Upload Model
 *
 * @property Project $Project
 */
class Upload extends AppModel {



/**
 * 
 *	Ścieżka uploadu plików
 * 
 */

	protected $uplpath = 'uploads';
	



	
        //pliki załączane do job'a
        public function manage_jobed_files( array $inputarr = array() ) {


        $i=0;
        $result = array();
        $row = array();

        // pliki dziedziczą twórcę i właściciela karty
        $userid = $ownerid = $inputarr['Event']['user_id'];


        foreach ( $inputarr['Upload']['files'] as $value ) {

                if( $value['error'] === UPLOAD_ERR_OK ) {
                        /* zmieniamy sposob generowania nazwy i nie sprawdzamy istnienia już takich plików
                        do { $id = String::uuid(); } while ( file_exists(APP.PLIKOZA.DS.$id) ); */
                        $new_uuid = $this->newUuidName();
                        if ( move_uploaded_file($value['tmp_name'], APP.PLIKOZA.DS.$new_uuid) ) {
                            $row['role'] = 0;
                            $row['user_id'] = $userid;
                            $row['owner_id'] = $ownerid;                                
                            $row['filename'] = $value['name'];
                            $row['filesize'] = $value['size'];
                            $row['filemime'] = $value['type'];
                            $row['uuidname'] = null;
                            $row['new-uuidname'] = $new_uuid;
                            array_push($result, $row);
                        }
                        else return array();
                }
                else return array();
        }

        return $result;

        }	
	
        public function manage_posted_files( array $inputarr = array() ) {


            $i=0; $result = array(); $row = array();

            // pliki dziedziczą twórcę i właściciela karty
            $userid = $inputarr['Card']['user_id'];
            $ownerid = $inputarr['Card']['owner_id'];

            foreach ( $inputarr['Upload']['files'] as $value ) {

                if( $value['error'] === UPLOAD_ERR_OK ) {

                    if( $inputarr['Upload'][$i++]['checkbox'] ) { // jeżeli checked plik   
                        /* zmieniamy sposob generowania nazwy i nie sprawdzamy istnienia już takich plików
                        do { $uuid = String::uuid(); } while ( file_exists(APP.PLIKOZA.DS.$uuid) ); */
                        $new_uuid = $this->newUuidName();
                        if ( move_uploaded_file($value['tmp_name'], APP.PLIKOZA.DS.$new_uuid) ) {
                            $row['role'] = $inputarr['Upload'][$i-1]['role'];
                            $row['user_id'] = $userid;
                            $row['owner_id'] = $ownerid;
                            if( $row['role'] == OTHER_ROLE ) {
                                $row['roletxt'] = $inputarr['Upload'][$i-1]['roletxt'];
                            } else {
                                $row['roletxt'] = $this->view_options['role']['options'][strval($row['role'])];
                            }
                            $row['rodo'] = $inputarr['Upload'][$i-1]['rodo'];
                            $row['filename'] = $value['name'];
                            $row['filesize'] = $value['size'];
                            $row['filemime'] = $value['type'];
                            $row['uuidname'] = null;
                            $row['new-uuidname'] = $new_uuid;
                            array_push($result, $row);
                        }
                        else { return array(); }
                    }

                }
                else { return array(); }
            }

            return $result;

        }
        
        private function newUuidName($short = false) {
            
            if($short ) {
                return date("YmdHis") . "_" . String::uuid();
            } else {
                return date("Y-m-d_H.i.s") . "_" . String::uuid();
            }
        }
        
        /*
         *  Chcemy coby czasem nie nadpisać już istniejącego pliku
         */
        private function my_move_file( $tmpname = null ) {
            
            if( $tmpname != null ) {
                do {
                    $uuid = String::uuid();
                } while ( file_exists(APP.PLIKOZA.DS.$uuid) );
                if ( move_uploaded_file($tmpname, APP.PLIKOZA.DS.$uuid) ) {
                    $row['role'] = $inputarr['Upload'][$i-1]['role'];
                    $row['user_id'] = $userid;
                    $row['owner_id'] = $ownerid;
                    if( $row['role'] == OTHER_ROLE )
                            $row['roletxt'] = $inputarr['Upload'][$i-1]['roletxt'];
                    else
                            $row['roletxt'] = $this->view_options['role']['options'][strval($row['role'])];
                    $row['filename'] = $value['name'];
                    $row['filesize'] = $value['size'];
                    $row['filemime'] = $value['type'];
                    $row['uuidname'] = $uuid;
                    array_push($result, $row);

            }
            } else {
                return array();
            }
            
        }
		
        /* oczekujemy danych wejściowych jak dla saveMany. Zwraca tablicę 
                z indeksami zapisanych rekordów lub pustą.
        */
        public function my_saveMany ( $records = array() ) {

                $i=0;
                $result = array();
                foreach( $records as $value ) {

                    if( !array_key_exists('id', $value) ) {
                       $this->create();
                    }
                    if ( $this->save($value) ) {
                       $result[$i++] = $this->id;
                    }
                }

                return $result;	
        }


        public function edytuj_zalaczone( $zalarr = array() ) {

                if( empty($zalarr) ) return array();
                $editarr = $remarr = array();
                foreach($zalarr as $rekord) {
                        if( $rekord['taken'] ) { //tylko zacheckboxowane
                                unset($rekord['taken']);
                                if( $rekord['role'] != OTHER_ROLE )
                                        $rekord['roletxt'] = $this->view_options['role']['options'][strval($rekord['role'])];
                                $editarr[] = $rekord;
                        }
                        else {
                                unset($rekord['taken']);
                                $remarr[] = $rekord;
                        }

                }
                return array( 'edit' => $editarr, 'remove' => $remarr);
        }

        //pliki w we tablicy (format jak dla saveMany) przenieś do kosza o ile nie są
        //podpięte do żadnej karty
        public function eventually_kosz( $koszarr  = array() ) {

            $ret = 0;
            if( !empty($koszarr) ) {

                foreach($koszarr as $wiersz) {
                    $options = array('conditions' => array('Upload.' . $this->primaryKey => $wiersz['id']));
                    $upload = $this->find('first', $options);

                    if( !empty($upload) && array_key_exists('Card', $upload) && empty($upload['Card']) ) {
                            // w związku z nowym sposobem nazywania plików
                            $uname = ( $upload['Upload']['uuidname'] != null ) ? $upload['Upload']['uuidname'] : $upload['Upload']['new-uuidname'];
                            rename(APP.$this->uplpath.DS.$uname, APP.PLIKOZA.DS.KOSZ.DS.$uname );
                            $this->delete( $upload['Upload']['id'], false );
                    }
                }
            }

            return $ret;
        }


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Card' => array(
			'className' => 'Card',
			'joinTable' => 'cards_uploads',
			'foreignKey' => 'upload_id',
			'associationForeignKey' => 'card_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
	
	
	public $belongsTo = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);





/**
 * Zmienna regulująca zależności między wyświetlaniem w widokach a bazą danych
 *
 * @var array
 */
 
	// formatowania do views
	public $view_options = 
		array (
			'upl'=>	array( 
								//'label' => 'aC',
							 	//'div' => array('id' => 'user_id_div'),
								//'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								'default' => 0 //
							),
			'role'  =>  array( 
                            'label' => false,
                            'div' => false,
                            'options' => array(
                                    NULL=>'- WYBIERZ COŚ -',
                                    PROJ=>'PROJEKT KARTY',
                                    BAZA=>'BAZA DANYCH',
                                    BAZA_RODO => '!!! BAZA RODO !!!',
                                    PODPERSO=>'PODGLĄD PERSO',
                                    PODGLAD=>'PODGLĄD',
                                    PODPIS => 'PODPIS',
                                    ETYKIETA => 'ETYKIETA',
                                    OTHER_ROLE=>'INNA'), 
                            'default' => NULL //
                        ),
			'roletxt'=>	array(
								'label' => false,
								'div' => false,
								'disabled' => false,
								'required' => false
                            ),
            'rodo'  =>  array(
                'label' => false,
                'div' => false
            ),
			'file'=>	array( 
								'label' => 'NOWE PLIKI:',
							 	//'div' => array('required' => ''),
								'type' => 'file',
								'required' => false,
								'multiple'
								//'options' => array('1'=>'STANDARD PVC', '2'=>'BIO PVC', '3'=>'TRANSPARENT'), 
								//'default' => 0 
							)
																																						
		); 	
	

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'role' => array(
			//'rule' => array('comparison', '!=', 0),
			'rule' => 'notEmpty'
			//'message' => 'WYBIERZ COŚ!'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			
		),
		'filename' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filesize' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filemime' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	
	


}
