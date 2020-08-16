<!DOCTYPE html>
<html>
<head><title>Result</title></head>
<body>
<h1>Result</h1>
<hr>

<?php 
	include 'db.php';
	
	header("Content-Type: application/json"); 

	$data = json_decode(file_get_contents("php://input")); 
	//$qid = array_keys( $data ); 
	$size = sizeof($data); 
	
	$cnt=0;
	$attempt=0;
	
	foreach($data as $i => $v) 
	{ 
		if($v!=null)
		{
			$attempt=$attempt+1;
			//echo "key: ". $i . ", value: " . $v . "<br>";
			$an="SELECT ansId from question where Qid= $i";
			$res=mysqli_query($conn,$an);
			
			$ro=mysqli_fetch_array($res);
			
			$aid=$ro['ansId'];
			
			$ans="SELECT Answer from answer where Qno = $i AND ansId= $aid";
			
			$result=mysqli_query($conn,$ans);
			
			if(mysqli_num_rows($result)>0)
			{
				while($row=mysqli_fetch_assoc($result))
				{
					if($row['Answer']==$v)
						$cnt=$cnt+1;
				}
			}
		}	 
	}
	echo "<pre>Number of Questions: 5</pre>";
	echo "<pre>Number of Questions attempted: ".$attempt."</pre>";
	echo "<pre>Number of Questions solved correctly: ".$cnt."</pre>"; 
	if($cnt==5)
	{
		echo "<img src='pass.gif'>";
	}
?>
</body>
</html>
