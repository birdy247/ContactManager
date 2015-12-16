<?php

namespace ContactManager\Controller;

use ContactManager\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\ForbiddenException;
use Cake\Mailer\MailerAwareTrait;
use Cake\Event\Event;

/**
 * Contacts Controller
 *
 * @property \ContactManager\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Recaptcha.Recaptcha');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('contacts', $this->paginate($this->Contacts));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        $this->set('contact', $contact);
        $this->set('_serialize', ['contact']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $contact = $this->Contacts->newEntity();
        if ($this->request->is('post')) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contact could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    public function addAjax() {

        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                $contact = $this->Contacts->newEntity($this->request->data);
                if ($this->Contacts->save($contact)) {
                    $this->getMailer('ContactManager.Contact')->send('notify', [$contact]);
                    $response = "success";
                } else {
                    $response = "fail";
                }
            } else {
                throw new ForbiddenException('Unverified captcha');
            }

            $this->set(compact('response'));
            $this->set('_serialize', ['response']);
        } else {
            throw new MethodNotAllowedException();
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contact could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
