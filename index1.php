<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!-- <script src="upload-image.js"></script> -->


    <link rel="icon" href="http://getbootstrap.com/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <style>.navbar-inverse .navbar-nav > li > a { color: #DBE4E1; }
[hidden] {
  display: none !important;
}
</style>


	<title></title>
</head>
<body>
<div class="panel panel-default">
	<div class="panel-body">
		
		<a style="float:left; margin-left:13px;" href="logout.php" class=" btn btn-warning col-md-auto pull-right">Logout</a>
		<h5 style="float:left; margin-left:13px;" class="col-md-auto pull-right"><?php echo $_SESSION['username'];?></h5>
	</div>
</div>
<input id="userid" style="display: none;" type="number" value="<?php echo $_SESSION['userid'];?>">
<input id="userfname" style="display: none;" type="text" value="<?php echo $_SESSION['firstname'];?>">
<input id="userlname" style="display: none;" type="text" value="<?php echo $_SESSION['lastname'];?>">
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
   
<?php include 'upload.php' ?>
    <div class="container">

      <div style="max-width: 650px; margin: auto;">
        <p class="lead">Upload a Image</p>

        <form id="upload-image-form" action="" method="post" enctype="multipart/form-data">
          <div id="image-preview-div" style="display: none">
            <label for="exampleInputFile">Selected image:</label>
            <br>
            <img id="preview-img" src="noimage">
          </div>
          <div class="form-group">
          	<label class="btn btn-default">
    		Browse <input id="file" name="file" type="file" hidden>
				</label>
            <!-- <input style="height:50px; background-color:blue;" type="file" name="file" id="file" required> -->
          </div>
          <button class="btn btn-lg btn-primary" id="upload-button" type="submit" disabled>Upload image</button>
        </form>

        <br>
        <div class="alert alert-info" id="loading" style="display: none;" role="alert">
          Uploading image...
          <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
            </div>
          </div>
        </div>
        <div id="message"></div>
      </div>

      
    </div>


    
	</div>
</div>
<hr>
<div class="row">
<?php	

$conn = mysqli_connect("localhost", "root", "", "Comment");

$imagequery = mysqli_query($conn,"SELECT * from `image`");
while ($imagerow= mysqli_fetch_array($imagequery))
{
?>
<br>
	<div class="col-md-3"></div>
	<div class="col-md-4" style="border:3px solid #EEE; ">
		<div class="row" id="imageaddition">
			<div class="col-12">
				<?php 
				$uploaderid=$imagerow['UploaderID'];
				$usernamequery=mysqli_query($conn,"SELECT * from `User` where `UserID`=$uploaderid");
				$usernameresult=mysqli_fetch_array($usernamequery);?>
				<br>
				
				<a href="#"><h4><?php echo $usernameresult[1].' '.$usernameresult[2];?></h4></a>
				<br>
				<img src="<?php echo $imagerow['Imagelocation']; ?>" style="width:100%;" height="300">
				<p style="display:none;" id="imageid" ><?php echo $imagerow['ImageID']?></p>
	
			</div>
			
			<div id="comment" class="col-12">
				<div style="margin-top:4px; outline:3px solid #EEE;">

				<div class="row" style="height: 40px;">
					<div class="col-md-4"></div>
					<div class="col-md-4">
					
				<button id="<?php echo $imagerow['ImageID']; ?>" style=" background-color:white; font-size:15px; border:0px; padding-top:10px;" onclick="showcomment(<?php echo $imagerow['ImageID']; ?>)" class="pull-right">Comment <p  style=" margin-left:80px; margin-top: -32px;" ><?php echo $imagerow['count'];?></p> </button>
				

			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</div>
<div id="<?php echo "listcomment".$imagerow['ImageID'];?>" style=" display:none; border:2px solid #EEE; overflow-x:hidden; margin-left:12px; overflow-y: scroll; max-width:95%;  max-height: 300px;" class="col-12">
	<?php 
	$imageid=$imagerow['ImageID'];
	$conn = mysqli_connect("localhost", "root", "", "Comment");
		$commentquery=mysqli_query($conn,"SELECT * from `commentrecord` where `ImageID`
			=$imageid");	
		
			while($commentresult=mysqli_fetch_array($commentquery))
			{
				
				$userid=$commentresult['CommenterID'];
           	$userquery=mysqli_query($conn,"SELECT * from `User` where  `UserID`=$userid");
           	$userresult=mysqli_fetch_array($userquery);?>
           	<br>
           	<p style="display: inline-block; width:auto; border-radius: 5px; padding: 10px; background-color: #EEE;"><a href="www.facebook.com"><?php echo $userresult['Firstname']." ".$userresult['Lastname'];?></a> <?php echo $commentresult['Comment']?></p>
           	
           
<?php } ?>
           	<div style="display:none;" id="<?php echo 'feedback'.$imagerow['ImageID'];?>"> </div>

			
				</div>
			

<div id="<?php echo "typecomment".$imagerow['ImageID'];?>" style="display: none;"class="col-12">
           <div style="margin-top: -20px;">
           	<br>
			<input onkeydown="addcomment(event.key,<?php echo $imagerow['ImageID']; ?>)" id="<?php echo "commenttext".$imagerow['ImageID']; ?>" style="float:left; width:100%; height: 33px; border-radius: 5px; border:1px solid lightblue; " type="text">
			
				</div>
			</div>

		</div>
		</div>
			<div class="col-md-5"></div>
		
	
<?php }?>		
	</div>

	

<script>
	

// var conn =new WebSocket('ws://localhost:9080/');
// var message=$('#message').val();

function sendmessage(id)
{
	var commenttext="#commenttext".concat(id);
	var msg= $(commenttext).val();
	var userid=$("#userid").val();
	if(msg.length>0)
		{
		var fname=$('#userfname').val();
		var lname=$('#userlname').val();
	    var userid=$("#userid").val();
	    var countstart="#".concat(id);
		var count=countstart.concat(" p");
		var totalcount=$(count).text();	
		var totalcount=parseInt(totalcount)+1;
		conn.send(
		JSON.stringify({
						'type':'comment',
						'fname':fname,
						'lname':lname,
						'commentmsg':msg,
						'postid':id,
						'userid':userid,
						'totalcount':totalcount
					})
				);
		$(commenttext).val('');
			}
}

conn.onmessage = function(e)
			{
	var data = JSON.parse(e.data);
	switch(data.type) {
		case 'comment':
			var add='<br><p style="display: inline-block; width:auto; border-radius: 5px; padding: 10px; background-color: #EEE;"><a href="www.facebook.com">'+data.fname+' '+data.lname+ '</a>'+' '+data.commentmsg+' '+'</p>';
			var listcomment="#listcomment".concat(data.postid);
			$(listcomment).append(add);
			var countstart="#".concat(data.postid);
			var count=countstart.concat(" p");
			$(count).text(data.totalcount);	
			scrolltoend(data.postid);
			break;
		case 'typing':
			var feedback='#feedback'.concat(data.id);
			$(feedback).empty();
			$(feedback).show();
			$(feedback).prepend('<p>'+data.som+'</p>');
			break;

		case 'photo':
			var imageadd='<div class="col-12"><br><a href="http://www.facebook.com"><h4>'+data.fname+' '+data.lname+'</h4></a><br><img style="width:100%;" height="300" src="'+data.imagelocation+'"></div>';
  			var listcommentadd='<div id="comment" class="col-12"><div style="margin-top:4px; outline:3px solid #EEE;"><div class="row" style="height: 40px;"><div class="col-md-4"></div><div class="col-md-4"><button id="'+data.imageid+'" style="background-color:white; font-size:15px; border:0px; padding-top:10px;" onclick="showcomment('+data.imageid+')" class="pull-right">Comment <p  style=" margin-left:80px; margin-top: -32px;" >0</p> </button></div><div class="col-md-4"></div></div></div></div>'
  			var finalcommentadd='<div id="'+data.listcommentid+'" style=" display:none; border:2px solid #EEE; overflow-x:hidden; margin-left:12px; overflow-y: scroll; max-width:95%;  max-height: 300px;" class="col-12"></div>';
  			var final='<div id="'+data.typecommentid+'" style="display: none;"class="col-12"><div style="margin-top: -20px;"><br><input onkeydown="addcomment(event.key,'+data.imageid+')" id="'+data.commenttextid+'" style="float:left; width:100%; height: 33px; border-radius: 5px; border:1px solid lightblue; " type="text"></div></div></div></div><div class="col-md-5"></div>';
  			$('#imageaddition').prepend(imageadd,listcommentadd,finalcommentadd,final);
  			break;

	
		
	}
			}

var fname=$('#userfname').val();
var som="Someone is typing";
function addcomment(key,id)
{
	if(key==='Enter')
	{
		
		sendmessage(id);
	}
	else
		{
	conn.send(JSON.stringify({'type':'typing','som':som,'id':id}));
}
	
}

	
conn.onopen=function(e){
	console.log("connected");
}



	function showcomment(id)
	{

	var listcomment="#listcomment".concat(id)
	var typecomment="#typecomment".concat(id)
	// console.log(listcomment);

	$(listcomment).toggle();
    $(typecomment).toggle();
    if($(listcomment).css('display')!=='none')
    {
    scrolltoend(id);
}
   
	}


	function scrolltoend(id) {

	var list="#listcomment".concat(id);
	
	
    $(list).stop().animate({
       scrollTop: $(list)[0].scrollHeight
    }, 100);
    

}
// function position(list)
// {
// 	var position=$(list).position();
// 	window.scrollTo(0,position.top+500);
// }







    

	</script>
</body>

</html>