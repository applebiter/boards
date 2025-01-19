<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\UserRegistrationForm;
use App\Form\UserLoginForm;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Before filter method
     * 
     * @param \Cake\Event\EventInterface $event The event.
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'activate']);
    }

    /**
     * Authenticate method
     * 
     * @param array $data The user data.
     * @return bool Returns true if the user is authenticated, false otherwise.
     */
    protected function authenticate(array $data) 
    {
        $result = $this->Authentication->getResult();

        if (!$result || !$result->isValid()) {
            $login_attempt_table =$this->fetchTable('LoginAttempts');
            $loginAttempt = $login_attempt_table->newEmptyEntity();    
            $loginAttempt->username = $data['username'];   
            $login_attempt_table->save($loginAttempt);
            return false;    
        }
    
        return true;
    }

    /**
     * Login method
     * 
     * @return \Cake\Http\Response|null Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']); 
        $form = new UserLoginForm(); 
        $errors = [];
        
        if ($this->request->is('post')) {

            $data = $this->request->getData();

            if (isset($data['hidden'])) { 
                unset($data['hidden']);
            }

            $authenticated = $this->authenticate($this->request->getData());
            $login_attempt_table = $this->fetchTable('LoginAttempts');

            if ($authenticated) {
                $authenticated_user = $this->Authentication->getIdentity();
                $login_attempt_table->deleteAll(['username' => $this->request->getData('username')]);
                
                if ($authenticated_user && !$authenticated_user['is_active']) {
                    $this->Authentication->logout();
                    $this->Flash->error('Your account is inactive. Please contact the administrator.');
                }
                
                if ($authenticated_user && $authenticated_user['is_active']) {
                    $this->Authentication->setIdentity($authenticated_user);
                    $target = $this->Authentication->getLoginRedirect() ?? '/';
                    return $this->redirect($target);
                }
            }
            
            $overall_login_attempts = $login_attempt_table->find()
                ->where(['username' => $this->request->getData('username')])
                ->count();

            $recent_login_attempts = $login_attempt_table->find()
                ->where(['username' => $this->request->getData('username')])
                ->where(['created >' => date('Y-m-d H:i:s', strtotime('-5 minutes'))])
                ->count();

            if ($recent_login_attempts >= 10 || $overall_login_attempts >= 20) {
                $user = $this->Users->find()
                    ->where(['username' => $this->request->getData('username')])
                    ->first();
                $user->is_active = 0;
                $this->Users->save($user);
                $this->Flash->error('Too many login attempts. The account has been deactivated. Please contact the administrator.');
                return $this->redirect(['action' => 'login']);
            } 

            $this->Flash->error('Invalid username or password, try again');
        }

        $errors = $form->getErrors();
        $this->set(compact('form', 'errors'));
    }

    /**
     * Logout method
     * 
     * @return \Cake\Http\Response|null Redirects to the home page.
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            return $this->redirect('/');
        }
    }

    /**
     * Register method
     * 
     * @return \Cake\Http\Response|null Redirects on successful registration, renders view otherwise.
     */
    public function register()
    {
        $this->request->allowMethod(['get', 'post']); 
        $form = new UserRegistrationForm(); 
        $errors = [];

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (isset($data['hidden'])) { 
                unset($data['hidden']);
            }

            if ($form->execute($data)) {
                $this->Flash->success(__('The account has been created. Please check your email for further instructions.'));
            }

            else {
                $this->Flash->error(__('The account could not be registered. Please, try again.'));
            }
        }
        
        $errors = $form->getErrors();
        $this->set(compact('form', 'errors'));
    }

    /**
     * Activate method
     * 
     * @param int $user_id The user id.
     * @param string $activation_code The activation code.
     * @return \Cake\Http\Response|null Redirects to the login page.
     */
    public function activate($user_id, $activation_code)
    {
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
        $activation_code = filter_var($activation_code, FILTER_FLAG_EMPTY_STRING_NULL | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
        $activations_table = $this->fetchTable('AccountActivations');
        $activation = $activations_table->find()
            ->where([
                'user_id' => $user_id,
                'code' => $activation_code,
                'created >=' => date('Y-m-d H:i:s', strtotime('-5 minutes'))])
            ->first();

        if (!$activation) {
            $this->Flash->error('Invalid activation code.');
            return $this->redirect(['action' => 'login']);
        }

        $users_table = $this->fetchTable('Users');
        $user = $users_table->get($user_id);
        $user->is_active = 1;
        $users_table->save($user);
        $activations_table->delete($activation);
        $this->Flash->success('Your account has been activated. Please log in.');
        return $this->redirect(['action' => 'login']);
    }
}
