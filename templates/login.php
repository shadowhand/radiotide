<?php $this->layout('layout') ?>

<div class="container">
    <div class="jumbotron">
        <h1>Ready to sync?</h1>
        <p class="lead">Before we can start syncing your data,<br>we'll need access to Rdio and Tidal.</p>
        <hr>
        <p>
            <?php if ($rdio_ready && $tidal_ready): ?>
                <a class="btn btn-lg btn-success" href="/" role="button">Let's Do This!</a>
            <?php elseif (!$rdio_ready): ?>
                <a class="btn btn-lg btn-primary" href="/login/rdio" role="button">Login to Rdio</a>
            <?php elseif (!$tidal_ready): ?>
                <a class="btn btn-lg btn-primary" href="/login/tidal" role="button">Login to Tidal</a>
            <?php endif ?>
        </p>
    </div>
</div>
