<?php
/**
 * Taki dziwny model potrzebny do Pulpit'u
 */
App::uses('AppModel', 'Model');

class Webix extends AppModel {

    public $useTable = 'users';       

    public function listaHandlowcowDoPulpitu() {

        $data = $this->find('all', [
            'fields' => ['id', 'name', 'pulpit'],
            'conditions' => ['pulpit' => 1],
            'order' => 'name'
        ]);

        return $this->transformPulpit($data);
    }

    private function transformPulpit( $data ) {

        $transformed = [
            ['id' => 0, 'value' => 'Wszyscy']
        ];

        foreach( $data as $key => $value ) {
            $transformed[] = [
                'id' => $value['Webix']['id'],
                'value' => $value['Webix']['name']
            ];
        }

        return $transformed;
    }
    
}