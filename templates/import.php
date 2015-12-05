<?php $this->layout('layout') ?>

<div class="container">
    <div class="jumbotron">
        <h1>Begin Import</h1>
        <p class="lead">Ready to import your data from Rdio to Tidal?</p>
    </div>
    <form action="/import" method="post" class="import">
        <p>Choose what data you wanted imported and we'll get started!</p>
        <div class="checkbox">
            <label><input name="types[]" value="collection" type="checkbox" checked> My Collection</label>
        </div>
        <div class="checkbox">
            <label><input name="types[]" value="favorites" type="checkbox" checked> My Favorites</label>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success">Start</button>
        </div>
    </form>
</div>
