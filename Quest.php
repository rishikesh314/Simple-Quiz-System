<!DOCTYPE html>
<html>
<head>
<style>
#ques
{
	margin-left: 40px;
}
</style>

<style>
#timer
{
	font-size : 30px;
	font-weight : bold;
	float : right;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"> </script>

<script>
	var min = 9;
	var sec = 60;
    
    var timerId = setInterval(countdown, 1000);
    
    function countdown() 
	{
		if (sec < 0 && min<0) 
		{
			clearTimeout(timerId);
			document.getElementById("btn").click();
		} 
		else 
		{
			document.getElementById('timer').innerHTML = min + ' m '+sec + ' s';
			if(sec>0)
				sec--;
			else
			{
				if(min==0 && sec==0)
				{
					min--;
					sec--;
				}
				else
				{
					min--;
					sec=60;
				}
			}
		}
    }
</script>

<script> 

	function displayRadioValue() { 
		var ele = document.getElementsByTagName('input'); 
		var qid = new Array();
//		var asl = new Array();
		for(i = 0; i < ele.length; i++) 
		{ 
			  
			if(ele[i].type="radio") 
			{
			  
				if(ele[i].checked) 
				{
					var t1 = ele[i].name;
					var t2 = ele[i].value;
					qid[t1] = t2;
					
				}
			} 
		}
		
		var xhr = new XMLHttpRequest();  
		xhr.open("POST", "check.php", true);
        xhr.setRequestHeader("Content-Type", "application/json"); 
        xhr.onreadystatechange = function () 
		{ 
			if (xhr.readyState === 4 && xhr.status === 200) 
			{ 
				document.body.innerHTML = this.responseText; 
            } 
        };
		
		var q = JSON.stringify( qid );
		xhr.send(q);
		
	} 
	
</script>

</head>
<body>
<h1><center>WELCOME TO QUIZ</center></h1>
<br>
<hr>
<br>
<br>
<p id="timer"></p>
<div id="ques">
<pre>
<?php
	include "db.php";


	$sql="SELECT * FROM question ORDER BY RAND() LIMIT 5";
	
	$result = mysqli_query($conn,$sql);
	$x=0;
	$count=1;
	
	$ans=array();
	
	if(mysqli_num_rows($result)>0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			echo "<p>".$count. "." . $row["Ques"] . "</p>";
			$id = $row["Qid"];
			$ans="SELECT * FROM answer WHERE Qno = $id";
			
			$qans=mysqli_query($conn,$ans);
			if(mysqli_num_rows($qans)>0)
			{
				while($ro = mysqli_fetch_assoc($qans))
				{
					echo "<p><input type='radio' name='".$id."' value='".$ro["Answer"]."'>".$ro["Answer"]."</p>";
				}
			}
			$count=$count+1;
			echo "<br><br>";
		}
	}
	//$ques_str = implode(",", $question);
	
?>
</pre>
<center><button type="button" id="btn" onclick="displayRadioValue()">Submit</button></center>
</div>
</body>
</html>

