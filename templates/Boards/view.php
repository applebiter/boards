<style>
.verybigmodal{   max-width:75% !important; }
</style>
<h1 class="text-center"><?= $board->title ?></h1>
<p class="text-center"><?php echo nl2br($board->description) ?></p>
<?php if ($this->Identity->isLoggedIn()) : ?>
<nav class="d-flex justify-content-center mb-3">
    <a href="#newpost" class="btn btn-sm btn-default me-1">Post a New Message</a>
    <a href="/" class="btn btn-sm btn-default">Return to Board List</a>
</nav>
<?php endif ?>
<br><br>
<?php if ($messages->count() > 0): ?>
<?php foreach ($messages as $message): ?>
    <p class="mb-2">    
        <?= str_repeat(' &nbsp; ', 6 * $message->level) ?>
        <i class="bi bi-caret-right text-secondary"></i>  
        <a href="/messages/view/<?= $message->id ?>" class="me-1"><?= h($message->subject) ?></a> 
        <span class="blockquote-footer">
            by <i class="bi bi-person-fill"></i> 
            <b><?= h($message->user->username) ?></b> 
            posted on 
            <?= $this->Time->nice($message->created) ?> 
            &nbsp;  [<?= ($message->reply_count) == 0 ? 'No ' : $message->reply_count ?> <?= ($message->reply_count == 1) ? 'reply' : 'replies' ?>]
        </span> 
    </p>   
<?php endforeach ?>
<?php else: ?>
<p class="text-center blockquote">No messages were found.</p>
<?php endif ?>
<br>
<p class="text-center"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} thread(s) out of {{count}} total')) ?></p>
<nav class="d-flex justify-content-center">
    <ul class="pagination pagination flex-wrap">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
</nav>
<?php if ($this->Identity->isLoggedIn()) : ?>
<br><br>
<div class="row">
    <div class="card col-lg-6 mx-auto">
        <div class="card-body">
            <h4 class="text-center mb-3" id="newpost">Post a New Message</h4>
            <br>
            <?= $this->Flash->render() ?>
            <?= $this->Form->create(null, ['autocomplete' => 'off', 'class' => 'mb-3']) ?>
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="board_id" id="board_id" value="<?= $board->id ?>">
                <input type="hidden" name="board_title" id="board_title" value="<?= h($board->title) ?>">
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
                            <p></p>
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
<?php endif ?>
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