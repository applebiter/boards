<?php
namespace App\Form;

use Cake\Core\Configure;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;

class UserRegistrationForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('username', 'string')
                      ->addField('email', 'string')
                      ->addField('password', 'string')
                      ->addField('repassword', 'string')
                      ->addField('agrees_to_terms', 'boolean');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->maxLength('username', 30, 'The username cannot be longer than 30 characters.')
                  ->requirePresence('username', 'create', 'A username is required.')
                  ->notEmptyString('username', 'The username cannot be empty.')
                  ->alphaNumeric('username', 'The username can only contain letters and numbers.')
                  ->maxLength('email', 150)
                  ->requirePresence('email', 'create', 'An email address is required.')
                  ->notEmptyString('email', 'The email cannot be empty.')
                  ->email('email', 'The email address is not valid.')
                  ->maxLength('password', 30, 'The password cannot be longer than 30 characters.')
                  ->minLength('password', 8, 'The password must be at least 8 characters long.')
                  ->requirePresence('password', 'create', 'A password is required.')
                  ->notEmptyString('password', 'The password cannot be empty.')
                  ->minLength('repassword', 8, 'The password must be at least 8 characters long.')
                  ->requirePresence('repassword', 'create', 'You must retype the password.')
                  ->notEmptyString('repassword', 'You must retype the password.')
                  ->sameAs('repassword', 'password', 'The passwords do not match.')
                  ->requirePresence('agrees_to_terms', 'create', 'You must agree to the terms of use and privacy policy.')
                  ->notEmptyString('agrees_to_terms', 'You must agree to the terms of use and privacy policy.'); 

        return $validator;
    }

    protected function _execute(array $data): bool
    {
        $users_table = TableRegistry::getTableLocator()->get('Users'); 
        $data['is_active'] = 0;
        $data['is_staff'] = 0;
        $data['is_superuser'] = 0;
        $data['email'] = 
        $user = $users_table->newEmptyEntity();
        $user = $users_table->patchEntity($user, $data);

        if (!$users_table->save($user)) {
            $this->_errors = $user->getErrors();
            return false;
        }

        $activations_table = TableRegistry::getTableLocator()->get('AccountActivations'); 
        $activation = $activations_table->newEmptyEntity();
        $activation->user_id = $user->id;
        $activation->code = bin2hex(random_bytes(3));
        
        if (!$activations_table->save($activation)) {
            $this->_errors = $activation->getErrors();
            return false;
        }

        $email = new Mailer('default');
        $email->setTo($data['email'])
              ->setFrom('do_not_reply@applebiter.com', 'Applebiter.com Automated Email')
              ->setSubject('Activate your Applebiter.com account')
              ->setEmailFormat('both')
              ->setViewVars(['user_id' => $activation->user_id, 'activation_code' => $activation->code])
              ->viewBuilder()
                ->setTemplate('activation');

        if (!$email->deliver()) {
            $this->_errors = ['email' => 'There was an error sending the activation email. Please try again later.'];
            return false;
        }

        return true;
    }
}