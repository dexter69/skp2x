<?php
App::uses('Component', 'Controller');

/**
 * Permission Component
 *
 * Komponent zarządzający uprawnieniami użytkowników w aplikacji.
 *
 * @package    app.Controller.Component
 * @property   Controller $Controller
 * @property   AuthComponent $Auth
 * @property   SessionComponent $Session
 * @property   array $_permissions
 */

class PermissionComponent extends Component {
    public $components = array('Auth', 'Session');

    /**
     *  WAŻNE !!!!!
     *  Ta właściwość musi być prawidłowo ukształtowana !!!
     *  Przechowuje uprawnienia zalogowanego użytkownika.  */
    private $_permissions = ['_allowed_by_default' => false];

    public function initialize(Controller $controller) {

        // Zapisujemy referencję do bieżącego kontrolera w $this->Controller w celu możliwości późniejszego użycia w custom methods.
        $this->Controller = $controller;

        // Zalogowany użytkownik;
        $this->_user = $this->Auth->user();

        // Ładujemy uprawnienia użytkownika, jeżeli jest objęty nowym systemem uprawnień.
        $this->_loadPermissions();        
    }

    public function startup(Controller $controller) {

        // Użytkownik sprawdzany jest w starym systemie => kończymy pracę.
        if( $this->_isOnOLDsystem() ) return;

        // Pobierz nazwę zasobu w formacie: controller_action
        $resource = $this->_buildResourceName();

        // Pobierz listę wykluczonych (ze sprawdzania) akcji z konfiguracji
        $excludedActions = Configure::read('Permissions.excludedActions');

        // Pomiń sprawdzanie dla wykluczonych akcji
        if (in_array($resource, $excludedActions)) return;
        
        if (!$this->_check($resource, 1)) {
            $controller->Session->setFlash("Brak uprawnień do wykonania tej akcji ( PermissionComponent: {$resource} )");
            return $controller->redirect(array('controller' => 'orders', 'action' => 'index'));                
        }
        
    }

    // Ładuje uprawnienia użytkownika z bazy danych
    private function _loadPermissions() {

        // Nie ładujemy danych dla użytkownika sprawdzanego w starym systemie.
        if ($this->_isOnOLDsystem()) return false;

        // Sprawdź czy uprawnienia są już w sesji
        if ($this->Session->check('Auth.User.Permissions')) {
            $this->_permissions = $this->Session->read('Auth.User.Permissions');
            return true;
        }

        $dane = $this->_getDataFromDB();

        // Gdy użytkownik nie jest przypisany do żadnej grupy lub byłby przypisany do grupy, która nie istnieje (błąd w bazie danych).
        if ( empty($dane) ) return false;

        $permissions = $dane['Permission'];
        $group = $dane['Group'];
        
        // Przetwórz wyniki do łatwiejszego formatu
        if( !empty($permissions) ) {
            foreach ($permissions as $permission) {
                $resource = $permission['resource'];
                $level = $permission['permission_level'];

                $this->_permissions[$resource] = $level;
            }
        }
        
        if ( array_key_exists('allowed_by_default', $group) ) {
            $this->_permissions['_allowed_by_default'] = (bool)$group['allowed_by_default'];
        }
         
        // Zapisz uprawnienia w sesji dla szybszego dostępu
        $this->Session->write('Auth.User.Permissions', $this->_permissions);
        
        return true;
    }

    private $_user;

    // Czy użytkownik jest na NOWYM systemie uprawnień ?
    public function isOnNEWsystem() { return !empty($this->_user['group_id']); }

    // Czy użytkownik jest na STARYM systemie uprawnień ?
    private function _isOnOLDsystem() { return empty($this->_user['group_id']); }

    // Zbuduj nazwę zasobu w formacie: controller_action
    private function _buildResourceName() { return strtolower($this->Controller->name) . '_' . $this->Controller->action; }

    /**
     * Pobiera z bazy permissins dla grupy oraz dane grupy
     * 
     * @return array Tablica z danymi lub pusta tablica gdy brak danych
     */
    private function _getDataFromDB() {

        $Group = ClassRegistry::init('Group');
        // Upewniamy się, że model Group używa zachowania Containable, co by nam Cake skonstruował query join i zasysnął permissions też
        $Group->Behaviors->load('Containable');
        $dane = $Group->find('first', array(
            'conditions' => array('Group.id' => $this->_user['group_id']),
            'fields' => array('Group.id', 'Group.allowed_by_default'),
            'contain' => array(
                'Permission' => array(
                    'fields' => array('resource', 'permission_level')
                )
            )
        ));

        // Cake powinien nam zwrócić prawidłowo ustrukturyzowaną tablicę, ale tak na wszelki wypadek.
        if ( !empty($dane) )  {
            if ( !array_key_exists('Permission', $dane) ) $dane['Permission'] = [];
            if ( !array_key_exists('Group', $dane) ) $dane['Group'] = [];
        }
        return $dane;
    }

    // Sprawdza czy użytkownik ma uprawnienia do danego zasobu
    private function _check($resource, $requiredLevel = 1) {
        
        // Sprawdź czy zasób jest jawnie zdefiniowany
        if (isset($this->_permissions[$resource])) {            
            return $this->_permissions[$resource] >= $requiredLevel;
        }
        // Jeśli nie, użyj domyślnej wartości dla grupy
        return $this->_permissions['_allowed_by_default'];
    }

    ##########################
    // Jeszcze tego nigdzie nie używamy 

    // Pobiera poziom uprawnień dla danego zasobu
    public function getLevel($resource) {
        if (isset($this->_permissions[$resource])) {
            return $this->_permissions[$resource];
        }
        return 0;
    }
    
}