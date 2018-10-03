<script>
var image_name='';
var conn =new WebSocket('ws://localhost:9080/');

function noPreview() {
  $('#image-preview-div').css("display", "none");
  $('#preview-img').attr('src', 'noimage');
  $('upload-button').attr('disabled', '');
}

function selectImage(e) {
  $('#file').css("color", "green");
  $('#image-preview-div').css("display", "block");
  $('#preview-img').attr('src', e.target.result);
  $('#preview-img').css('max-width', '400px');
  $('#preview-img').css('max-height', '300px');

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
  result=JSON.parse(data)
        // alert(result.imageid);
  $('#loading').hide();
  $('#image-preview-div').hide();
  $('#file').val('');
  var fname=$('#userfname').val();
  var lname=$('#userlname').val();
  var imageid=result.imageid;
  // alert(imageid);
  var listcommentid="listcomment".concat(imageid);
  var commenttextid="commenttext".concat(imageid);
  var typecommentid="typecomment".concat(imageid);
  var imagelocation="Images/".concat(image_name);
  conn.send(JSON.stringify({'type':'photo','fname':fname,'lname':lname,'listcommentid':listcommentid,'commenttextid':commenttextid,'typecommentid':typecommentid,'imagelocation':imagelocation,'imageid':imageid}));
  
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
</script>