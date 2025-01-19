<p class="mb-4">
    <i class="bi bi-caret-left me-1"></i> 
    <a href="/boards/view/<?= h($message->board->title) ?>">
    Go Back to <?= h($message->board->title) ?>
    </a>
</p>
<br><br>
<div class="text-center mb-4">
    <?= $this->Flash->render() ?>
    <h3><?= $message->subject ?></h3>
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
    <?php if (count($message->revisions) > 0) : ?>
    <br>
    <a href="/revisions/index/<?= $message->id ?>" class="text-muted">
        <small>Revision <?= count($message->revisions) ?></small>
    </a>
    <?php endif ?>
</div>
<br><br>
<?= $Parsedown->text($message->body) ?>
<?php if ($current_user_id == $message->user_id || $is_staff) : ?>
<nav class="text-end">
    <button type="button" class="btn bt-sm btn-secondary" onclick="javascript:window.location.href='/messages/edit/<?= $message->id ?>'">
        <i class="bi bi-pencil-fill me-1"></i> Edit
    </button>
</nav>
<?php endif ?>
<br><br>
<?php if ($messages->count() > 0): ?>
<h4 class="text-center mb-3" id="newpost">Messages in this Thread</h4>
<nav class="d-flex justify-content-center mb-3">
    <a href="#newreply" class="btn btn-sm btn-default me-1">Post a Reply</a>
    <a href="/boards/view/<?= h($message->board->title) ?>" class="btn btn-sm btn-default">Return to <?= h($message->board->title) ?></a>
</nav>
<p>
    <?php foreach ($messages as $msg): ?>    
    <?= str_repeat(' &nbsp; ', 6 * $msg->level) ?> 
    <i class="bi bi-caret-right text-secondary"></i>    
    <?php if ($message->id != $msg->id) : ?>
    <a href="/messages/view/<?= $msg->id ?>" class="me-1"><?= h($msg->subject) ?></a> 
    <?php else : ?>
    <span class="me-1"><b><?= h($msg->subject) ?></b></span> 
    <?php endif ?>
    <span class="blockquote-footer">
        by <i class="bi bi-person-fill"></i> 
        <b><?= h($msg->user->username) ?></b> 
        posted on <?= $this->Time->nice($msg->created) ?>
    </span><br>    
    <?php endforeach ?>
</p>
<?php endif ?>
<br><br>
<div class="row">
    <div class="card col-lg-6 mx-auto">
        <div class="card-body">
            <h4 class="text-center mb-3" id="newreply">Post a Reply</h4>
            <br>
            <?= $this->Form->create(null, ['autocomplete' => 'off', 'class' => 'mb-3', 'url' => "/messages/reply/{$message->id}"]) ?>
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="board_id" id="board_id" value="<?= $message->board->id ?>">
                <input type="hidden" name="board_title" id="board_title" value="<?= h($message->board->title) ?>">
                <input type="hidden" name="parent_id" id="parent_id" value="<?= $message->id ?>">
                <input type="hidden" name="thread" id="thread" value="<?= $message->thread ?>">
                <input type="hidden" name="level" id="level" value="<?= $message->level ?>">
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" autocomplete="new-text">
                        <?php if (isset($errors['subject'])) : ?>
                            <span class="is-invalid"><?= $errors['subject'] ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="body" class="form-label">Message</label>
                        <textarea class="form-control" id="body" name="body" rows="15" autocomplete="new-text"></textarea>
                        <?php if (isset($errors['body'])) : ?>
                            <span class="is-invalid"><?= $errors['body'] ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-end">
                        <!-- <button type="reset" class="btn btn-sm btn-secondary">
                            <i class="bi bi-eraser-fill me-1"></i> Reset
                        </button> -->
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-text-left me-1"></i> Preview
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-check-lg me=1"></i> Post
                        </button>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl verybigmodal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> </h5>
                        </div>
                        <div class="modal-body" style="white-space: pre-wrap;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title').text($('#subject').val());
        modal.find('.modal-body').html($('#body').val());
    });
});
</script>