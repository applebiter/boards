<div class="row">
    <div class="card col-lg-6 mx-auto">
        <div class="card-body">
            <h4 class="card-title text-center">Sign In</h4>
            <br>
            <?= $this->Flash->render() ?>
            <?= $this->Form->create(null, ['autocomplete' => 'off', 'class' => 'mb-3']) ?>
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <div class="row mb-3">
                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" name="username" required autofocus autocomplete="new-text">
                        <?php if (isset($errors['username'])) : ?>
                            <span class="is-invalid"><?= end($errors['username']) ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                        <?php if (isset($errors['password'])) : ?>
                            <span class="is-invalid"><?= end($errors['password']) ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-3">Sign In</button> 
                        <?= $this->Html->link("Register an account", ['action' => 'register']) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>