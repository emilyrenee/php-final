<?php require('/var/www/resources/views/partials/header.php'); ?>

<div class="container">
    <a href="/" class="nav">Cancel</a>
    <h1>Update Employee</h1>
    <hr />

    <div class="form-container">
        <form action="/update?id=<?= $employee[0]->id ?>" method="post">
            <div class="form-item">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?= $employee[0]->name ?>">
            </div>
            <div class="form-item">
                <label for="address">Address</label>
                <input type="text" name="address" value="<?= $employee[0]->address ?>">
            </div>
            <input type="hidden" name="id" value="<?= $employee[0]->id ?>">
            <div class="form-item">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>