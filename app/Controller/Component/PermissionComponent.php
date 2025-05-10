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
    
    // Tablica przechowująca uprawnienia zalogowanego użytkownika
    protected $_permissions = array();
    
    public function initialize(Controller $controller) {
        $this->Controller = $controller;
        // Ładuj uprawnienia użytkownika po zalogowaniu
        if ($this->Auth->user()) {
            $this->_loadPermissions();
        }
    }
    
    // Ładuje uprawnienia użytkownika z bazy danych
    protected function _loadPermissions() {
        $user = $this->Auth->user();
        if (empty($user['group_id'])) {
            return false;
        }
        
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
            return $this->_permissions[$resource] >= $requiredLevel;
        }
        return false;
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