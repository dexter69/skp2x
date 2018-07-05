<?php

                    $caseNR = $this->Customer->validateNIP( $this->request->data );                                        
                    switch( $caseNR ) { // egzaminujemy rezultat sprawdzania NIP'u
                        case 0: //wsio OK
                                $this->Customer->create();
                                if ($this->Customer->saveAssociated($this->request->data)) {                                
                                        return $this->redirect(array('action' => 'view', $this->Customer->id));
                                } else {					
                                        $this->Session->setFlash( ('Nie udało się zapisać. Proszę, spróbuj ponownie.') );
                                }
                                break;
                        case 1: // nieprawidłowy format
                                $this->Session->setFlash( ('Wpisany NIP ma nieprawidłowy format!') );
                                break;
                        case 2: // taki nip już istnieje
                                $name = $this->request->data['result']['Customer']['name'];
                                $cuid = $this->request->data['result']['Customer']['id'];
                                $url = Router::url(array('controller'=>'customers', 'action'=>'view', $cuid));
                                $this->Session->setFlash('Klient z tym numerem NIP-u już istnieje <a href="' . $url . '">' . $name . '</a>');
                                break;
                        default:
                                $this->Session->setFlash('Nieznany błąd. Zapytaj Darka, jeżeli tu jeszcze pracuje.');
                    }