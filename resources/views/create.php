<?php require('/var/www/resources/views/partials/header.php'); ?>

<div class="container">
    <a href="/" class="nav">Cancel</a>
    <h1>New Employee</h1>
    <hr />

    <div class="form-container">
        <form action="/create" method="post">
            <div class="form-item">
                <label for="name">Name</label>
                <input type="text" name="name" id="">
            </div>
            <div class="form-item">
                <label for="address">Address</label>
                <input type="text" name="address" id="">
            </div>
            <div class="form-item">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>