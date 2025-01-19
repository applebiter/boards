<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;

class NewReplyForm extends Form
{
    public $new_id;
    public $is_superuser = false;
    
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('board_id', 'integer')
                      ->addField('user_id', 'integer')
                      ->addField('thread', 'integer')
                      ->addField('parent_id', 'integer')
                      ->addField('level', 'integer')
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
                  ->nonNegativeInteger('thread')
                  ->maxLength('thread', 11)
                  ->requirePresence('thread', 'create')
                  ->notEmptyString('thread')
                  ->nonNegativeInteger('parent_id')
                  ->maxLength('parent_id', 11)
                  ->requirePresence('parent_id', 'create')
                  ->notEmptyString('parent_id')
                  ->nonNegativeInteger('level')
                  ->maxLength('level', 11)
                  ->requirePresence('level', 'create')
                  ->notEmptyString('level')
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
        $parent = $messages_table->get($data['parent_id']);

        if (!$parent) {
            $this->_errors = ['parent_id' => 'The parent message could not be found.'];
            return false;
        }

        // check if the current thread is locked
        $locked_threads_table = TableRegistry::getTableLocator()->get('LockedThreads');
        $locked_thread = $locked_threads_table->find()
            ->where(['board_id' => $data['board_id'], 'thread' => $data['thread']])
            ->first();

        if ($locked_thread && !$this->is_superuser) {
            $this->_errors = ['thread' => ['general' => 'This thread is locked.',]];
            return false;
        }

        $data['thread_position'] = $parent->thread_position + 1;
        $data['level'] = intval($data['level']) + 1;
        $data['subject'] = filter_var($data['subject'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $data['body'] = filter_var($data['body'], FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

        $expression = new QueryExpression('thread_position = thread_position + 1');
        $messages_table->updateAll([$expression], ['thread' => $data['thread'], 'thread_position >=' => $data['thread_position']]);
        
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