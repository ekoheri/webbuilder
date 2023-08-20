<html>
<head>
    <title>Web Builder Spec API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<div class="container py-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5>Get API Key</h5>
                    <p>Untuk bisa mengakses API yang ada disini, anda harus memasang TOKEN API pada header aplikasi frontend anda!</p>
                    <p>Untuk mendapatkan Token API, anda harus login ke halaman admin <a href="<?php echo BASE_URL ?>/index.php/admin">Login Admin</a></p>
                    <hr />
                    <h5>Daftar Spec API</h5>
                    <p>Setelah anda mendapatkan TOKEN API, silahkan akses URL berikut ini</p>
                    <ol>
                        <?php foreach($list_element as $key => $value) { ?>
                        <li>Method : GET, Elements : <?php echo $key ?>, URL :
                            <a href="<?php echo BASE_URL.'/index.php/api/elements/'.$key ?>">
                                <?php echo BASE_URL.'/index.php/api/elements/'.$key  ?>
                            </a>
                        </li>
                        <?php }?>
                    </ol>
                    <hr />
                    <p class="text-center">&copy Eko Heri Susanto</p>
                </div>
            </div>
        </div>
    </div> 
</div>
</body>
</html>