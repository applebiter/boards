<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $board_id
 * @property int $thread
 * @property int $thread_position
 * @property int $level
 * @property int|null $parent_id
 * @property string $subject
 * @property string $body
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Board $board
 * @property \App\Model\Entity\Message $parent_message
 * @property \App\Model\Entity\Message[] $child_messages
 * @property \App\Model\Entity\Revision[] $revisions
 */
class Message extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'board_id' => true,
        'thread' => true,
        'thread_position' => true,
        'level' => true,
        'parent_id' => true,
        'subject' => true,
        'body' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'board' => true,
        'parent_message' => true,
        'child_messages' => true,
        'revisions' => true,
    ];
}
