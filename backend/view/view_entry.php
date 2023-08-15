    <div class="container py-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Silahkan entry element disini!</h2>
                        <form method="post" action="simpan" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="SelectElement" class="form-label">Jenis Element</label>
                                <select name="jenis_element" class="form-select" onchange="PilihElement(this.value)" id="SelectElement" aria-describedby="selectHelp">
                                    <option value="" selected>Pilih salah satu element</option>
                                    <option value="navbar">Navbar</option>
                                    <option value="header">Header</option>
                                    <option value="content">Content</option>
                                    <option value="footer">Footer</option>
                                    <option value="page">Page</option>
                                </select>
                                <div id="selectHelp" class="form-text">Jenis element harus diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="InputIDElement" class="form-label">ID Element</label>
                                <input name="id_element" id ="IdElement" type="text" class="form-control" id="InputIDElement" aria-describedby="idElementHelp" />
                                <div id="idElementHelp" class="form-text">ID Element sudah terisi otomatis. Namun anda boleh menggantinya</div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Gambar Element</label>
                                <input name="img_element" class="form-control" type="file" id="formFile" aria-describedby="imgFileHelp">
                                <div id="imgFileHelp" class="form-text">Gambar element harus diisi.</div>
                            </div>
                            <div class="mb-3 form-floating">
                                <textarea name="script_html" class="form-control" placeholder="Isi script HTML disini" id="floatingTextareaHTML" style="height:200px;"></textarea>
                                <label for="floatingTextareaHTML">Tambahkan script HTML disini</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
        function PilihElement(pilihan) {
            const data = {<?php
                $isi = ''; 
                foreach($jumlah_data as $key => $value) {
                    if($isi == '')
                        $isi = $key . ":" . $value;
                    else
                        $isi .= ",".$key . ":" . $value;
                }
                echo $isi;
                ?>};
            if(pilihan != '') {
                document.getElementById('IdElement').value = pilihan+"-"+(data[pilihan]+1);
            }
        }
    </script>        
    