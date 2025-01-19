<h1 class="mb-3 text-center">Message Boards</h1>
<p>
    
</p>
<br>
<div class="row">
    <?php foreach ($boards as $board): ?>
    <div class="col-md-6 col-lg-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= $board->title ?></h3>
                <p class="card-text"><?php echo nl2br($board->description) ?></p>
                <a href="/boards/view/<?= $board->title ?>" class="btn btn-default">Go to <?= $board->title ?> &raquo;</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>