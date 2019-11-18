<?php require('/var/www/resources/views/partials/header.php'); ?>

<div class="container">
    <a href="/create" class="nav">Add</a>
    <h1>All Employees</h1>
    <hr />

    <?php foreach ($employees as $employee) : ?>
        <div class="employee">
            <a href="view?id=<?= $employee->id ?>">
                <h2><?= $employee->name; ?></h2>
            </a>
            <span><?= $employee->address; ?></span>
            <div style="margin-top: .5rem">
                <a href="update?id=<?= $employee->id ?>">Edit</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>