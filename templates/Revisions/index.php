<?php
$message = $revisions->items()->first()->message;
?>
<p class="mb-4">
    <a href="/messages/view/<?= $message->id ?>">
    <i class="bi bi-caret-left me-1"></i> Go Back to the Message
    </a>
</p>
<br><br>
<div class="text-center mb-3">
    <h3 class="mb-3">Revision History For</h3>
    <p class="mb-2">
        <i class="bi bi-caret-right text-secondary"></i>  
        <span class="me-1"><?= $message->subject ?></span> 
        <span class="blockquote-footer">
            posted by <i class="bi bi-person-fill"></i> 
            <b><?= h($message->user->username) ?></b> 
            on <?= $this->Time->nice($message->created) ?> to 
            <a href="/boards/view/<?= h($message->board->title) ?>"><?= h($message->board->title) ?></a> 
            <?php if ($message->parent_id) : ?> 
            in reply to 
            <a href="/messages/view/<?= $message->parent_id ?>"><?= h($message->parent_message->subject) ?></a>
            posted by <i class="bi bi-person-fill"></i> 
            <b><?= h($message->parent_message->user->username) ?></b> 
            on <?= $this->Time->nice($message->parent_message->created) ?>
            <?php endif ?>
        </span>
    </p>
</div>
<br><br>
<?php if (count($revisions) > 0) : ?>
<ul class="list-group mb-3">
    <?php foreach ($revisions as $revision) : ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="/revisions/view/<?= $revision->id ?>"><?= h($revision->subject) ?></a>
        <small class="text-muted"><?= $this->Time->nice($revision->created) ?></small>
    </li>
    <?php endforeach ?>
</ul>
<p class="text-center"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} prior versions(s) out of {{count}} total')) ?></p>
<nav class="d-flex justify-content-center">
    <ul class="pagination pagination flex-wrap">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
</nav>
<?php endif ?>
