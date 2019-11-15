<?php require('/var/www/resources/views/partials/header.php'); ?>

<div class="container">
    <h1>All Employees</h1>
    <hr />

    <?php foreach ($employees as $employee) : ?>
        <div class="employee">
            <h2><?= $employee->name; ?></h2>
            <span><?= $employee->address; ?></span>
        </div>
        <div>
            <a href="#">Edit</a>
        </div>
    <?php endforeach; ?>
    <div style="margin-top: 2rem">
        <a href="/create">Add Employee</a>
    </div>
</div>