<section>
    <div class="container py-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5>Get API Key</h5>
                        <p>
                            <input type="text" class="form-control" readonly value="<?php echo $api_key ?>" />
                        </p>
                        <p>
                            <button type="button" class="btn btn-primary" onclick="ShowModalApiKey()">Change API Key</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
<div id="idModalApiKey" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="idFormApiKey" method="POST" action="<?php echo BASE_URL?>/index.php/admin/changetokenapi">
                <div class="modal-header">
                    <h5 class="modal-title">Change Token API Key</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="InputIDApiKey" class="form-label">Kalimat Token API</label>
                        <input name="token_word" type="text" class="form-control" id="InputIDApiKey" aria-describedby="idApiKeyHelp" />
                        <div id="idApiKeyHelp" class="form-text">Silahkan isi kalimat Token API yang baru</div>
                    </div>
                </div> <!-- modal body -->
                <div class="modal-footer justify-content-between">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="SubmitTokenApi()">Save</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div> <!-- modal footer -->
            </form>
        </div>
    </div>
</section>

<script language ="javascript">
    function ShowModalApiKey() {
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalApiKey'));
        modal.show();
    }

    function SubmitTokenApi() {
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalApiKey'));
        modal.hide();
        document.getElementById('idFormApiKey').submit();
    }
</script>