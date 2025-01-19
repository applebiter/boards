<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class UserLoginForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('username', 'string')
                      ->addField('password', 'string');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->maxLength('username', 30, 'The username cannot be longer than 30 characters.')
                  ->requirePresence('username', 'create', 'A username is required.')
                  ->notEmptyString('username', 'The username cannot be empty.')
                  ->alphaNumeric('username', 'The username can only contain letters and numbers.')
                  ->maxLength('password', 30, 'The password cannot be longer than 30 characters.')
                  ->minLength('password', 8, 'The password must be at least 8 characters long.')
                  ->requirePresence('password', 'create', 'A password is required.')
                  ->notEmptyString('password', 'The password cannot be empty.'); 

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        return true;
    }
}