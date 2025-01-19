<?php
declare(strict_types=1);

namespace App\Controller;

require_once(ROOT . DS . 'vendor' . DS . "erusev" . DS . "parsedown" . DS . "Parsedown.php");

use App\Form\NewReplyForm;
use App\Form\UpdateMessageForm;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 */
class MessagesController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $Parsedown = new \Parsedown();
        $Parsedown->setSafeMode(true);
        $current_user_id = $this->Authentication->getIdentity()->id;
        $is_staff = $this->Authentication->getIdentity()->is_staff;
        $message = $this->Messages->get($id, contain: ['Users', 'Boards', 'ParentMessages', 'Revisions', 'ParentMessages.Users']);
        $messages = $this->Messages->find()
            ->where(['board_id' => $message->board_id, 'thread' => $message->thread])
            ->contain(['Users'])
            ->orderBy(['thread_position' => 'ASC']);            
        
        $this->set(compact('message', 'messages', 'current_user_id', 'is_staff', 'Parsedown'));
    }

    /**
     * Reply method
     * 
     * @return \Cake\Http\Response|null|void Redirects on successful reply, renders view otherwise.
     */
    public function reply($parent_id = null)
    {
        $form = new NewReplyForm();
        $form->is_superuser = $this->Authentication->getIdentity()->is_superuser;
        $data = $this->request->getData();
        $data['parent_id'] = $parent_id;
        $data['user_id'] = $this->Authentication->getIdentity()->id;

        if ($this->request->is('post') && $form->execute($data)) {
            return $this->redirect(['action' => 'view', $form->new_id]);
        }

        $errors = $form->getErrors();

        foreach ($errors as $error) {
            foreach ($error as $message) {
                $this->Flash->error($message);
            }
        }

        $this->Flash->error(__('The message could not be saved. Please, try again.'));                
        return $this->redirect(['controller' => 'Messages', 'action' => 'view', $data['parent_id']]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $current_user_id = $this->Authentication->getIdentity()->id;
        $is_staff = $this->Authentication->getIdentity()->is_staff;
        $form = new UpdateMessageForm();
        $errors = [];
        $data = $this->request->getData();
        $data['user_id'] = $current_user_id;
        $message = $this->Messages->get($id, contain: ['Users', 'Boards', 'ParentMessages']);

        if ($current_user_id != $message->user_id && !$is_staff) {
            $this->Flash->error(__('You are not authorized to edit this message.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($form->execute($data)) {
                return $this->redirect(['action' => 'view', $message->id]);
            }

            $errors = $form->getErrors();
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }

        $messages = $this->Messages->find()
            ->where(['board_id' => $message->board_id, 'thread' => $message->thread])
            ->contain(['Users'])
            ->orderBy(['thread_position' => 'ASC']);

        $this->set(compact('message', 'messages', 'errors'));
    }
}
