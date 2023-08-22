/* 
Nama Class   : ajax 
Fungsi Class : untuk melakukan komunikasi data denganbackend server 
*/
ajax = function() {
    /* Sesuaikan URL API dengan alamat backend */
    this.url_api = 'https://adminwb.gadawangi.com/index.php/api/';

    /* Sesuaikan API KEy dengan API Key yang terdaftar di backend */
    this.api_key = 'adc31a54cbc7896b3f093c1d9cf29080';
    
    this.ContainerLoading = null;

    this.sendRequest = function (method, url_target, data) {
        var url = this.url_api + url_target;
        var api_key = this.api_key;
        const ContainerLoading = this.ContainerLoading;
        const ShowLoading = this.ShowLoading();
        return new Promise(function(resolve, reject){
            /* new instance dari object XMLHttpRequest */
            var http = new XMLHttpRequest();

            /* Membuka koneksi dengan backend server */
            http.open(method, url);

            /* Set header */
            http.setRequestHeader("Cache-Control", "no-cache");
            http.setRequestHeader("api-key", api_key);

            /* Event ketika memulai memuat data dari backend */
            http.onloadstart = function() {
                ContainerLoading.innerHTML = '';
                ContainerLoading.appendChild(ShowLoading);
            }

            /* Event ketika berhasil mendapatlan data dari backend */
            http.onload = function() {
                if(http.readyState == 4 && http.status == 200){
                    var response = http.responseText;
                    resolve(response);
                }
            }
            
            /* Event ketika gagal melakukan koneksi ke backend */
            http.onerror = reject;

            /* Kirim permintaan (request) data ke backend */
            http.send(data);
        });
    }

    /* Method untuk menampilkan gambar loading ketika request dari backend blm selesai */
    this.ShowLoading = function () {
        var divElement = document.createElement("div");
        divElement.style.textAlign = "center";
        divElement.style.padding = "30px";
        divElement.style.height = "100%";

        var imgElement = document.createElement("img");
        imgElement.src = "images/loading.gif";

        divElement.appendChild(imgElement);

        return divElement;
    }
}//end ajax

/* 
Nama Class   : HandleUI 
Fungsi Class : untuk menghandle event dan method pada tampilan (UI)
*/

HandleUI = function () {
    //Properti untuk meng-instansiasi class AJAX
    this.Service = null;

    //property untuk bagian header
    this.ListRequestElement = '';
    this.btnDownload = document.getElementById('btnDownload');

    //property untuk bagian SidebarItem
    this.ElementSelected = '';
    this.current_page = 1;
    this.total_pages = 0;

    this.btnSidebarItemNavbar = document.getElementById('btnSidebarItemNavbar');
    this.btnSidebarItemHeader = document.getElementById('btnSidebarItemHeader');
    this.btnSidebarItemContent = document.getElementById('btnSidebarItemContent');
    this.btnSidebarItemFooter = document.getElementById('btnSidebarItemFooter');
    this.btnSidebarItemPage = document.getElementById('btnSidebarItemPage');

    //property untuk bagian ProductMenu
    this.divProductMenu = document.getElementById('divProductMenu');
    this.btnCloseProductMenu = document.getElementById('btnCloseProductMenu');
    this.divElementSelected = document.getElementById('divElementSelected');
    this.btnPgntPrev = document.getElementById('btnPgntPrev');
    this.btnPgntNext = document.getElementById('btnPgntNext');
    this.divDisplayProductItem = document.getElementById('divDisplayProductItem');

    //property untuk bagian Content Canvas
    this.divContentCanvas = document.getElementById('divContentCanvas');

    //constanta generator Id element On the Fly
    this.IdProductItem = "IdProductItem-";
    this.IdElementContainer = "IdElementContainer-";
    this.IdFillElement = "IdFillElement-";

    //property untuk bagian  Modal Update Element
    this.IdElementSelected = '';
    this.IdImageSelected = '';

    this.ModalUpdateElement = document.getElementById('ModalUpdateElement');
    this.divUpdateCodeHTML = document.getElementById('divUpdateCodeHTML');
    this.divUpdateImage = document.getElementById('divUpdateImage');

    this.txtCodeHTML = document.getElementById('txtCodeHTML');
    this.inpFileImage = document.getElementById('inpFileImage');
    this.imgNewPicture = document.getElementById('imgNewPicture');
    this.inpImageWidth = document.getElementById('inpImageWidth');
    this.inpImageHeight = document.getElementById('inpImageHeight');

    this.btnCopyToCliboard = document.getElementById('btnCopyToCliboard');
    this.btnUpdateElement = document.getElementById('btnUpdateElement');

    // Method init
    this.init = function() {
        this.ShowToastTooltip();

        /* tampilkan element konten kosong */
        this.divContentCanvas.appendChild(this.ShowBlankContent());

        /* Instansiasi class ajax */
        this.Service = new ajax();
        this.Service.ContainerLoading = this.divDisplayProductItem;

        /* Mendefinisikan seluruh event yang dibutuhkan UI */
        this.btnDownload.addEventListener('click', function() {
            this.DownloadPage();
        }.bind(this));

        this.btnSidebarItemNavbar.addEventListener('click', function() {
            this.ShowProductMenu('navbar');
        }.bind(this));

        this.btnSidebarItemHeader.addEventListener('click', function() {
            this.ShowProductMenu('header');
        }.bind(this));

        this.btnSidebarItemContent.addEventListener('click', function() {
            this.ShowProductMenu('content');
        }.bind(this));

        this.btnSidebarItemFooter.addEventListener('click', function() {
            this.ShowProductMenu('footer');
        }.bind(this));

        this.btnSidebarItemPage.addEventListener('click', function() {
            this.ShowProductMenu('page');
        }.bind(this));

        this.btnCloseProductMenu.addEventListener('click', function() {
            this.HideProductMenu();
        }.bind(this));

        this.btnPgntPrev.addEventListener('click', function() {
            this.ShowProductPrev();
        }.bind(this));

        this.btnPgntNext.addEventListener('click', function() {
            this.ShowProductNext();
        }.bind(this));

        this.btnCopyToCliboard.addEventListener('click', function() {
            this.CopyToCliboard();
        }.bind(this));

        this.btnUpdateElement.addEventListener('click', function() {
            this.UpdateElement();
        }.bind(this));
    } //end method init

    this.ShowToastTooltip = function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
      
        const toastLiveExample = document.getElementById('liveToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
    }

    // Menmapilkan menu Product Element (navbar, header, content etc)
    this.ShowProductMenu = function(TypeProduct) {
        this.ElementSelected = TypeProduct;
        if((this.divProductMenu.style.display =="") || (this.divProductMenu.style.display =="none"))
            this.divProductMenu.style.display = "block";
        
        this.divElementSelected.innerHTML = TypeProduct;

        // Request data element ke backend
        this.Service.sendRequest('get', 'elements/'+TypeProduct.toLowerCase()+'/'+this.current_page, null)
        .then(function(result){
            // Jika request berhasil, maka baca data element-nya
            this.parsingDataElement(result);
        }.bind(this))
        .catch(function(error){
            // Jika request gagal, maka tampilkan error-nya
            console.log(error);
        });
    }

    // Menangani pagination prev
    this.ShowProductPrev = function() {
        if(this.current_page > 1) {
            this.current_page--;
            this.ShowProductMenu(this.ElementSelected);
          }
    }

    // Menangani pagination next
    this.ShowProductNext = function() {
        if(this.current_page < this.total_pages) {
            this.current_page++;
            this.ShowProductMenu(this.ElementSelected);
          }
    }

    // Menyembunyikan tampilan menu product
    this.HideProductMenu = function() {
        this.divProductMenu.style.display = "none";
    }

    // Menampilkan blank contemt yaitu ketika user belum memilih salah satu element
    this.ShowBlankContent = function() {
        var divContainer = document.createElement("div");
        divContainer.className = "GW_content_blank";

        var divBlankContent = document.createElement("div");
        divContainer.className = "GW_content_blank_fill";

        var svgBlank = '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">';
        svgBlank += '<path fill-rule="evenodd" clip-rule="evenodd" d="M0 4C0 1.79086 1.79086 0 4 0H8C10.2091 0 12 1.79086 12 4V16C12 18.2091 10.2091 20 8 20H4C1.79086 20 0 18.2091 0 16V4ZM4 2C2.89543 2 2 2.89543 2 4V16C2 17.1046 2.89543 18 4 18H8C9.10457 18 10 17.1046 10 16V4C10 2.89543 9.10457 2 8 2H4Z" fill="#6B7280"></path>';
        svgBlank += '<path fill-rule="evenodd" clip-rule="evenodd" d="M16 6C16 3.79086 17.7909 2 20 2H26C28.2091 2 30 3.79086 30 6V12C30 14.2091 28.2091 16 26 16H20C17.7909 16 16 14.2091 16 12V6ZM20 4C18.8954 4 18 4.89543 18 6V12C18 13.1046 18.8954 14 20 14H26C27.1046 14 28 13.1046 28 12V6C28 4.89543 27.1046 4 26 4H20Z" fill="#6B7280"></path>';
        svgBlank += '<path fill-rule="evenodd" clip-rule="evenodd" d="M16 23C16 21.3431 17.3431 20 19 20H29C30.6569 20 32 21.3431 32 23V25C32 26.6569 30.6569 28 29 28H19C17.3431 28 16 26.6569 16 25V23ZM19 22C18.4477 22 18 22.4477 18 23V25C18 25.5523 18.4477 26 19 26H29C29.5523 26 30 25.5523 30 25V23C30 22.4477 29.5523 22 29 22H19Z" fill="#6B7280"></path>';
        svgBlank += '<path fill-rule="evenodd" clip-rule="evenodd" d="M4 27C4 25.3431 5.34315 24 7 24H9C10.6569 24 12 25.3431 12 27V29C12 30.6569 10.6569 32 9 32H7C5.34315 32 4 30.6569 4 29V27ZM7 26C6.44772 26 6 26.4477 6 27V29C6 29.5523 6.44772 30 7 30H9C9.55228 30 10 29.5523 10 29V27C10 26.4477 9.55228 26 9 26H7Z" fill="#6B7280"></path>';
        svgBlank += '</svg>';
        var pSvg = document.createElement("p");
        pSvg.className = "text-center";
        pSvg.innerHTML = svgBlank;
        divBlankContent.appendChild(pSvg);

        var pMsg = document.createElement("p");
        pMsg.className = "text-center";
        pMsg.innerHTML = "Adding Section<br />Here";
        divBlankContent.appendChild(pMsg);

        divContainer.appendChild(divBlankContent);

        return divContainer;
    }

    //Menterjemahkan data element dari string ke array JSON
    this.parsingDataElement = function (response) {
        /* Mengkonversi String ke array JSON */
        var dataJson = JSON.parse(response);
        
        this.current_page = parseInt(dataJson.page);
        this.total_pages = parseInt(dataJson.total_pages);
        var dataElement = dataJson.data;
        
        // Validate page
        if(this.total_pages == 0) this.total_pages = 1;
        if (this.current_page < 1) this.current_page = 1;
        if (this.current_page > this.total_pages) this.current_page = this.total_pages;
        
        if(this.current_page == 1) {
            this.btnPgntPrev.style.visibility = 'hidden';
        } else {
            this.btnPgntPrev.style.visibility = 'visible';
        }
      
        if (this.current_page == this.total_pages) {
            this.btnPgntNext.style.visibility = "hidden";
        } else {
            this.btnPgntNext.style.visibility = "visible";
        }
         
        // menampilkan element pada menu product
        this.DrawElements(dataElement);
    }

    // Method untuk menampilkan element pada menu product
    this.DrawElements = function (dataElement) {
        /* Mengosongkan daftar Product Element */
        this.divDisplayProductItem.innerHTML = "";

        for(var i = 0; i < dataElement.length; i++){
            /* 
            Membuat element DIV product item. Isi dari divItem adalah :
            a. Gambar product yg dikirim dari backend
            b. hyperlink (+)
            c. divHTML untuk menampung script HTML dari backend
            */
            var divItem = document.createElement("div");
            divItem.className = "GW_productsItem_item";

            /* Menampilkan gambar product item */
            var imgItem = document.createElement("img");
            imgItem.src = dataElement[i]['image'];
            divItem.appendChild(imgItem);

            /* Menampilkan hyperlink TAMBAH dari daftar product ke Content */
            var aItem = document.createElement("a");
            aItem.href = "#";

            /* Dikarenakan idItem itu akan digunakan pada fungsi AddListener, maka harus dibuat const  */
            const idItem = dataElement[i]['id'];
            
            /* Menambahkan event click untuk menabhkan element ke canvas */
            aItem.addEventListener("click", function() {
                this.AddElement(idItem);
            }.bind(this), false);

            /* Menampilkan icon + SVG */
            var svgItem = '<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">';
            svgItem += '<circle cx="18" cy="18" r="18" fill="#FF5525"></circle>';
            svgItem += '<path fill-rule="evenodd" clip-rule="evenodd" d="M18 11.25C18.1989 11.25 18.3897 11.329 18.5303 11.4697C18.671 11.6103 18.75 11.8011 18.75 12V18C18.75 18.1989 18.671 18.3897 18.5303 18.5303C18.3897 18.671 18.1989 18.75 18 18.75H12C11.8011 18.75 11.6103 18.671 11.4697 18.5303C11.329 18.3897 11.25 18.1989 11.25 18C11.25 17.8011 11.329 17.6103 11.4697 17.4697C11.6103 17.329 11.8011 17.25 12 17.25H17.25V12C17.25 11.8011 17.329 11.6103 17.4697 11.4697C17.6103 11.329 17.8011 11.25 18 11.25Z" fill="white">';
            svgItem += '</path>';
            svgItem += '<path fill-rule="evenodd" clip-rule="evenodd" d="M17.25 18C17.25 17.8011 17.329 17.6103 17.4697 17.4697C17.6103 17.329 17.8011 17.25 18 17.25H24C24.1989 17.25 24.3897 17.329 24.5303 17.4697C24.671 17.6103 24.75 17.8011 24.75 18C24.75 18.1989 24.671 18.3897 24.5303 18.5303C24.3897 18.671 24.1989 18.75 24 18.75H18.75V24C18.75 24.1989 18.671 24.3897 18.5303 24.5303C18.3897 24.671 18.1989 24.75 18 24.75C17.8011 24.75 17.6103 24.671 17.4697 24.5303C17.329 24.3897 17.25 24.1989 17.25 24V18Z" fill="white">';
            svgItem += '</path>';
            svgItem += '</svg>';
            aItem.innerHTML = svgItem;
            divItem.appendChild(aItem);

            /* Menampung element HTML dari backend ke div. Hanya div ini di-sebunyikan (hidden) */
            var divHtml = document.createElement("div");
            divHtml.id = this.IdProductItem+dataElement[i]['id'];
            divHtml.hidden = true;
            divHtml.innerHTML = this.StringToHTML(dataElement[i]['html']);
            divItem.appendChild(divHtml);

            /* Menambahkan divItem menjadi anaknya divDisplayProductItem */
            this.divDisplayProductItem.appendChild(divItem);
        }
    }

    this.AddElement = function (idItem) {
        /*Membuat element DIV untuk menampung element HTML */
        var divElementContainer = document.createElement("div");
        divElementContainer.id = this.IdElementContainer+idItem;
        divElementContainer.className = "GW_content_fill";

        var divFillContent = document.createElement("div");
        divFillContent.className = "GW_content_fill_content";
        divFillContent.id = this.IdFillElement+idItem;
        divFillContent.innerHTML = document.getElementById(this.IdProductItem+idItem).innerHTML;
        divElementContainer.appendChild(divFillContent);

        /* Membuat element DIV untuk menampung pilihan Menampilkan Code HTML (aCode) dan Hapus Element (aTrash)*/
        var divAction = document.createElement('div');
        divAction.className = 'GW_content_action';

        var aCode = document.createElement('a');
        aCode.href = '#';
        aCode.setAttribute("data-toggle", "modal");
        aCode.setAttribute("data-target", "#ModalUpdateElement");
        aCode.addEventListener("click", function () {
            this.ShowModal(idItem,'element-copy');
        }.bind(this));

        var svgACode = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="48px" height="48px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" xmlns:xlink="http://www.w3.org/1999/xlink">';
        svgACode += '<g><path style="opacity:0.882" fill="#85c7c3" d="M 14.5,3.5 C 37.3201,0.153078 46.8201,9.81974 43,32.5C 40.8333,37.3333 37.3333,40.8333 32.5,43C 6.85917,46.0186 -1.97417,35.1852 6,10.5C 8.44117,7.54644 11.2745,5.21311 14.5,3.5 Z"/></g>';
        svgACode += '<g><path style="opacity:1" fill="#99cecb" d="M 25.5,14.5 C 25.56,13.9569 25.8933,13.6236 26.5,13.5C 27.2745,15.3964 28.2745,17.063 29.5,18.5C 28.6618,18.8417 28.3284,19.5084 28.5,20.5C 27.0413,20.4326 25.7079,20.7659 24.5,21.5C 25.0138,19.6336 25.6805,17.8003 26.5,16C 26.4301,15.2352 26.0967,14.7352 25.5,14.5 Z"/></g>';
        svgACode += '<g><path style="opacity:1" fill="#daecea" d="M 15.5,18.5 C 16.675,18.281 17.675,18.6143 18.5,19.5C 16.3761,20.458 14.3761,21.6246 12.5,23C 14.3451,24.4229 16.3451,25.5896 18.5,26.5C 14.984,27.0901 11.984,25.9235 9.5,23C 11.3584,21.2453 13.3584,19.7453 15.5,18.5 Z"/></g>';
        svgACode += '<g><path style="opacity:1" fill="#dfeeed" d="M 25.5,14.5 C 26.0967,14.7352 26.4301,15.2352 26.5,16C 25.6805,17.8003 25.0138,19.6336 24.5,21.5C 23.2718,24.9563 21.7718,28.2896 20,31.5C 20.3376,25.3211 22.171,19.6545 25.5,14.5 Z"/></g>';
        svgACode += '<g><path style="opacity:1" fill="#d9ebe9" d="M 29.5,18.5 C 38.8981,21.7035 38.7314,24.7035 29,27.5C 28.5,27.1667 28,26.8333 27.5,26.5C 29.3359,25.081 31.3359,23.9143 33.5,23C 31.8068,22.1534 30.1401,21.3201 28.5,20.5C 28.3284,19.5084 28.6618,18.8417 29.5,18.5 Z"/></g>';
        svgACode += '</svg>';
        aCode.innerHTML = svgACode;
        divAction.appendChild(aCode); 

        var aTrash = document.createElement('a');
        aTrash.href = '#';
        aTrash.addEventListener("click", function() {
            this.RemoveElement(idItem);
        }.bind(this));

        var svgATrash = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="48px" height="48px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" xmlns:xlink="http://www.w3.org/1999/xlink">';
        svgATrash += '<g><path style="opacity:0.866" fill="#ff416d" d="M 14.5,3.5 C 37.3201,0.153078 46.8201,9.81974 43,32.5C 40.8333,37.3333 37.3333,40.8333 32.5,43C 6.85917,46.0186 -1.97417,35.1852 6,10.5C 8.44117,7.54644 11.2745,5.21311 14.5,3.5 Z"/></g>';
        svgATrash += '<g><path style="opacity:1" fill="#ffd0d6" d="M 28.5,14.5 C 27.8333,18.5 27.1667,18.5 26.5,14.5C 23.6748,14.1616 21.5082,15.1616 20,17.5C 19.5172,16.552 19.3505,15.552 19.5,14.5C 22.3833,11.9103 25.3833,11.9103 28.5,14.5 Z"/></g>';
        svgATrash += '<g><path style="opacity:1" fill="#ff6180" d="M 19.5,14.5 C 19.3505,15.552 19.5172,16.552 20,17.5C 21.5082,15.1616 23.6748,14.1616 26.5,14.5C 27.1667,18.5 27.8333,18.5 28.5,14.5C 29.404,15.209 29.7373,16.209 29.5,17.5C 31.099,17.2322 32.4324,17.5655 33.5,18.5C 27.1667,18.5 20.8333,18.5 14.5,18.5C 15.5676,17.5655 16.901,17.2322 18.5,17.5C 18.2627,16.209 18.596,15.209 19.5,14.5 Z"/></g>';
        svgATrash += '<g><path style="opacity:1" fill="#ffccd3" d="M 14.5,18.5 C 20.8333,18.5 27.1667,18.5 33.5,18.5C 31.9238,22.951 31.0905,27.6177 31,32.5C 26.5868,33.6324 22.0868,33.7991 17.5,33C 17,32.5 16.5,32 16,31.5C 15.7083,27.118 15.2083,22.7847 14.5,18.5 Z"/></g>';
        svgATrash += '<g><path style="opacity:1" fill="#ff436f" d="M 18.5,20.5 C 22.1667,20.5 25.8333,20.5 29.5,20.5C 29.5,24.1667 29.5,27.8333 29.5,31.5C 25.8333,31.5 22.1667,31.5 18.5,31.5C 18.5,27.8333 18.5,24.1667 18.5,20.5 Z"/></g>';
        svgATrash += '</svg>';
        aTrash.innerHTML = svgATrash;
        divAction.appendChild(aTrash); 
        divElementContainer.appendChild(divAction);
        
        /* Menampung ID element ke text input hidden IdRequestElement */
        var obj_json;
        if(this.ListRequestElement == '') {
            obj_json = [];
            obj_json.push({element : idItem, user : ''});
            this.ListRequestElement = JSON.stringify(obj_json);
            /* Kosongkan Content */
            this.divContentCanvas.innerHTML = '';
        } else {
            obj_json = JSON.parse(this.ListRequestElement);
            obj_json.push({element : idItem, user : ''});
            this.ListRequestElement = JSON.stringify(obj_json);
        }
        /* Menambahkan divFillContent dan divAction menjadi anaknya divContentCanvas */
        this.divContentCanvas.appendChild(divElementContainer);

        this.HideProductMenu();

        // Cari seluruh element yang mengandung class "GW_Editable"
        // Jika ditemukan, maka element itu boleh di-edit
        this.DetectEditableObject();
    }

    /* Method untuk menghapus element yang tidak digunakan oleh user */
    this.RemoveElement = function(idItem) {
        /* Menghapus Element di divContentCanvas */
        document.getElementById(this.IdElementContainer+idItem).remove();

        /* Convert dari String ke array JSON */
        var obj_json = JSON.parse(this.ListRequestElement);

        // Cari index array dari element yg dihapus oleh user
        const idxObj = obj_json.findIndex(object => {
            return object.elemen === idItem;
        });

        //Hapus array jika index-nya sesuai
        obj_json.splice(idxObj, 1);
        
        /* Element yang tidak dihapus, tuliskan ulang di variable this.ListRequestElement */
        var listReqElement = JSON.stringify(obj_json);
        if(listReqElement == '[]') {
            listReqElement = '';
            /* Jika konten kosong, maka tampilkan element blank */
            this.divContentCanvas.appendChild(this.ShowBlankContent());
        }
        this.ListRequestElement = listReqElement;
    }

    /* Method untuk mendownload element HTML menjadi file index.html */
    this.DownloadPage = function() {
        // Jika divContentCanvas kosong, maka tidak ada yg bisa di-download
        if(this.ListRequestElement == '') {
            alert("Tidak ada element HTML yang dipilih!");
            return;
        }

        /* Generate page HTML bagian head */
        var docHtml = document.implementation.createHTMLDocument();

        /* Generate page HTML meta */
        var meta = document.createElement('meta');
        meta.name = 'viewport';
        meta.content = "width=device-width, initial-scale=1";

        /* Generate page HTML title */
        var title = document.createElement("title"); 
        title.innerHTML = 'Gadawangi Web Builder';
        docHtml.head.appendChild(title);

        /* Generate link CSS yg referensi-nya ke link bootstrap */
        var link = document.createElement("link");
        link.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css';
        link.rel = 'stylesheet';
        docHtml.head.appendChild(link);

        /* Generate page HTML bagian body. Bagian ini diambil dari divFillContent */
        var listReqElement = JSON.parse(this.ListRequestElement);
        for(var i = 0; i < listReqElement.length; i++){
            var section = document.createElement("section");
            section.id = listReqElement[i]['element'];
            section.innerHTML = document.getElementById(this.IdFillElement+listReqElement[i]['element']).innerHTML;
            
            docHtml.body.appendChild(section);
        }

        // Hapus class yang mengandung kata "GW_Editable" dan id-nya
        var objHtml = docHtml.body.getElementsByClassName('GW_Editable');
        for(var j = 0; j < objHtml.length; j++) {
            objHtml[j].removeAttribute('id');
            objHtml[j].classList.remove("GW_Editable");
        }

        /* Generate script JS dgn referensi ke bootstrap */
        var jsscript = document.createElement("script");
        jsscript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js';
        docHtml.body.appendChild(jsscript);

        /* Convert Object HTML ke String */
        var htmlFromObj = docHtml.getElementsByTagName('html');
        var htmlString = '<html>'+'\r\n';
        htmlString += htmlFromObj[0].innerHTML+'\r\n';
        htmlString += '</html>';
        
        /* Eksekusi perintah download menjadi file index.html */
        var blob = new Blob([htmlString], { type: 'text/plain;charset=utf-8' });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "index.html";
        link.click();
    }

    /* Method untuk menampilkan Kode Script HTML element yg dipilih user */
    this.ShowModal = function(idItem, HtmlType) {
        let modal = bootstrap.Modal.getOrCreateInstance(this.ModalUpdateElement);
        // Jika yang ditampilkan adalah script element utuh, maka yg diijinkan hanya meng-copy saja
        if(HtmlType == 'element-copy') {
            this.IdElementSelected = this.IdFillElement + idItem;
            this.IdImageSelected = '';
            this.btnCopyToCliboard.hidden = false;
            this.btnUpdateElement.hidden = true;
            this.divUpdateCodeHTML.hidden = false;
            this.divUpdateImage.hidden = true;
            // Value TextArea Kode HTMl diambil dari isi HTML element yg dipilih
            this.txtCodeHTML.value = document.getElementById(this.IdElementSelected).innerHTML;
        } else if(HtmlType == 'tag-edit') {
            this.IdElementSelected = idItem;
            this.IdImageSelected = '';
            this.btnCopyToCliboard.hidden = true;
            this.btnUpdateElement.hidden = false;
            this.divUpdateCodeHTML.hidden = false;
            this.divUpdateImage.hidden = true;
            // Value TextArea Kode HTMl diambil dari isi HTML element yg dipilih
            this.txtCodeHTML.value = document.getElementById(this.IdElementSelected).innerHTML;
        } else if(HtmlType == 'img-edit') {
            this.IdElementSelected = '';
            this.IdImageSelected = idItem;
            this.btnCopyToCliboard.hidden = true;
            this.btnUpdateElement.hidden = false;
            this.divUpdateCodeHTML.hidden = true;
            this.divUpdateImage.hidden = false;
            this.txtCodeHTML.value = '';
            this.ChangeImage(idItem);
        }
        modal.show();
    }

    /* Method untuk meng-copy ke clipboard */
    this.CopyToCliboard = function() {
        let modal = bootstrap.Modal.getOrCreateInstance(this.ModalUpdateElement);
        try {
            navigator.clipboard.writeText(this.txtCodeHTML.value);
        } catch(err) {
            this.txtCodeHTML.focus();
            this.txtCodeHTML.select();
            document.execCommand('copy');
        }
        modal.hide();
    }

    /* 
    Method untuk mendeteksi element mana saja yang boleh di-edit oleh user 
    Cirinya, jika di element class-nya mengandung kata "GW_Editable"
    */
    this.DetectEditableObject = function() {
        //Cari diseluruh element yg class-nya mengandung GW_Editable
        var obj = this.divContentCanvas.getElementsByClassName('GW_Editable');

        // Baca seluruh element yg mengandung kata GW_Editable
        for(var i = 0; i < obj.length; i++) {
            // baca jenis element (tagName). Misal a, img, div dsb
            var tagObj = obj[i].tagName.toLowerCase();

            // setting id elementnya
            const tagId = 'Id-'+tagObj+'-'+i;
            obj[i].id = tagId;

            /*
            Jika tagName-nya adalah image, maka tambahkan event click untuk Ganti Gambar (ChangeImage)
            Selain IMG, maka tambahkan event click untuk tampilkan kode HTML (ShowModalCode)
            */
            if(tagObj == 'img') {
                obj[i].addEventListener('click', function() {
                    this.ShowModal(tagId, 'img-edit')
                }.bind(this));
            } else {
                obj[i].addEventListener('click', function() {
                    this.ShowModal(tagId, 'tag-edit');
                }.bind(this));
            }
        }
    }
    
    /* Method untuk merubah gambar */
    this.ChangeImage = function(tagId) {
        // Membuat canvas untuk menggambar kalimat "Upload Gambar bro!"
        var canvas = document.createElement("canvas");
        canvas.width = 300;
        canvas.height = 300;
        var ctx = canvas.getContext('2d');
        ctx.font = "20px Arial";
        var text = "Upload gambarnya bro!";
        ctx.fillText(text,10,150);
        
        this.ImageSelected = tagId;
        this.imgNewPicture.src = canvas.toDataURL();
        this.imgNewPicture.style.width = "100%";
        this.imgNewPicture.style.height = "300px";
        this.inpFileImage.addEventListener('change', function() {
            // Subroutine untuk merubah gambar menjadi Base64
            let file = this.inpFileImage.files[0];
            let reader = new FileReader();
            const newImg = this.imgNewPicture;
            reader.onloadend = function() {
                newImg.src = reader.result;
            }
            reader.readAsDataURL(file);
        }.bind(this));
    }

    /* Method untuk Meng-update script HTML atau gambar jika element-nya di-edit oleh user */
    this.UpdateElement = function() {
        let modal = bootstrap.Modal.getOrCreateInstance(this.ModalUpdateElement);
        if(this.IdImageSelected != '') {
            var oldImg = document.getElementById(this.ImageSelected);

            /* Merubah gambar dari gambar lama ke gambar baru yg di-upload user */
            oldImg.src = this.imgNewPicture.src;
            oldImg.style.width = this.inpImageWidth.value+"px";
            oldImg.style.height = this.inpImageHeight.value+"px";
        }
        else if(this.IdElementSelected != '') {
            document.getElementById(this.IdElementSelected).innerHTML = this.txtCodeHTML.value;            
        }
        modal.hide();
    }

    /* Method untuk meng-konversi dari String ke HTML */
    this.StringToHTML = function(str) {
        /* Convert String ke HTML. Merubah &lt; ke < &gt; ke > dst */
        let txt = new DOMParser().parseFromString(str, "text/html");
        return txt.documentElement.textContent;
    }

} //End GWBuilderJs

// Fungsi Bootstrap untuk mulai menjalakan class HandleUI
window.addEventListener('load', () => {
    var hUI = new HandleUI();
    hUI.init();
});