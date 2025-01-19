<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\NewMessageForm;

/**
 * Boards Controller
 *
 * @property \App\Model\Table\BoardsTable $Boards
 */
class BoardsController extends AppController
{
    protected array $paginate = [
        'limit' => 20,
        'maxLimit' => 300,
    ];
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Boards->find();
        $boards = $this->paginate($query);

        $this->set(compact('boards'));
    }

    /**
     * View method
     *
     * @param string|null $title Board title.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($title = null)
    {
        $sanitized_title = filter_var($title, FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW); 
        $form = new NewMessageForm();
        $errors = [];
        $data = $this->request->getData();
        $result = $this->Authentication->getResult();
        $identity = null;
        
        if ($sanitized_title === null) {            
            
            $this->Flash->error(__('The board could not be found.'));
            return $this->redirect(['action' => 'index']);
        }  
        else {
            
            $board = $this->Boards->find()
                ->where(['title' => $sanitized_title])
                ->first();            
            
            if (!$board) {
                $this->Flash->error(__('The board could not be found.'));
                return $this->redirect($this->referer());
            }
        }

        if ($this->request->is('post')) {
            if ($result && $result->isValid()) {
                $identity = $this->Authentication->getIdentity()->getOriginalData();
                $data['user_id'] = $identity->id;

                if ($form->execute($data)) {
                    return $this->redirect(['controller' => 'Messages', 'action' => 'view', $form->new_id]);
                }

                $errors = $form->getErrors();
                $this->Flash->error(__('The message could not be saved. Please check the form for errors and try again.'));
            }
        }

        $query = $this->Boards
                      ->Messages
                      ->find('all', contain: ['Users'])
                      ->where(['board_id' => $board->id, 'parent_id' => 0])
                      ->orderBy(['thread' => 'DESC', 'thread_position' => 'ASC']);
        $messages = $this->paginate($query);

        foreach ($messages as $message) {
            $message->reply_count = $this->Boards
                                         ->Messages
                                         ->find('all')
                                         ->where([
                                            'board_id' => $board->id, 
                                            'thread' => $message->thread])
                                         ->count() -1;    

        }
        
        $this->set(compact('board', 'messages', 'errors'));
    }
}
