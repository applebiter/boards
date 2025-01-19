<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoginAttempts Model
 *
 * @method \App\Model\Entity\LoginAttempt newEmptyEntity()
 * @method \App\Model\Entity\LoginAttempt newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoginAttempt> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoginAttempt get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoginAttempt findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoginAttempt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoginAttempt> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoginAttempt|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoginAttempt saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoginAttempt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoginAttempt>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoginAttempt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoginAttempt> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoginAttempt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoginAttempt>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoginAttempt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoginAttempt> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoginAttemptsTable extends Table
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

        $this->setTable('login_attempts');
        $this->setDisplayField('ip_address');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('username')
            ->maxLength('username', 30)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

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
        return $rules;
    }
}
