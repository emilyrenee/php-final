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
        <form action="/delete?id=<?= $employee[0]->id ?>" method="post">
            <div class="form-item">
                <input type="hidden" name="id" value="<?= $employee[0]->id ?>">
                <input type="submit" value="Remove">
            </div>
        </form>
    </div>
</div>