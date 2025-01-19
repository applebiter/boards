<p class="mb-4">
    <a href="/revisions/index/<?= $revision->message->id ?>">
    <i class="bi bi-caret-left me-1"></i> Go Back to Revision History
    </a>
</p>
<br><br>
<div class="text-center mb-4">
    <h3><?= $revision->subject ?></h3>
    <span class="blockquote-footer">
        posted by <i class="bi bi-person-fill"></i> 
        <b><?= h($revision->message->user->username) ?></b> 
        on <?= $this->Time->nice($revision->created) ?> to 
        <a href="/boards/view/<?= h($revision->message->board->title) ?>"><?= h($revision->message->board->title) ?></a> 
        <?php if ($revision->message->parent_id) : ?> 
        in reply to 
        <a href="/messages/view/<?= $revision->message->parent_id ?>"><?= h($revision->message->parent_message->subject) ?></a>
        posted by <i class="bi bi-person-fill"></i> 
        <b><?= h($revision->message->parent_message->user->username) ?></b> 
        on <?= $this->Time->nice($revision->message->parent_message->created) ?>
        <?php endif ?>
    </span>
</div>
<br><br>
<?= $Parsedown->text($revision->body) ?>
