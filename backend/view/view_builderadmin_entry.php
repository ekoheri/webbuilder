    <div class="container py-3">
        <div class="row">
            <div class="col">
                <form method="post" action="simpan" enctype="multipart/form-data">
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
    