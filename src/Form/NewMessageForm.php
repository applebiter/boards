<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class NewMessageForm extends Form
{
    public $new_id;
    
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('board_id', 'integer')
                      ->addField('user_id', 'integer')
                      ->addField('subject', ['type' => 'string'])
                      ->addField('body', ['type' => 'text']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->nonNegativeInteger('board_id')
                  ->maxLength('board_id', 11)
                  ->requirePresence('board_id', 'create')
                  ->notEmptyString('board_id')
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
        $thread = $messages_table->find()
                                 ->select(['thread'])
                                 ->where(['board_id' => $data['board_id']])
                                 ->orderBy(['thread' => 'DESC'])
                                 ->first();
        $data['thread'] = ($thread && intval($thread->thread) > 0) ? intval($thread->thread) + 1 : 1;
        $data['level'] = '0';
        $data['subject'] = filter_var($data['subject'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $data['body'] = filter_var($data['body'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $message = $messages_table->newEmptyEntity();
        $message = $messages_table->patchEntity($message, $data);

        if (!$messages_table->save($message)) {
            $this->_errors = $message->getErrors();
            return false;
        }

        $this->new_id = $message->id;

        return true;
    }
}