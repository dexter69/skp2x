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
     * Zmienna definiująca podstawowy model zachowania uprawnień.
     * - false => wszystko co wprost nie jeste dozwolone (zdefiniowane w tabeli permissions), jest zabronione => default RESTRICTED
     * - true => wszysstko, co nie jest wprost uregulowane ( w tabeli permissions ), jest dozwolone => default ALLOWED.
     * Zmienna jest ustawiana w trakcie ładowania uprawnień przez metodę _loadPermissions().
     * Przyjmuje wartość zdefiniowaną w kolumnie `allowed_by_default` tabeli `groups`     */
    private $_undefinedAllowed = false;

    // Lista akcji/kontrolerów, które nie wymagają sprawdzania uprawnień
    private $_excludedActions = array(                
        'users_login',
        'users_logout',
        // tmp
        'orders_index',
        // sprawdzić to jest ajax , wywoływane np. w orders index, po co
        'orders_prepaid'
    );

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

        // Pomiń sprawdzanie dla wykluczonych akcji
        if (in_array($resource, $this->_excludedActions)) return;

        if (!$this->_check($resource, 1)) {
            $controller->Session->setFlash("Brak uprawnień do wykonania tej akcji ( PermissionComponent: {$resource} )");
            return $controller->redirect(array('controller' => 'orders', 'action' => 'index'));                
        }
        
    }

    private $_user;

    // Zbuduj nazwę zasobu w formacie: controller_action
    private function _buildResourceName() { return strtolower($this->Controller->name) . '_' . $this->Controller->action; }


    // Czy użytkownik jest na NOWYM systemie uprawnień ?
    public function isOnNEWsystem() { return !empty($this->_user['group_id']); }

    // Czy użytkownik jest na STARYM systemie uprawnień ?
    private function _isOnOLDsystem() { return empty($this->_user['group_id']); }

    // Ładuje uprawnienia użytkownika z bazy danych
    protected function _loadPermissions() {

        // Nie ładujemy danych dla użytkownika sprawdzanego w starym systemie.
        if ($this->_isOnOLDsystem()) { return false; }

        
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

        /** Zabezpieczamy się przed błędem w bazie danych. Gdyby użytkownik był przypisany do grupy, która nie istnieje.
         * W takim scenariuszu, nie dajemy mu żadnych uprawnień - $this->_undefinedAllowed domyślnie jest false */
        if ( empty($dane) ) { return false; }

        $permissions = $dane['Permission'];
        $group = $dane['Group'];

        if( !empty($permissions) ) {
            // Zdefiniowano jakieś permissions => załadujmy je
            foreach ($permissions as $permission) {
                $this->_permissions[$permission['resource']] = $permission['permission_level'];
            }
        }

        // W sytuacji, gdy nie zdefiniowano żadnych permissions, zostanie użyte default permission grupy.
        $this->_undefinedAllowed = $group['allowed_by_default'];
         
        // Opcjonalnie: zapisz uprawnienia w sesji dla szybszego dostępu
        $this->Session->write('Auth.User.Permissions', $this->_permissions);
        
        return true;
    }

    // Tablica przechowująca uprawnienia zalogowanego użytkownika
    private $_permissions = array();

    // Sprawdza czy użytkownik ma uprawnienia do danego zasobu
    private function _check($resource, $requiredLevel = 1) {
        if (isset($this->_permissions[$resource])) {
            // mamy zdefiniowane uprawnienie dla tego zasobu
            return $this->_permissions[$resource] >= $requiredLevel;
        }
        // nie ma definicji dla tego zasobu, to co zwracamy, zeleży od $_undefinedAllowed
        return $this->_undefinedAllowed;
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