<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccountActivations Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\AccountActivation newEmptyEntity()
 * @method \App\Model\Entity\AccountActivation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AccountActivation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccountActivation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AccountActivation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AccountActivation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AccountActivation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccountActivation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AccountActivation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AccountActivation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccountActivation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccountActivation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccountActivation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccountActivation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccountActivation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AccountActivation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AccountActivation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccountActivationsTable extends Table
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

        $this->setTable('account_activations');
        $this->setDisplayField('code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('code')
            ->maxLength('code', 6)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

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

        return $rules;
    }
}
