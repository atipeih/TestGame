<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Log\Log;

/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GamesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $games = 'dice check!';

        $this->set(compact('games'));
    }

}
