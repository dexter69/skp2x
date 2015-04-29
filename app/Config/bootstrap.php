<?php
define('DEVEL', false);    // coby sterować różnymi rzeczami
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));


/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Konfiguracja pod wkhtmltopdf - skopiowane ze starego
 */

CakePlugin::load('CakePdf', array('bootstrap' => true, 'routes' => true));


Configure::write('CakePdf', array(
        'engine' => 'CakePdf.WkHtmlToPdf',
		
        'options' => array(
            'print-media-type' => true,
            'outline' => true,
            'dpi' => 96,
            'disable-smart-shrinking' => true
        ),
        /**/
        //'orientation' => 'portrait',//'landscape',
        'download' => true  ,
	//'filename' => 'example.pdf'	
    ));

if( DEVEL ) { Configure::write('CakePdf.binary', 'C:\wkhtmltopdf\bin\wkhtmltopdf.exe'); }
else { Configure::write('CakePdf.binary', '/usr/bin/wkhtmltopdf'); }

//Configure::write('CakePdf.binary', 'C:\wkhtmltopdf\bin\wkhtmltopdf.exe');
//Configure::write('CakePdf.binary', '/usr/bin/wkhtmltopdf');



/**
 * GLOBALNE STAŁE
 * 
 */

//UŻYJEMY zamiast DEVEL
define('LIN', "/");
define('WIN', "\\");

//MATERIAŁ KART
define('PVC', 1);    // STANDARD PVC
define('BIO', 2);    // BIO PVC
define('TRA', 3);    // TRANSPARENT PVC    

//FARBY NA SITO    
define('IN', 1);    // INNY KOLOR
define('S3', 2);    // SREBRO 303
define('Z2', 3);    // ZŁOTO 3002
define('Z3', 4);    // ZŁOTO 3003
define('P3', 6);    // PERŁA 38001
define('P4', 7);    // PERŁA 44001
define('BI', 8);   // BIAŁE SIOTO
//define('WB', '<span class="glyph-nozyczki"></span>');   // Wybranie
//'<span class="glyph-nozyczki"></span>'

//LAMINAT
define('BL', 2);    // LAMINAT BŁYSZCZĄCY
define('GL', 3);    // LAMINAT GŁADKI
define('CH', 4);    // LAMINAT GŁADKI

//PASEK MAGNETYCZNY
define('HICO', 1);    // HiCo
define('LOCO', 2);    // HiCo
 
/**
* 	 Model Order
*/

//Kalekie konstruowanie linku do e-maili, użyte w eventscontroller
define('HOSCIK', 'apacz');

//FLASH messages
define('GOOD_FLASH', 'ziel_flash');

//PLIKI
define('PLIKOZA', 'uploads');
define('KOSZ', 'kosz');

//uniwersalne
define('ZIRO', 0);
define('NIE', 0);
define('BRAK', 0);
define('PAU', 99);
define('JEDEN', 1);
define('TAK', 1);
define('LAC', 1); //look at comments

//Do wielkości plików
define('KILO', 1024);
define('MEGA', 1048576); // 1024 x 1024

//Czas wykonania zlecenia
define('ORD_TIME', 12);

//Formy płatności, 0 i 1 uniwersalne
define('PRZE', 2); //przelew
define('CASH', 3); //gotówka
define('POB', 4);  //pobranie	

//Domyślne stałe płatności
define('PAY_FORM', 0);
define('PAY_TIME', 0);
define('DEF_PAY_FORM', BRAK);
define('DEF_PAY_TIME', 7);
define('DEF_ZAL_FORM', PRZE);
define('DEF_ZAL_PROC', 100); //

//baza do numerów zleceń
define('NR_SUFIX', '14');
define('BASE_NR', 1400000);
define('BASE_ZERO', '00000');
define('FIRST_ORDER_NR', 1400001);
define('FIRST_JOB_NR', 1400701);
define('BASE_YE', 14);

//sposób dostawy
define('NAF', 0);
define('IA', 2);
define('OO', 3);

//Działy/grupy urzytkowników
define('SUA',0); //superadmin
define('ADM',9); //admin
define('MAR',1); //marketing
define('KOR',2); //koordynator
define('KIP',3); //kierownik produkcji (Becia)
define('DTP',4); //dtp - Marek
define('PER',5); //peronalizacja

//KARTY

// Wzorzec używany do stworzenia pierwotnego ciągu html, który poszukuje
// javascript przy generowniu pól do wczytanych plików
define('PATT','999');


//role załącznych plików
define('OTHER_ROLE', 1);
define('PROJ', 2);
define('BAZA', 3);
define('PODPERSO', 4);
define('PODGLAD', 5);


//Job
//Rodzaj arkusza
define('BIG_SHEET', 21); // OSOBNO
define('SMALL_SHEET', 9); // PRZEWROTKA
define('OTHER_SHEET', 77); // PRZEWROTKA




//Linki sterujące/actions
define('aUSER_ADD', 2);		// nowy użytkownik
define('aUSER_LIST', 3);	// lista użytkowników

define('aCUS_ADD', 22);		// nowy klient
define('aCUS_LIST', 23);	// lista klientów
define('nCUS_ADD', -22);
define('nCUS_DEL', -23);	//kosz
define('nCUS_EDIT', -24);	//edytuj
define('nCUS_LIST', -25);	// lista zamówień gdy kontroler to orders

define('aCARD_ADD', 42);	// nowa karta
define('aCARD_LIST', 43);	// lista kart
define('nCARD_ADD', -42);
define('nCARD_DEL', -43);	//kosz
define('nCARD_EDIT', -44);	//edytuj
define('nCARD_LIST', -45);	// lista kart gdy kontroler to cards

define('aORD_ADD', 62);		// nowe zamówienie
define('aORD_LIST', 63);	// lista zamówień
define('nORD_ADD', -62);
define('nORD_DEL', -63);	//kosz
define('nORD_EDIT', -64);	//edytuj
define('nORD_LIST', -65);	// lista zamówień gdy kontroler to orders

define('aJOB_ADD', 82);		// nowe zlecenie
define('aJOB_LIST', 83);	// lista zleceń

//pasek do podpisu
define('TRAN', 2);
define('BIAL', 3);

// ####################### uprawnienia użytkowników

/*
	NAZWY KOLUMN W TABELI USERS
	
	OV - order view, uprawnienia do oglądania zamówienia
	OE - orders edit, uprawnienia do edycji zamówienia
	OX - orders index, uprawnienia listowania zamówień
	O_PUB - uprawnienia do publikacji zamówień
	O_KOM - uprawnienia do komentowania zamówień
	O_KOR - uprawnienia do działań koordynacyjnych na zamówieniach
	O_SEN - uprawnienia do "wysyłania"/zamykania zamówień (to co robi Krysia)
	CA_D - uprawnienia do akceptacji/odrzucania plików/projektó DTP
	CA_P - uprawnienia do akceptacji/odrzucania personalizacji
	CA_K - uprawnienia do pisania komentarzy pod kartami
	CAV - card view, uprawnienia do oglądania karty
	CAE - cards edit, uprawnienia do edycji karty
	CAX - cards index, uprawnienia do listowania kart
	JA - jobs add, uprawnienia do dodawana zleceń produkcyjnych
	JE - jobs edit, uprawnienia do edycji zleceń produkcyjnych
	JX - jobs index, uprawnienia do listowania zleceń produkcyjnych
*/

define('NO_RIGHT', 0); //brak uprawnień
define('HAS_RIGHT', 1); //ma uprawnienia

define('EDIT_OWN', 1); //edycja swoich
define('EDIT_SHR', 2); //edycja wspólnych
define('EDIT_ALL', 7); //edycja wszystkich
define('EDIT_SAL', 9); //edycja super wszystkich 

define('VIEW_OWN', 1); //ogladanie swoich
define('VIEW_SHR', 2); //ogladanie wspólnych
define('VIEW_NO_KOR', 3);  // jak NO_PRIV, ale bez kart/zamówień widocznych dla koordynatora
define('VIEW_NO_PRIV', 5); /* ogladanie wszystkich za wyjątkiem prywatnych zamówień innych ludzi
						 dla kart: wszystkie karty za wyjątkiem samotnych
						   lub podpiętych do prywatnych zleceń innych ludzi 
						*/
define('VIEW_ALL', 7); //ogladanie wszystkich
define('VIEW_SAL', 9); //ogladanie super wszystkich

define('IDX_OWN', 1); //listowanie swoich
define('IDX_SHR', 2); //listowanie wspólnych (i swoich)
define('IDX_NO_KOR', 3);  // IDX_NO_PRIV, ale bez kart/zamówień widocznych dla koordynatora początkowo
define('IDX_NO_PRIV', 5); 
						/* listowanie wszystkich za wyjątkiem prywatnych zamówień innych ludzi
						   lub (w przypadku kart) listowanie wszystkich za wyjątkiem samotnych
						   lub podpiętych do prywatnych zleceń innych ludzi 
						 */
define('IDX_ALL', 7); //listowanie wszystkich
define('IDX_SAL', 9); //listowanie super wszystkich

//events - r - right
//uniwersalne
define('r_OWN', 1); //uprawnienie do działań na swoich zamówieniach/kartach
define('r_NOP', 5); //uprawnienie do działań na kartach bez perso
define('r_ALL', 7); //uprawnienie do działań na wszystkich zamówieniach/kartach
define('r_SAL', 9); //uprawnienie do działań na super wszystkich zamówieniach/kartach

define('rPUBLI_OWN', 1); //publikacja swoich zamówień
define('rPUBLI_ALL', 7); //publikacja wszystkich zamówień
define('rPUBLI_SAL', 9); //publikacja super wszystkich zamówień

// #################################################
//Stałe for events / submits

// dla job - stare


define('eJ_FILE', 23); // Marek wykonał pliki produkcyjne


//define('eDTP_REJ', 24);  Marek odrzucił (ma nieprawidłowe lub niekompletne dane)

//define('eKOR_POP', 25);  Adam/Jola poprawił
define('eREJ_F', 26); // Koordynator odzrucił pliki DTP
define('ePUSH2B', 27); // Przekazanie pani Beci do 
define('eB_REJ', 28); // Becia odrzuca
define('eB_REJ2KOR', 29); // Becia odrzuca do koordynatora
define('eB_REJ2DTP', 30); // Becia odrzuca do Marka

define('eK_POP4B', 32); // Adam/Jola poprawił dla Beci
define('eK_PUSHDTP', 33); // Adam/Jola przekazał do Franka



define('sDAFC', 3);		// DTP ask for correct - Marek czeka na korekte

define('sHAS_F', 4);	// Job z plikami od Marka


define('sASKOR', 6); 	// Czeka na poprawe przez kor.
define('sASKDTP', 7); 	// Czeka na poprawe przez Franka

define('sB_REJ', 11); 	// Odrzucone przez Becie



//Statusy zamówień(orders), kart (cards) i zleceń(jobs)

define('ABSURD', 254); // c, o, j - roboczy
define('PRIV', 0); // c i o
define('NOWKA', 1); // c i o

define('W4D', 51); // c
define('W4DP', 52); // c
define('W4DPNO', 53); // c
define('W4DPOK', 54); // c
define('W4PDNO', 55); // c
define('W4PDOK', 56); // c
define('DOK', 57); // c
define('DNO', 58); // c
define('DOKPNO', 59); // c
define('DOKPOK', 60); // c
define('DNOPNO', 61); // c
define('DNOPOK', 62); // c
define('R2BJ', 31); //c - po akceptacji zamówienia(O_ACC), gotowa do podpięcia do JOB'a

define('JOBED',41); // c karta została podpięta do zlecenia (JOB)
define('W_PROD',42); // c w produkcji

define('O_ERR', 63); // o
define('O_FINE', 64); // o
define('O_REJ', 65); // o
define('O_ACC', 66); // o
define('FIXED', 67); // o
define('W4UZUP', 68); // o - czeka na uzupełnienie
						//	- handlowiec może edytować karty i zamówienie
define('UZUPED', 69); // o, po naciśnięciu "UZUPEŁNIONE" przez handlowca
define('UZU_CHECK', 70); // o, po uzupełnieniu Jola skierowała do sprawdzenia DTP/P
define('UZU_REJ', 71); // o - odrzucona jakaś karta w procesie sprawdzania uzupełnionego zamówienia

define('KONEC', 77); // o, c, j


/* ?? */
define('KREJ1', 2); // o
define('KREJ2', 3); // o
define('FIXED1', 4); // o
define('FIXED2', 5); // o
define('W4CARD', 6); // o
//define('W4D', 7); // c
define('W4P', 8); // c
define('DREJ', 9); // c
define('PREJ', 10); // c
define('OREJ', 11); // o
define('D_OK', 12); // c
define('P_OK', 13); // c
define('F_OK', 14); // o
define('ORD_OK', 15); // o



//zdarzenia na kartach i zamówieniach
define('ZERO', 0); // nic
define('publi', 1); // o
define('kor_no', 14); // o
define('kor_ok', 15); // o
define('d_no', 6); // c
define('p_no', 7); // c
define('d_ok', 8); // c
define('p_ok', 9); // c
define('put_kom', 13); // o i c - komentarz
define('fix_o', 16); // o i c
define('send_o', 17); // o , zaznacz że wysłane (u klienta)
define('unlock_o', 18); // o, odblokuj zamówienie
define('update_o', 19); // o, po uzupełnieniu handlowiec wciska
//zdarzenia generowane przez Jolę na uzupełnionym zamówieniu / karcie
define('unlock_again', 20); // czyli uzupełnione źle, z powrotem do handlowca
define('klepnij', 23); // jest ok wrcamy do produkcji
define('push4checking', 24); // daj Frankowi i/lub Adamowi do sprawdzenia

define('kor_no1', 2); // o
define('kor_ok1', 3); // o
define('kor_no2', 4); // o
define('kor_ok2', 5); // o

define('fix_k', 10); // c
define('fix_o1', 11); // o
define('fix_o2', 12); // o

/**/




// again - statusy i events dla zleceń

//Statusy zleceń (jobs)
define('sPRIVJ', 0);	// j prywatne/robocze Joli lub Adama
define('sDTP_REQ', 2);	//czeka na pliki od Marka
define('sHAS_F1', 21);	// Job z plikami od Marka (dla Joli)
define('sDTP2FIX', 22);	// Pliki są do poprawy
define('sW4B', 23);		// Czeka na sprawdzenie przez BECIE
define('sHAS_F2', 24);	// Job z plikami od Marka ponownie (dla Joli)
define('sDTP2FIX2', 25);	// Pliki są do poprawy (cofneła Becia)
define('sKOR2FIX', 26);	// Coś do poprawy przez koordynatora (cofneła Becia)
define('sW4B2', 27);		// Czeka na sprawdzenie przez BECIE ponownie (po poprawce Franka)
define('sJ_PROD', 28); 	// Job w produkcji
define('sPAUSE4K', 29); // W produkcji, ale cofnięte do koordynatora
define('sPAUSE4D', 30); // W produkcji, ale cofnięte do dtp
define('sBACK2B', 31); // Spauzowane, poprawione, czeka na decyzje Beci


//zdarzenia
define('eJPUBLI',21); // publikacja zlecenia
define('eJKOM',22); // wystawiono komentarz do zlecenia
define('eJ_FILE1', 41); // Frank wykonał pliki produkcyjne (wstępnie dla Joli)
define('eJF_BACK', 42); // Jola zwróciła - plik/i do poprawy
define('eJF_OK', 43); // Jola zaakceptowała pliki
define('eJ_FILE2', 44); // Frank wykonał pliki produkcyjne (ponownie dla Joli)
define('eJ_B2KOR', 45); // Becia odrzuca do koordynatora
define('eJ_B2DTP', 46); // Becia odrzuca do DTP
define('eJ_FILE3', 47); // Frank poprawia/przekazuje do Beci
define('eJ_KOR2B', 48); // Jola poprawiła i przesłała do Beci
define('eJ_KOR2DTP', 49); // Jola przesłała do Franka
define('eJ_ACC', 50); // Becia akceptuje
define('eJ_COF2KOR', 51); // Becia cofa do Joli zlecenie będące w produkcji (jkaiś problem)
define('eJ_COF2DTP', 52); // Becia cofa do Franka zlecenie będące w produkcji (jkaiś problem)
define('eJ_KBACK', 53); //Jola z powrotem do Beci (po poprawie)
define('eJ_DBACK', 54); //Frank z powrotem do Beci (po poprawie)
define('eJB_UNPAUSE', 55); //Becia OK'ła


