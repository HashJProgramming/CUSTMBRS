// Enter your imgbb api key below 

var apikey = "";


/*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $('#upload').on('change', function () {
        readURL(input);
        uploadimage('upload')
    });
});


/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' );
var urllink = document.getElementById( 'urllink' );


input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
  

}

function uploadimage(input_tag) {

var file = document.getElementById(input_tag);
var form = new FormData();
form.append("image", file.files[0])

var settings = {
  "url": "https://api.imgbb.com/1/upload?key="+apikey,
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};


$.ajax(settings).done(function (response) {
  console.log(response);
  var jx = JSON.parse(response);
  console.log(jx.data.url);
  urllink.innerHTML = jx.data.url ;

});
}


$(document).on('dragstart dragenter dragover', function(event) {    
        $('#image-drag-drop').removeClass('d-none');     // Show the drop zone
    dropZoneVisible= true;
    
}).on('drop dragleave dragend', function (event) {

    
    dropZoneTimer= setTimeout( function(){
        if( !dropZoneVisible ) {
            $('#image-drag-drop').addClass('d-none'); 
        }
    }, 50   ); // dropZoneHideDelay= 70, but anything above 50 is better
    clearTimeout(dropZoneTimer);
        

});