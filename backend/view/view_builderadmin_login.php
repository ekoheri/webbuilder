<html>
<head>
    <title>Web Builder Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-6">
                <form method="post" action="submitlogin">
                    <h1 class="h3 mb-3 fw-normal">Silahkan Login</h1>
                    <div class="form-floating">
                        <input type="email" name="username" class="form-control" id="floatingInput" />
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="passwd" class="form-control" id="floatingPassword" />
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>