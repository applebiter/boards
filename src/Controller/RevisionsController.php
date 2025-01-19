<?php
declare(strict_types=1);

namespace App\Controller;

require_once(ROOT . DS . 'vendor' . DS . "erusev" . DS . "parsedown" . DS . "Parsedown.php");

/**
 * Revisions Controller
 *
 * @property \App\Model\Table\RevisionsTable $Revisions
 */
class RevisionsController extends AppController
{
    /**
     * Index method
     * 
     * @param string|null $message_id Message id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($message_id = null)
    {
        $query = $this->Revisions->find()
            ->contain([
                'Users', 'Messages', 'Messages.Boards', 'Messages.ParentMessages', 
                'Messages.ParentMessages.Users', 'Messages.Users'
                ])
            ->where(['Revisions.message_id' => intval($message_id)])
            ->orderBy(['Revisions.created' => 'DESC']);
        $revisions = $this->paginate($query);

        $this->set(compact('revisions'));
    }

    /**
     * View method
     *
     * @param string|null $id Revision id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $Parsedown = new \Parsedown();
        $Parsedown->setSafeMode(true);
        $revision = $this->Revisions->get($id, contain: [
            'Users', 'Messages', 'Messages.Boards', 'Messages.ParentMessages', 
            'Messages.ParentMessages.Users', 'Messages.Users'
        ]);
        
        $this->set(compact('revision', 'Parsedown'));
    }
}
