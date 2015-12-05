<?php $this->layout('layout') ?>

<div class="container">
    <div class="jumbotron">
        <h1>Import Results</h1>
        <p class="lead">Able to import <?= $imported ?> of <?= $imported + $missing ?> albums.</p>
        <?php if (empty($missing)): ?>
            <hr>
            <p class="bg-success">Complete success!</p>
        <?php endif ?>
    </div>
    <?php if (!empty($failed)): ?>
        <?php foreach ($failed as $type => $names): ?>
            <p>The following <?= count($names) ?> albums from your <?= $this->e($type) ?> were not found:</p>
            <ul>
            <?php foreach ($names as $album): ?>
                <li><?= $this->e($album) ?></li>
            <?php endforeach ?>
            </ul>
        <?php endforeach ?>
    <?php endif ?>
</div>
