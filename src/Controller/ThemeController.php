<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Boards Controller
 *
 * @property \App\Model\Table\BoardsTable $Boards
 */
class ThemeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function change($theme = null)
    {
        if ($theme) {
            $this->request->getSession()->write('theme', $theme);
        }
        $this->redirect($this->referer());
    }
}
