<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LockedThreads Model
 *
 * @property \App\Model\Table\BoardsTable&\Cake\ORM\Association\BelongsTo $Boards
 *
 * @method \App\Model\Entity\LockedThread newEmptyEntity()
 * @method \App\Model\Entity\LockedThread newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LockedThread> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LockedThread get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LockedThread findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LockedThread patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LockedThread> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LockedThread|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LockedThread saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LockedThread>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LockedThread>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LockedThread>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LockedThread> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LockedThread>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LockedThread>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LockedThread>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LockedThread> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LockedThreadsTable extends Table
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

        $this->setTable('locked_threads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Boards', [
            'foreignKey' => 'board_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('board_id')
            ->notEmptyString('board_id');

        $validator
            ->nonNegativeInteger('thread')
            ->requirePresence('thread', 'create')
            ->notEmptyString('thread');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['board_id'], 'Boards'), ['errorField' => 'board_id']);

        return $rules;
    }
}
