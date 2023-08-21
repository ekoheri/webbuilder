/* 
Konfigurasi :
1. Sesuaikan alamat URL (url_api) ini dengan alamat URL backend 
2. Sesuaikan api_key ini dengan API key yang ada di backend 
*/
var url_api = 'http://localhost:8080/index.php/api/';
var api_key = 'e06d73e710644d3462298c53f95c545a';

/* AJAX */
function createRequestObject() {
    /* Inisiasi fungsi API bawaan dari browser yaitu XMLHttpRequest */
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var http = createRequestObject();

function sendRequest(method, url_target, data) {
    /* Open : membuka koneksi ke backend */
    http.open(method, url_api+url_target);
    /* setRequestHeader : konfigurasi request header */
    http.setRequestHeader("Cache-Control", "no-cache");
    http.setRequestHeader("api-key", api_key);

    /* Eksekusi pengiriman data ke backend */
    http.send(data);

    /* 
      onloadstart : event ketika start memuat data dari backend. 
      Disini ditampilan gambar loading 
    */
    http.onloadstart = function() {
      document.getElementById('idProductItem').innerHTML == '';
      document.getElementById('idProductItem').appendChild(ShowLoading());
    }

    /* onloadstart : event ketika selesai memuat data dari backend */
    http.onload = function(){
        handleResponse();
    }
}

function handleResponse() {
  /* Menangani response dari backend */
  if(http.readyState == 4 && http.status == 200){
      var response = http.responseText;
      
      parsingDataElement(response);
  }
}

/* Handle UI */

/* Deteksi event body onload */
window.addEventListener('load', () => {
  /* untuk menampilkan tooltips */
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

  /* tampilkan element konten kosong */
  document.getElementById('IdContent').appendChild(ShowBlankContent());
  const toastLiveExample = document.getElementById('liveToast');
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
  toastBootstrap.show();
});

var current_page = 1;
var total_pages = 0;
var element_name = '';

function parsingDataElement(response) {
  /* Mengkonversi String ke array JSON */
  var dataJson = JSON.parse(response);
  
  current_page = parseInt(dataJson.page);
  total_pages = parseInt(dataJson.total_pages);
  var dataElement = dataJson.data;
  
  var btnPrev = document.getElementById('idBtnPrev');
  var btnNext = document.getElementById('idBtnNext');

  // Validate page
  if(total_pages == 0) total_pages = 1;
  if (current_page < 1) current_page = 1;
  if (current_page > total_pages) current_page = total_pages;
  
  if(current_page == 1) {
    btnPrev.style.visibility = 'hidden';
  } else {
    btnPrev.style.visibility = 'visible';
  }

  if (current_page == total_pages) {
    btnNext.style.visibility = "hidden";
  } else {
    btnNext.style.visibility = "visible";
  }
    
  DrawElements(dataElement);
}

function ShowBlankContent() 
{
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

function ShowLoading() 
{
  /* Menampilkan gambar loading ketika request dari backend blm selesai */
  var divElement = document.createElement("div");
  divElement.style.textAlign = "center";
  divElement.style.padding = "30px";
  divElement.style.height = "100%";

  var imgElement = document.createElement("img");
  imgElement.src = "images/loading.gif";

  divElement.appendChild(imgElement);

  return divElement;
}

/* Menampilkan form product + Request data product ke backend */
function ShowProduct(KategoriProduct)
{
  /* Menampilkan element daftar product */
  var ElementName = document.getElementById('idElementName');
  ElementName.innerHTML = KategoriProduct;

  var product = document.getElementById('IdProduct');
  if((product.style.display =="") || (product.style.display =="none"))
    product.style.display = "block";

  /* Request daftar product ke backend parameter {method, url, jobs, data} */
  sendRequest('get', 'elements/'+KategoriProduct.toLowerCase()+'/'+current_page, null);
}

function ShowProductPrev() {
  if(current_page > 1) {
    current_page--;
    var ElementName = document.getElementById('idElementName');
    ShowProduct(ElementName.innerHTML);
  }
}

function ShowProductNext() {
  if(current_page < total_pages) {
    current_page++;
    var ElementName = document.getElementById('idElementName');
    ShowProduct(ElementName.innerHTML);
  }
}
/* Menyembunyikan form menu product */
function HideProduct()
{
  /* Menyembunyikan element daftar product */
  var product = document.getElementById("IdProduct");
  product.style.display = "none";
  current_page = 1;
}

/* Menampilkan daftar product ke menu */
function DrawElements(dataElement)
{
  /* Mengosongkan daftar Product Element */
  document.getElementById('idProductItem').innerHTML = "";

  for(i = 0; i < dataElement.length; i++){
    /* 
      Membuat element DIV product item. Isi dari divItem adalah :
       a. Gambar product yg dikirim dari backend
       b. hyperlink (+)
       c. divHTL untuk menampung script HTML dari backend
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
    aItem.addEventListener("click", AddElement.bind(event, dataElement[i]['id']));

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
    divHtml.id = "IdProductItem-"+dataElement[i]['id'];
    divHtml.hidden = true;
    divHtml.innerHTML = StringToHTML(dataElement[i]['html']);
    divItem.appendChild(divHtml);

    /* Menambahkan divItem menjadi anaknya divProduct */
    document.getElementById('idProductItem').appendChild(divItem);
  }
}

/* Menampilkan product yg dipilih ke canvas element */
function AddElement(idItem)
{
  /*Membuat element DIV untuk menampung element HTML */
  var divContent = document.createElement("div");
  divContent.id = "IdElement-"+idItem;
  divContent.className = "GW_content_fill";

  var divFill = document.createElement("div");
  divFill.className = "GW_content_fill_content";
  divFill.id = "IdFillElement-"+idItem;
  divFill.innerHTML = document.getElementById('IdProductItem-'+idItem).innerHTML;
  divContent.appendChild(divFill);

  /* Membuat element DIV untuk menampung pilihan Code dan Hapus Element */
  var divAction = document.createElement('div');
  divAction.className = 'GW_content_action';

  var aCode = document.createElement('a');
  aCode.href = '#';
  aCode.addEventListener("click", ShowCode.bind(event, idItem));
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
  aTrash.addEventListener("click", RemoveElement.bind(event, idItem));
  var svgATrash = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="48px" height="48px" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" xmlns:xlink="http://www.w3.org/1999/xlink">';
  svgATrash += '<g><path style="opacity:0.866" fill="#ff416d" d="M 14.5,3.5 C 37.3201,0.153078 46.8201,9.81974 43,32.5C 40.8333,37.3333 37.3333,40.8333 32.5,43C 6.85917,46.0186 -1.97417,35.1852 6,10.5C 8.44117,7.54644 11.2745,5.21311 14.5,3.5 Z"/></g>';
  svgATrash += '<g><path style="opacity:1" fill="#ffd0d6" d="M 28.5,14.5 C 27.8333,18.5 27.1667,18.5 26.5,14.5C 23.6748,14.1616 21.5082,15.1616 20,17.5C 19.5172,16.552 19.3505,15.552 19.5,14.5C 22.3833,11.9103 25.3833,11.9103 28.5,14.5 Z"/></g>';
  svgATrash += '<g><path style="opacity:1" fill="#ff6180" d="M 19.5,14.5 C 19.3505,15.552 19.5172,16.552 20,17.5C 21.5082,15.1616 23.6748,14.1616 26.5,14.5C 27.1667,18.5 27.8333,18.5 28.5,14.5C 29.404,15.209 29.7373,16.209 29.5,17.5C 31.099,17.2322 32.4324,17.5655 33.5,18.5C 27.1667,18.5 20.8333,18.5 14.5,18.5C 15.5676,17.5655 16.901,17.2322 18.5,17.5C 18.2627,16.209 18.596,15.209 19.5,14.5 Z"/></g>';
  svgATrash += '<g><path style="opacity:1" fill="#ffccd3" d="M 14.5,18.5 C 20.8333,18.5 27.1667,18.5 33.5,18.5C 31.9238,22.951 31.0905,27.6177 31,32.5C 26.5868,33.6324 22.0868,33.7991 17.5,33C 17,32.5 16.5,32 16,31.5C 15.7083,27.118 15.2083,22.7847 14.5,18.5 Z"/></g>';
  svgATrash += '<g><path style="opacity:1" fill="#ff436f" d="M 18.5,20.5 C 22.1667,20.5 25.8333,20.5 29.5,20.5C 29.5,24.1667 29.5,27.8333 29.5,31.5C 25.8333,31.5 22.1667,31.5 18.5,31.5C 18.5,27.8333 18.5,24.1667 18.5,20.5 Z"/></g>';
  svgATrash += '</svg>';
  aTrash.innerHTML = svgATrash;
  divAction.appendChild(aTrash); 
  divContent.appendChild(divAction);
  
  /* Menampung ID element ke text input hidden IdRequestElement */
  var reqElement = document.getElementById('IdRequestElement').value;
  var obj_json;
  if(reqElement == '') {
    obj_json = [];
    obj_json.push({elemen : idItem, user : ''});
    document.getElementById('IdRequestElement').value = JSON.stringify(obj_json);
    /* Kosongkan Content */
    document.getElementById('IdContent').innerHTML = '';
  } else {
    obj_json = JSON.parse(reqElement);
    obj_json.push({elemen : idItem, user : ''});
    document.getElementById('IdRequestElement').value = JSON.stringify(obj_json);
  }

  /* Menambahkan divFill, divAction ke anaknya divContent */
  document.getElementById('IdContent').appendChild(divContent);

  HideProduct();

  DetectEditableObject()
}

/* Cek semua element yang mengandung class GW_Editable */
function DetectEditableObject() {
  var container = document.getElementById('IdContent');
  var obj = container.getElementsByClassName('GW_Editable');
  for(var i = 0; i < obj.length; i++) {
    //console.log(obj[i].tagName.toLowerCase());
    var tagObj = obj[i].tagName.toLowerCase();
    var tagId = 'Id-'+tagObj+'-'+i;
    if(obj[i].id == '') {
      obj[i].id = tagId;
      if(tagObj == 'img') {
        obj[i].addEventListener('click', ChangeImage.bind(event, tagId));
      } else {
        obj[i].addEventListener('click', ChangeHTML.bind(event, tagId));
      }
    }
  }
}

/* Tampilkan modal change image */
function ChangeImage(idImg) {
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalChangeImage'));
  document.getElementById('idImage').value = idImg;

  var canvas = document.createElement("canvas");
  canvas.width = 300;
  canvas.height = 300;
  var ctx = canvas.getContext('2d');
  ctx.font = "20px Arial";
  var text = "Upload gambarnya bro!";
  ctx.fillText(text,10,50);

  var newImg = document.getElementById('idNewImage');
  newImg.src = canvas.toDataURL();;
  newImg.style.width = "100%";
  newImg.style.height = "300px";
  document.getElementById('idImgWidth').value = "100";
  document.getElementById('idImgHeight').value = "100"
  modal.show();
}

/* Tampilkan modal change Script HTML */
function ChangeHTML(idElementHtml) {
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalChangeHTML'));
  document.getElementById('idElementHTML').value = idElementHtml;
  document.getElementById('idScriptHTML').value = '';
  document.getElementById('idScriptHTML').value = document.getElementById(idElementHtml).innerHTML
  modal.show();
}
/* Convert Image to Base64*/
function encodeImageFile(element) {
  let file = element.files[0];
  let reader = new FileReader();
  reader.onloadend = function() {
    var newImg = document.getElementById('idNewImage');
    newImg.src = reader.result;
  }
  reader.readAsDataURL(file);
}

/* Update Image */
function UpdateImage() {
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalChangeImage')); 
  var newImg = document.getElementById('idNewImage');
  var idImg = document.getElementById('idImage').value;

  var oldImg = document.getElementById(idImg);
  oldImg.src = newImg.src;
  oldImg.style.width = document.getElementById('idImgWidth').value+"px";
  oldImg.style.height = document.getElementById('idImgHeight').value+"px";
  modal.hide();
}

/* Update Script HTML */
function UpdateScriptHTML() {
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalChangeHTML'));
  var IdTarget = document.getElementById('idElementHTML').value;
  var newScript = document.getElementById('idScriptHTML').value;
  document.getElementById(IdTarget).innerHTML = newScript;
  modal.hide();
}

function ShowCode(idItem)
{
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalCode')); 
  /* Memindahkan element HTML dari Content ke TextArea */
  document.getElementById('idElementCode').value = idItem;
  document.getElementById('idCodeHTML').value = '';
  document.getElementById('idCodeHTML').value = document.getElementById('IdFillElement-'+idItem).innerHTML;
  modal.show();
}

function UpdateCode()
{
  /* Memindahkan element HTML dari TextArea ke Content */
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalCode'));
  var newCode = document.getElementById('idCodeHTML').value;
  var idTarget = document.getElementById('idElementCode').value;
  document.getElementById('IdFillElement-'+idTarget).innerHTML = newCode;
  modal.hide();
}

function CopyToCliboard()
{
  /* Men-copy tag HTML di content ke clipboard */
  let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('idModalCode'));
  var copyCode = document.getElementById('idCodeHTML');

  try {
    navigator.clipboard.writeText(copyCode.value);
  } catch(err) {
    copyCode.focus();
    copyCode.select();
    document.execCommand('copy');
  }         
  modal.hide();
}

function RemoveElement(idItem)
{
  /* Menghapus Element di Content */
  document.getElementById("IdElement-"+idItem).remove();

  /* Menghapus Daftar Element yg ada di Input Hidden IdRequestElement */
  var reqElement = document.getElementById('IdRequestElement').value;

  /* Convert dari String ke array JSON */
  var obj_json;
  obj_json = JSON.parse(reqElement);
  const idxObj = obj_json.findIndex(object => {
    return object.elemen === idItem;
  });

  /* Convert dari array JSON ke string dan tulis ke element input hidden IdRequestElement */
  obj_json.splice(idxObj, 1);
  var ele_selected = JSON.stringify(obj_json);
  if(ele_selected == '[]') {
    ele_selected = '';
    /* Jika konten kosong, maka tampilkan element blank */
    document.getElementById('IdContent').appendChild(ShowBlankContent());
  }
  document.getElementById('IdRequestElement').value = ele_selected;

}

function DownloadPage(){
    var data = document.getElementById('IdRequestElement').value;
    if(data == '') {
      alert("Tidak ada element HTML yang dipilih!");
    }
    else {
      /* Generate page HTML bagian head */
      var docHtml = document.implementation.createHTMLDocument();

      /* Generate meta */
      var meta = document.createElement('meta');
      meta.name = 'viewport';
      meta.content = "width=device-width, initial-scale=1";

      /* Generate title */
      var title = document.createElement("title"); 
      title.innerHTML = 'Gadawangi Web Builder';
      docHtml.head.appendChild(title);

      /* Generate link CSS dgn referensi ke bootstrap */
      var link = document.createElement("link");
      link.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css';
      link.rel = 'stylesheet';
      docHtml.head.appendChild(link);

      /*Generate page HTML bagian body */
      var dataJson = JSON.parse(data);
      for(var i = 0; i < dataJson.length; i++){
        var section = document.createElement("section");
        section.id = dataJson[i]['elemen'];
        section.innerHTML = document.getElementById('IdFillElement-'+dataJson[i]['elemen']).innerHTML;
        
        docHtml.body.appendChild(section);
      }

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
      
      /* Eksekusi perintah download HTML */
      var blob = new Blob([htmlString], { type: 'text/plain;charset=utf-8' });
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = "index.html";
      link.click();
    }
}

/* Helper */
function StringToHTML(str)
{
  /* Convert String ke HTML. Merubah &lt; ke < &gt; ke > dst */
  let txt = new DOMParser().parseFromString(str, "text/html");
  return txt.documentElement.textContent;
}