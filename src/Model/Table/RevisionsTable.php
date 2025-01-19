<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Revisions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MessagesTable&\Cake\ORM\Association\BelongsTo $Messages
 *
 * @method \App\Model\Entity\Revision newEmptyEntity()
 * @method \App\Model\Entity\Revision newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Revision> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Revision get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Revision findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Revision patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Revision> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Revision|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Revision saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Revision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Revision>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Revision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Revision> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Revision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Revision>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Revision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Revision> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RevisionsTable extends Table
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

        $this->setTable('revisions');
        $this->setDisplayField('subject');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Messages', [
            'foreignKey' => 'message_id',
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
            ->nonNegativeInteger('user_id')
            ->notEmptyString('user_id');

        $validator
            ->nonNegativeInteger('message_id')
            ->notEmptyString('message_id');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 150)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmptyString('body');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['message_id'], 'Messages'), ['errorField' => 'message_id']);

        return $rules;
    }
}
