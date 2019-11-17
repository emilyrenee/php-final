<?php require('/var/www/resources/views/partials/header.php'); ?>

<div class="container">
    <a href="/" class="nav">View All</a>
    <h1>Employee</h1>
    <hr />

    <div class="employee">
        <h2><?= $employee[0]->name; ?></h2>
        <span><?= $employee[0]->address; ?></span>
    </div>
    <div>
        <a href="update/?id=<?= $employee[0]->id ?>">Edit</a>
        <a href="#">Remove</a>
    </div>
</div>