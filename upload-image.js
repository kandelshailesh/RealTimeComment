<?php 
session_start();
?>
var image_name='';
function noPreview() {
  $('#image-preview-div').css("display", "none");
  $('#preview-img').attr('src', 'noimage');
  $('upload-button').attr('disabled', '');
}

function selectImage(e) {
  $('#file').css("color", "green");
  $('#image-preview-div').css("display", "block");
  $('#preview-img').attr('src', e.target.result);
  $('#preview-img').css('max-width', '550px');
}

$(document).ready(function (e) {



  var maxsize = 500 * 1024; // 500 KB

  $('#max-size').html((maxsize/1024).toFixed(2));

  $('#upload-image-form').on('submit', function(e) {

    e.preventDefault();

    $('#message').empty();
    $('#loading').show();
    $.ajax({
      url: "upload-image.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function(data)
      {
        $('#loading').hide();
     
         // $('#message').html(data);
  var fname=$('#userfname').val();
  var lname=$('#userlname').val();
  var imageid='<?php echo $_SESSION['uploadimageid'];?>';
  alert(imageid);
  var imagelocation="Images/".concat(image_name)
  var imageadd='<div class="col-12"><br><a><h4>'+fname+' '+lname+'</h4></a><br><img style="width:100%; height="300" src="'+imagelocation+'"></div>';
  var listcommentadd='<div id="comment" class="col-12"><div style="margin-top:4px; outline:3px solid #EEE;"><div class="row" style="height: 40px;"><div class="col-md-4"></div><div class="col-md-4"><button id='+imageid+'style=" background-color:white; font-size:15px; border:0px; padding-top:10px;" onclick="showcomment('+imageid+')" class="pull-right">Comment <p  style=" margin-left:80px; margin-top: -32px;" >0</p> </button></div><div class="col-md-4"></div></div></div></div>';
  alert(listcommentadd);
  $('#imageaddition').prepend(imageadd,listcommentadd);
      }
    });

  });

  $('#file').change(function() {

    $('#message').empty();

    var file = this.files[0];
    image_name=file.name;
    var match = ["image/jpeg", "image/png", "image/jpg"];

    if ( !( (file.type == match[0]) || (file.type == match[1]) || (file.type == match[2]) ) )
    {
      noPreview();

      $('#message').html('<div class="alert alert-warning" role="alert">Unvalid image format. Allowed formats: JPG, JPEG, PNG.</div>');

      return false;
    }

    if ( file.size > maxsize )
    {
      noPreview();

      $('#message').html('<div class=\"alert alert-danger\" role=\"alert\">The size of image you are attempting to upload is ' + (file.size/1024).toFixed(2) + ' KB, maximum size allowed is ' + (maxsize/1024).toFixed(2) + ' KB</div>');

      return false;
    }

    $('#upload-button').removeAttr("disabled");

    var reader = new FileReader();
    reader.onload = selectImage;
    reader.readAsDataURL(this.files[0]);

  });

});