<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UpdateMessageForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('message_id', 'integer')
                      ->addField('user_id', 'integer')
                      ->addField('subject', ['type' => 'string'])
                      ->addField('body', ['type' => 'text']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->nonNegativeInteger('message_id')
                  ->maxLength('message_id', 11)
                  ->requirePresence('message_id', 'create')
                  ->notEmptyString('message_id')
                  ->nonNegativeInteger('user_id')
                  ->maxLength('user_id', 11)
                  ->requirePresence('user_id', true)
                  ->notEmptyString('user_id')
                  ->maxLength('subject', 150, 'The subject cannot be longer than 150 characters.')
                  ->requirePresence('subject', 'create', 'A subject is required.')
                  ->notEmptyString('subject', 'The subject cannot be empty.')
                  ->maxLength('body', 16777215)
                  ->requirePresence('body', 'create', 'A message is required.')
                  ->notEmptyString('body', 'The message cannot be empty.'); 

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        $messages_table = TableRegistry::getTableLocator()->get('Messages'); 
        $revisions_table = TableRegistry::getTableLocator()->get('Revisions');  

        $data['subject'] = filter_var($data['subject'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $data['body'] = filter_var($data['body'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        
        $message = $messages_table->get($data['message_id']);

        if (!$message) {
            $this->_errors = ['message_id' => 'The message does not exist.'];
            return false;
        }

        if ($data['subject'] == $message->subject && strlen($data['subject']) == strlen($message->subject) 
            && $data['body'] == $message->body && strlen($data['body']) == strlen($message->body)) {
            return true;
        }

        $revision = $revisions_table->newEmptyEntity();
        $new_revision = [];
        $new_revision['message_id'] = $message->id;
        $new_revision['subject'] = $message->subject;
        $new_revision['body'] = $message->body;
        $new_revision['user_id'] = $data['user_id'];
        $revision = $revisions_table->patchEntity($revision, $new_revision);

        if (!$revisions_table->save($revision)) {
            $this->_errors = $revision->getErrors();
            return false;
        }

        $message = $messages_table->patchEntity($message, $data);

        if (!$messages_table->save($message)) {
            $this->_errors = $message->getErrors();
            return false;
        }

        return true;
    }
}