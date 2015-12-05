<?php $this->layout('layout') ?>

<div class="container">
    <div class="jumbotron">
        <h1>Login to Tidal</h1>
        <p class="lead">We never store this information.</p>
    </div>
    <div class="row login-form">
        <div class="col-md-8 col-md-push-2">
            <form action method="post">
                <div class="form-group">
                    <label for="tidal-username">Username</label>
                    <input id="tidal-username" class="form-control" placeholder="Email Address"
                        name="username" type="email" required>
                    <?php if (!empty($messages['username'])): ?>
                        <p class="bg-danger"><?= $this->e($messages['username']) ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="tidal-password">Password</label>
                    <input id="tidal-password" class="form-control" placeholder="Password"
                        name="password" type="password" required>
                    <?php if (!empty($messages['password'])): ?>
                        <p class="bg-danger"><?= $this->e($messages['username']) ?></p>
                    <?php endif ?>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
