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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>
    <div class="container py-3">
        <div class="row">
            <div class="col">
                <form method="post" action="builderadmin/simpan" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="SelectElement" class="form-label">Jenis Element</label>
                        <select name="jenis_element" class="form-select" id="SelectElement"  aria-label="Default select example" aria-describedby="selectHelp">
                            <option selected>Pilih salah satu element</option>
                            <option value="navbar">Navbar</option>
                            <option value="header">Header</option>
                            <option value="content">Content</option>
                            <option value="footer">Footer</option>
                        </select>
                        <div id="selectHelp" class="form-text">Pilih salah satu element.</div>
                    </div>
                    <div class="mb-3">
                        <label for="InputIDElement" class="form-label">ID Element</label>
                        <input name="id_element"type="text" class="form-control" id="InputIDElement" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Gambar Element</label>
                        <input name="img_element" class="form-control" type="file" id="formFile">
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea name="script_html" class="form-control" placeholder="Isi script HTML disini" id="floatingTextareaHTML"></textarea>
                        <label for="floatingTextareaHTML">Script HTML</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea name="script_css" class="form-control" placeholder="Isi script CSS disini" id="floatingTextareaCSS"></textarea>
                        <label for="floatingTextareaCSS">Script CSS</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <textarea name="script_js" class="form-control" placeholder="Isi script JS disini" id="floatingTextareaJS"></textarea>
                        <label for="floatingTextareaJS">Script CSS</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>