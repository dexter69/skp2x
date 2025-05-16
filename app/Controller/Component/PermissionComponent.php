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

    private $_newCheck = false;

    public function wasNewCheck() {
        return $this->_newCheck;
    }

    /**
     * Tu wrzucamy kod do sprawdzenia uprawnień. Dzięki metodzie startup (wywoływanej przez CakePHP) wszystko
     * dzieje się automatycznie. Wystarczy dodać komponent Permissions do AppController.     */
    public function startup(Controller $controller) {

        // Najpierw sprawdźmy, czy zalogowany użytkownik ma być sprawdzany w nowym systemie
        // Jeżeli nie, to nie kontynujemy pracy
        if ( !$this->userIsOnNewPermissionSystem() ) {
            return;
        }
        // Tak - chcemy zapisać, że sprawdzamy w nowym systemie, by kod starego nie robił ego po raz drugi.
        // $controller->_newCheck = true;
        $this->_newCheck = true;

        // Pobierz nazwę kontrolera i akcji
        $controllerName = strtolower($controller->name);
        $action = $controller->action;

        // Zbuduj nazwę zasobu w formacie: controller_action
        $resource = $controllerName . '_' . $action;

        // Lista akcji/kontrolerów, które nie wymagają sprawdzania uprawnień
        $excludedActions = array(                
            'users_login',
            'users_logout',
            // tmp
            'orders_index',
            // sprawdzić to jest ajax , wywoływane np. w orders index, po co
            'orders_prepaid'
        );

        // Pomiń sprawdzanie dla wykluczonych akcji
        if (in_array($resource, $excludedActions)) {
            return;
        }

        if (!$this->check($resource, 1)) {
                $controller->Session->setFlash('Brak uprawnień do wykonania tej akcji ( PermissionComponent ): ' . $resource);
                return $controller->redirect(array('controller' => 'orders', 'action' => 'index'));                
        }
    }

    /**
     * Zmienna definiująca podstawowy model zachowania uprawnień.
     * - false => wszystko co wprost nie jeste dozwolone (zdefiniowane w tabeli permissions), jest zabronione => default RESTRICTED
     * - true => wszysstko, co nie jest wprost uregulowane ( w tabeli permissions ), jest dozwolone => default ALLOWED     */
    private $_undefinedAllowed = false;

    // Tablica przechowująca uprawnienia zalogowanego użytkownika
    private $_permissions = array();

    public function initialize(Controller $controller) {
        $this->Controller = $controller;
        // Ładuj uprawnienia użytkownika po zalogowaniu
        if ($this->Auth->user()) {
            $this->_loadPermissions();
        }
    }

    /**
     * Zmienna przechowująca info o tym czy zalogowany użytkownik przynależy do nowego systemu uprawnień.
     * Sprawdzenie następuje w _loadPermissions() i wtedy zostaje ustawiona.     */
    private $_isOnNew = false;
    
    // Zwróć informację, czy użytkownik jest na nowym systemie uprawnień
    public function userIsOnNewPermissionSystem() {
        return $this->_isOnNew;
    }
    
    // Ładuje uprawnienia użytkownika z bazy danych
    protected function _loadPermissions() {
        $user = $this->Auth->user();
        
        if (empty($user['group_id'])) {
            return false;
        }
        // To znaczy, ze uzytkownik jest w nowym systemie, ustawmy zmienną
        $this->_isOnNew = true;

        $Permission = ClassRegistry::init('Permission');
        $permissions = $Permission->find('all', array(
            'conditions' => array('Permission.group_id' => $user['group_id']),
            'fields' => array('Permission.resource', 'Permission.permission_level')
        ));
        
        foreach ($permissions as $permission) {
            $this->_permissions[$permission['Permission']['resource']] = 
                $permission['Permission']['permission_level'];
        }
        
        // Opcjonalnie: zapisz uprawnienia w sesji dla szybszego dostępu
        $this->Session->write('Auth.User.Permissions', $this->_permissions);
        
        return true;
    }
    
    // Sprawdza czy użytkownik ma uprawnienia do danego zasobu
    public function check($resource, $requiredLevel = 1) {
        if (isset($this->_permissions[$resource])) {
            // mamy zdefiniowane uprawnienie dla tego zasobu
            return $this->_permissions[$resource] >= $requiredLevel;
        }
        // nie ma definicji dla tego zasobu, to co zwracamy, zeleży od $_undefinedAllowed
        return $this->_undefinedAllowed;
    }
    
    // Pobiera poziom uprawnień dla danego zasobu
    public function getLevel($resource) {
        if (isset($this->_permissions[$resource])) {
            return $this->_permissions[$resource];
        }
        return 0;
    }
    
    // Metoda kompatybilności ze starym systemem
    public function getLegacyPermission($field) {
        // Mapowanie starych pól na nowe zasoby
        $mapping = array(
            'OV' => 'orders_view',
            // Dodaj inne mapowania według potrzeb
        );
        
        if (isset($mapping[$field])) {
            return $this->getLevel($mapping[$field]);
        }
        
        return 0;
    }
}