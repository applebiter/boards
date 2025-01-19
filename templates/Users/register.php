<div class="row">
    <div class="card col-lg-6 mx-auto">
        <div class="card-body">
            <h4 class="card-title text-center">Register an Account</h4>
            <br>
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($form, ['autocomplete' => 'off', 'class' => 'mb-3']) ?>
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
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" required autocomplete="new-email">
                        <?php if (isset($errors['email'])) : ?>
                            <span class="is-invalid"><?= end($errors['email']) ?></span>
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
                    <label for="repassword" class="col-sm-3 col-form-label">Retype Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="repassword" name="repassword" required>
                        <?php if (isset($errors['repassword'])) : ?>
                            <span class="is-invalid"><?= end($errors['repassword']) ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label"> &nbsp; </label>
                    <div class="col-sm-9">
                        <input type="hidden" name="agrees_to_terms" value="0">
                        <input class="form-check-input me-1" type="checkbox" id="agrees_to_terms" name="agrees_to_terms" value="1" onclick="document.getElementById('submit_button').disabled = !this.checked;" required>
                        <label class="form-check-label" for="agrees_to_terms">
                            By checking this box, you agree to our <a href="/pages/terms">Terms of Use</a> and <a href="/pages/privacy">Privacy Policy</a>
                        </label>
                        <?php if (isset($errors['agrees_to_terms'])) : ?>
                            <span class="is-invalid"><?= end($errors['agrees_to_terms']) ?></span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary me-3" id="submit_button" disabled>Register</button> 
                        <?= $this->Html->link("Already registered? Click here to login", ['action' => 'login']) ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>