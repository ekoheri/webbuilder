<html>
<head>
    <title>Web Builder Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Builder Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link<?php if(METHOD_ACTIVE == 'index') echo ' active'?>" href="<?php echo BASE_URL?>/index.php/admin/index">Entry Element</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php if(METHOD_ACTIVE == 'showapikey') echo ' active'?>" href="<?php echo BASE_URL?>/index.php/admin/showapikey">Token API</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php if(METHOD_ACTIVE == 'user') echo ' active'?>" href="<?php echo BASE_URL?>/index.php/admin/user">User</a>
            </li>
        </ul>
        <div class="d-flex" role="search">
            <button class="btn btn-outline-danger" onclick="location.href='<?php echo BASE_URL?>/index.php/admin/logout';">Logout</button>
        </div>
    </div>
</nav>