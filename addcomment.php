<?php
$userid=$_POST['userid'];
$msg=$_POST['msg'];
$imageid=$_POST['imageid'];
$conn = mysqli_connect("localhost", "root", "", "Comment");
$userquery=mysqli_query($conn,"INSERT INTO `commentrecord` (`Comment`,`CommenterID`,`ImageID`) values ('$msg',$userid,$imageid)");
$imagequery=mysqli_query($conn,"UPDATE `Image` set `count`=`count`+1 where `ImageID`=$imageid ");
$imagequery1=mysqli_query($conn,"Select * from `Image` where `ImageID`=$imageid");
$imageresult=mysqli_fetch_array($imagequery1);
$myObj = new \stdClass();
$myObj->count = $imageresult[2];

$myJSON = json_encode($myObj);

echo $myJSON;
?>