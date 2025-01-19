<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Boards Model
 *
 * @property \App\Model\Table\MessagesTable&\Cake\ORM\Association\HasMany $Messages
 *
 * @method \App\Model\Entity\Board newEmptyEntity()
 * @method \App\Model\Entity\Board newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Board> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Board get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Board findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Board patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Board> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Board|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Board saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Board>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Board>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Board>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Board> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Board>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Board>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Board>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Board> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BoardsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('boards');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Messages', [
            'foreignKey' => 'board_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->maxLength('title', 150)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }
}
