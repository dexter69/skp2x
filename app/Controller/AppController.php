<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
    public $helpers = array('Form', 'Html', 'Ma');
    
    public $components = array(
	'RequestHandler',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'orders', 'action' => 'index'),
            //'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
           'logoutRedirect' => array('controller' => 'orders', 'action' => 'index')
        )
    );
    
    /* Predefiniowane ilości kart w batonie */
    public $batons = array(
        'max' => 500,
        'indmax' => '500', // indeks wartości max w tablicy 'rodzaje'
        'rodzaje' => array(
            '500' => 500,
            '250' => 250,
            '200' => 200,
            '150' => 150,
            '100' => 100
        ),
        // dodajemy dane do pudeł zbiorczych
        'parcel' => array(
                'rodzaje' => array(
                        '5' => 5000,
                        '3' => 3000,
                        '2,5' => 2500,
                        '2' => 2000,
                        '1' => 1000
                ), // trochę zakręcone - wartości jw, ale klucze te same, co dla batonów,
                // by utwozyć powiązanie do UI poprzez klucze dla batonów
                'conected2bat' => array(
                        '500' => 5000,
                        '250' => 3000,
                        '200' => 2500,
                        '150' => 2000,
                        '100' => 1000
                )   
        )
    );
	
    public function beforeFilter() {

        $this->set('juzer', $this->Auth->User('name') );
        $this->set('departament', $this->Auth->User('dzial') );
    }
    
    
    // Sprawdzamy, czy wśród załączonych plików jest plik etykiety
    public function parseUploads( $uploads = array() ) {
        //$uploads - tablica z plikami
        foreach( $uploads as $row ) {
            if( $row['role'] == ETYKIETA) {
                // karta zawiera plik do etykiet, kończymy i zwracamy id uploadu
                return $row['id']; 
            }
        }
        return false;
    }
    
    
    /*
     *  DEPREC ##############################################
     */
    
    // 
    // do sterowania aktywną pozycją w navbarze
    //
    public $navbar = array(
        'customers' => array(
            'index' => false,
            'add' => false
        ),
        'cards' => array(
            'index' => false,
            'add' => false
        ),
        'orders' => array(
            'index' => false,
            'add' => false
        ),
        'jobs' => array(
            'index' => false,
            'add' => false
        )
    );
    
    public $navLiClasses = array('', '', '', '', '', '', '', '', '', '');
    
    // ustaw $navLiClasses tak by navbar był wyrysowany prawidłowo
    public function setNav( $ind1 = null, $ind2 = null) {
        
        if( !array_key_exists( $ind1, $this->navbar ) || !array_key_exists( $ind2, $this->navbar[$ind1] )   ) {
            return;
        }
        $this->navbar[$ind1][$ind2] = true;
        $this->navLiClasses = array();
        foreach( $this->navbar as $kontroler) {
            foreach( $kontroler as $value ) {
                if( $value ) {
                    $this->navLiClasses[] = 'class="active"';
                } else {
                    $this->navLiClasses[] = '';
                }
            }
        }
    }
    
    // convert base nr to nrh - numer handlowego
    public function bnr2nrh2($bnr = null, $inicjaly = null, $ishtml = true, $sepyearchar = '/') {

            if($bnr && $bnr > BASE_NR) {
                    if( $ishtml ) {
                            $startspan = '<span class="ordernr">';
                            $stopspan = '</span>';
                    } else {
                            $startspan = $stopspan = null;
                    }
                    if( $inicjaly ) {
                            //return ($bnr - BASE_NR).$startspan.'/'.BASE_YE.' '.$inicjaly.$stopspan;
                            return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).' '.$inicjaly.$stopspan;
                    } else   {
                            //return ($bnr - BASE_NR).$startspan.'/'.BASE_YE.' H'.$stopspan;
                            return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).' H'.$stopspan;
                    }
            } else { 
                return $bnr; 
            }

    }	
	
    // convert base nr to nrj - numer job'a
    public function bnr2nrj2($bnr = null, $inicjaly = null, $ishtml = true, $sepyearchar = '/') {

            if($bnr && $bnr > BASE_NR) {
                    if( $ishtml ) {
                            $startspan = '<span class="ordernr">';
                            $stopspan = '</span>';
                    } else 
                            $startspan = $stopspan = null;
                    //return ($bnr - BASE_NR).'/'.BASE_YE;
                    //return ($bnr - BASE_NR).$startspan.'/'.BASE_YE.$stopspan;
                    return (int)substr((int)$bnr,2).$startspan.$sepyearchar.substr((int)$bnr,0,2).$stopspan;
            } else
                    return $bnr;
    }

    public $links = array(
        aCUS_ADD, aCUS_LIST,
        aCARD_ADD, aCARD_LIST,
        aORD_ADD, aORD_LIST,
        aJOB_ADD, aJOB_LIST,
        //aUSER_ADD, aUSER_LIST
    );
	
	
    public function actionAllowed() {

            $uid = $this->Auth->user('id');
            $dzial = $this->Auth->user('dzial');
            $kontroler = $this->params['controller'];
            $akcja = $this->action;
            if( empty($this->params['pass']) ) $par = null;
            else
                    $par = $this->params['pass'][0];

            $this->links = array();


            switch($kontroler) {
                    case 'customers':
                            switch($akcja ) {
                                    case 'index':
                                            switch($par) {
                                                    case 'my':
                                                            switch($dzial ) {
                                                                    case MAR:
                                                                            $this->links = array(
                                                                                    aCUS_ADD, aCARD_ADD,
                                                                                    aCARD_LIST, aORD_ADD, aORD_LIST,
                                                                                    aJOB_LIST);
                                                                            break;
                                                                    case SUA:
                                                                            $this->links = array(
                                                                                    aCUS_ADD, aCARD_ADD,
                                                                                    aCARD_LIST, aORD_ADD,
                                                                                    aORD_LIST, aJOB_ADD,
                                                                                    aJOB_LIST//, aUSER_ADD, aUSER_LIST
                                                                                    );
                                                                            break;
                                                            }
                                                            break;
                                                    case null:
                                                            switch($dzial ) {
                                                                    case MAR:
                                                                            $this->redirect( array('action' => 'index','my') );
                                                                            break;
                                                                    case SUA:
                                                                            $this->links = array(
                                                                                    aCUS_ADD, aCARD_ADD,
                                                                                    aCARD_LIST, aORD_ADD,
                                                                                    aORD_LIST, aJOB_ADD,
                                                                                    aJOB_LIST//, aUSER_ADD, aUSER_LIST
                                                                            );
                                                                            break;
                                                            }
                                                            break;
                                                    default:
                                                            $this->redirect( array('action' => 'index') );
                                            }
                                            break;
                                    case 'view':
                                            $this->links = array(
                                                    aCARD_ADD, aCARD_LIST,
                                                    aORD_ADD, aORD_LIST,
                                                    aJOB_ADD, aJOB_LIST,
                                                    nCUS_LIST, nCUS_ADD, nCUS_EDIT, nCUS_DEL							
                                            );	
                                            switch($dzial ) {
                                                    case MAR:
                                                            unset($this->links[4]);
                                                            break;
                                                    case SUA:
                                                            break;
                                                    default:
                                                            unset(	$this->links[4], $this->links[7],  $this->links[8],
                                                                            $this->links[9]);
                                                            break;
                                            }
                                            break;	
                                    case 'add':
                                            $this->links = array( aCUS_LIST, aCARD_ADD, aCARD_LIST, 
                                                                                            aORD_ADD, aORD_LIST, aJOB_ADD, aJOB_LIST );
                                            break;
                                    case 'edit':
                                            $this->links = array(
                                                    aCARD_ADD, aCARD_LIST,
                                                    aORD_ADD, aORD_LIST,
                                                    aJOB_ADD, aJOB_LIST,
                                                    nCUS_LIST, nCUS_ADD							
                                            );
                                            switch($dzial ) {
                                                    case MAR:
                                                            unset($this->links[4]);
                                                            break;
                                                    case SUA:
                                                            break;
                                                    default:
                                                            unset(	$this->links[4], $this->links[7]);
                                                            break;
                                            }
                                            break;
                            }
                            break;
                    case 'cards':
                            switch($akcja ) {
                                    case 'index':
                                            switch($par) {
                                                    case null:
                                                            switch($dzial ) {
                                                                    case SUA:
                                                                            $this->links = array(
                                                                                    aCUS_ADD,
                                                                                    aCARD_ADD,
                                                                                    aCARD_LIST,
                                                                                    aORD_ADD, aORD_LIST,
                                                                                    aJOB_ADD,
                                                                                    aJOB_LIST//, aUSER_ADD, aUSER_LIST
                                                                            );
                                                                            break;
                                                                    case MAR:
                                                                            $this->redirect( array('action' => 'index','my') );
                                                                            break;
                                                            }
                                                            break;
                                                    case 'my':
                                                            switch($dzial ) {
                                                                    case MAR:
                                                                            $this->links = array(
                                                                                    aCUS_ADD,
                                                                                    aCUS_LIST,
                                                                                    aCARD_ADD,
                                                                                    aORD_ADD, aORD_LIST,
                                                                                    aJOB_LIST);
                                                                            break;
                                                                    case SUA:
                                                                            $this->links = array(
                                                                                    aCUS_ADD,
                                                                                    aCUS_LIST,
                                                                                    aCARD_ADD,
                                                                                    aORD_ADD, aORD_LIST,
                                                                                    aJOB_ADD,
                                                                                    aJOB_LIST//, aUSER_ADD, aUSER_LIST
                                                                                    );
                                                                            break;
                                                            }
                                                            break;
                                            }
                                    break;
                                    case 'view':
                                            switch($dzial ) {
                                                    case MAR:
                                                            $this->links = array(
                                                                    aCUS_ADD, aCUS_LIST,
                                                                    aCARD_ADD, aCARD_LIST,
                                                                    aORD_ADD, aORD_LIST, aJOB_LIST,
                                                                    nCARD_ADD, nCARD_LIST, nCARD_EDIT, nCARD_DEL);
                                                            break;
                                                    case SUA:
                                                            $this->links = array(
                                                                    aCUS_ADD, aCUS_LIST,
                                                                    aCARD_ADD, aCARD_LIST,
                                                                    aORD_ADD, aORD_LIST,
                                                                    aJOB_ADD, aJOB_LIST,
                                                                    nCARD_ADD, nCARD_LIST, nCARD_EDIT, nCARD_DEL);
                                                                    //aUSER_ADD, aUSER_LIST

                                                            break;
                                            }
                                            break;	
                                    break;
                            }
                            break;
                    case 'orders':
                            switch($akcja ) {
                                    case 'add':
                                            $this->links = array(
                                                                    aCUS_ADD, aCUS_LIST,
                                                                    aCARD_ADD, aCARD_LIST,
                                                                    aJOB_ADD, aJOB_LIST,
                                                                    nORD_LIST//nORD_DEL, nORD_ADD, nORD_EDIT,
                                                                    );
                                            break;
                                    case 'view':
                                            $this->links = array(
                                                                    aCUS_ADD, aCUS_LIST,
                                                                    aCARD_ADD, aCARD_LIST,
                                                                    aJOB_ADD, aJOB_LIST,
                                                                    nORD_LIST, nORD_ADD, nORD_EDIT, nORD_DEL//, 
                                                                    );
                                            break;
                            }
                            break;
            }
    }
	
}
