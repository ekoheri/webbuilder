<section>
    <div class="container py-3">
        <div class="row">
            <div class="col">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link<?php if($active=='navbar') echo ' active'?>" id="pills-navbar-tab" data-bs-toggle="pill" data-bs-target="#pills-navbar" type="button" role="tab" aria-controls="pills-navbar" aria-selected="true">Navbar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link<?php if($active=='header') echo ' active'?>" id="pills-header-tab" data-bs-toggle="pill" data-bs-target="#pills-header" type="button" role="tab" aria-controls="pills-header" aria-selected="false">Header</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link<?php if($active=='content') echo ' active'?>" id="pills-content-tab" data-bs-toggle="pill" data-bs-target="#pills-content" type="button" role="tab" aria-controls="pills-content" aria-selected="false">Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link<?php if($active=='footer') echo ' active'?>" id="pills-footer-tab" data-bs-toggle="pill" data-bs-target="#pills-footer" type="button" role="tab" aria-controls="pills-footer" aria-selected="false">Footer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link<?php if($active=='page') echo ' active'?>" id="pills-page-tab" data-bs-toggle="pill" data-bs-target="#pills-page" type="button" role="tab" aria-controls="pills-page" aria-selected="false">Page</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade<?php if($active=='navbar') echo ' show active'?>" id="pills-navbar" role="tabpanel" aria-labelledby="pills-navbar-tab" tabindex="0">
                        <?php echo $navbar; ?>
                    </div> <!-- div tab-navbar -->
                    <div class="tab-pane fade<?php if($active=='header') echo ' show active'?>" id="pills-header" role="tabpanel" aria-labelledby="pills-header-tab" tabindex="0">
                        <?php echo $header; ?>
                    </div> <!-- div tab-header -->
                    <div class="tab-pane fade<?php if($active=='content') echo ' show active'?>" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab" tabindex="0">
                        <?php echo $content; ?>
                    </div> <!-- div tab-content -->
                    <div class="tab-pane fade<?php if($active=='footer') echo ' show active'?>" id="pills-footer" role="tabpanel" aria-labelledby="pills-footer-tab" tabindex="0">
                        <?php echo $footer; ?>
                    </div><!-- div tab-footer -->
                    <div class="tab-pane fade<?php if($active=='page') echo ' show active'?>" id="pills-page" role="tabpanel" aria-labelledby="pills-page-tab" tabindex="0">
                        <?php echo $page; ?>
                    </div><!-- div tab-page -->
                </div> <!-- tab-content -->
            </div> <!-- Col -->
        </div> <!-- Row -->
        <p>&nbsp;</p>
        <div class="row">
            <div class="col">
            <?php echo $list_asset; ?>
            </div>
        </div> <!-- Row -->   
    </div> <!-- Container -->
</section>
<section>
    <div id="idModalEntry" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
                <form id="idFormEntry" method="POST" action="<?php echo BASE_URL?>/index.php/admin/save_element">
                    <div class="modal-header">
                        <h5 class="modal-title">Entry Element</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input hidden name="element_name" id ="IdNameElement" type="text" />
                        <div class="mb-3">
                            <label for="InputIDElement" class="form-label">ID Element</label>
                            <input readonly name="id_element" id ="IdElement" type="text" class="form-control" id="InputIDElement" aria-describedby="idElementHelp" />
                            <div id="idElementHelp" class="form-text">ID Element sudah terisi otomatis.</div>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Gambar Element</label>
                            <input name="img_element" class="form-control" type="file" id="formFile" aria-describedby="imgFileHelp" onchange="encodeImageFile(this)">
                            <div id ="imgFileHelp" class="form-text">Gambar element harus diisi.</div>
                            <textarea hidden name="img_base64" id="idNewImage"></textarea>
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea name="script_html" id="idScriptHtml" class="form-control" placeholder="Isi script HTML disini" id="floatingTextareaHTML" style="height:100px;"></textarea>
                            <label for="floatingTextareaHTML">Tambahkan script HTML disini</label>
                        </div>
                    </div> <!-- modal body -->
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-primary" onclick="SubmitElement()">Save</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div> <!-- modal footer -->
                </form>
            </div>
        </div>
    </div>
</section>
<section>
    <div id="idModalAsset" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="idFormAsset" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL?>/index.php/admin/save_asset">
                    <div class="modal-header">
                        <h5 class="modal-title">Entry Asset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formFileAsset" class="form-label">Gambar Asset</label>
                            <input name="img_asset[]" class="form-control" type="file" multiple="multiple" accept=”image/*” id="formFileAsset" aria-describedby="imgFileHelpAsset" >
                            <div id ="imgFileHelpAsset" class="form-text">Gambar asset ini bisa diisi jika memang ada asset yang akan disertakan. Contohnya asset gambar</div>
                        </div>
                    </div> <!-- Modal Body -->
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-primary" onclick="SubmitAsset()">Save</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div> <!-- modal footer -->
                </form>
            </div>
        </div>
    </div>
</section>
<script language="javascript">
    function ShowModal(ElementName) {
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalEntry'));
        document.getElementById('IdNameElement').value = ElementName;
        var LastId = document.getElementById('idLastElement-'+ElementName).innerHTML.split('-');
        var NewId = parseInt(LastId[1])+1;
        document.getElementById('IdElement').value = ElementName+'-'+NewId;
        document.getElementById('idNewImage').value = "";
        document.getElementById('idScriptHtml').value = "";
        modal.show();
    }
    function ShowModalAsset() {
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalAsset'));
        modal.show();
    }
    function SubmitElement(){
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalEntry'));
        modal.hide();
        document.getElementById('idFormEntry').submit();
    }
    function SubmitAsset(){
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalAsset'));
        modal.hide();
        document.getElementById('idFormAsset').submit();
    }
    /* Convert Image to Base64*/
    function encodeImageFile(element) {
        let file = element.files[0];
        let reader = new FileReader();
        reader.onloadend = function() {
        var newImg = document.getElementById('idNewImage');
        newImg.value = reader.result;
        }
        reader.readAsDataURL(file);
    }
    function EditElement(ElementName, Id) {
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalEntry'));
        document.getElementById('IdNameElement').value = ElementName;
        document.getElementById('IdElement').value = Id;
        document.getElementById('idNewImage').value = document.getElementById('IdPImg-'+Id).innerHTML
        document.getElementById('idScriptHtml').value = StringToHTML(document.getElementById('IdPHtml-'+Id).innerHTML);
        modal.show();
    }

    function StringToHTML(str)
    {
        /* Convert String ke HTML. Merubah &lt; ke < &gt; ke > dst */
        let txt = new DOMParser().parseFromString(str, "text/html");
        return txt.documentElement.textContent;
    }
</script>    