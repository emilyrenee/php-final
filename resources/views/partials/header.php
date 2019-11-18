<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .nav {
            margin-bottom: 2rem;
            font-size: 20px;
            text-align: right;
        }
        .container {
            display: flex;
            flex-direction: column;
            margin: 2rem 20%;
        }
        hr {
            width: 100%;
            margin-top: .25rem;
            margin-bottom: 2rem;
        }
        h1, h2 {
            margin: 0;
            padding: 0;
        }
        .employee {
            margin: 1rem 0;
        }
        .form-container {
            margin: 1rem 0;
        }
        .errors {
            list-style: none;
            margin: 0;
            padding: 0;
            color: red;
        }
        .create-form, .edit-form {
            flex-direction: column;
            display: flex;
            min-height: 200px;
            justify-content: space-around;
        }
        .form-item {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: .25rem;
        }
        input {
            max-width: 200px;
        }
        .delete-form {
            margin-top: .5rem;
        }
    </style>
</head>

<body>