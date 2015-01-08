<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./home.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<title>BrainSurge</title>
</head>

<div id="container">

<header>
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>Brain Surge</h1>
</div>

<div id="description">

	Brain Surge is an interactive website that allows you to take personality quizzes and learn about yourself. Read about the quizzes below and then take one to get started. You can also make an account by registering to keep track of your previous quizzes.

</div>
</header>

<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li><a href="./big5.php">The Big Five</a></li>
	    <li><a href="./typeAB.php">Type A/B</a></li>
	</ul>

	<!-- takes them to profile page, or if they aren't logged in, to register/login page-->
<?php 
	if(!isset($_COOKIE["user"])){
		print "<a href='login.php'> <h4><i>Your Profile</i></h4></a>";
	}
	else{
		print "<a href='profile.php'> <h4><i>Your Profile</i></h4></a>";
	}
?>
	<h4><i>More Information</h4></i>
	<dl><dt>Personality Theory</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Personality_psychology">Personality Psychology</a></dd>
		<dd><a href="http://drdianehamilton.wordpress.com/2011/12/18/top-18-personality-theorists-including-freud-and-more/">Famous Personality Psychologists</a></dd>
	<br>
	    <dt>Social Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Social_psychology">Social Psychology</a></dd>
		<dd><a href="http://www.ippanetwork.org/">Positive Psychology</a></dd>
	<br>
	    <dt>Neuropsychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Neuropsychology">Neuropsychology</a></dd>
		<dd><a href="http://www.neuroaustin.com/">Local Neuropsychologists</a></dd>
	<br>
	    <dt>Other Fields of Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Cognitive_psychology">Cognitive Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Developmental_psychology">Developmental Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Clinical_psychology">Clinical Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Abnormal_psychology">Abnormal Psychology</a></dd>
	</dl>
	
	<h4><i>Contact Brain Surge</i></h4>
		<p><a href="./info.php">About Brain Surge and the developers</a></p>
</div>

<?php 
	if(!isset($_COOKIE["user"])){
		print <<<LOGIN
			<div id="login">
				<form method="post" action="home.php">
				<b>Login Here!</b>
				<table id="loginTable">
				<tr><td>Username:</td><td><input type="text" name="username" id="id" size="15"></td></tr>
				<tr><td>Password:</td><td><input type="password" name="password" id="pw" size="15"></td></tr>
				</table>
				<input class="btn" type="submit" value="Login" name="login" id="submitL">
				<br>
				<br>New User? Register <a href="login.php"><u>Here</u></a>
				</form>
			</div>
LOGIN;
	}
	else{	
		print <<<WELCOME
			<div id="welcome">
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["first"]}</b></u></a>
				<form method="post" action="home.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("first", "", time() - 3600);
		setcookie("user", "", time() - 3600);
		header("Location: home.php");
	}
	if(isset($_POST["login"])){
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
                $un = purge($_POST["username"]);
                $pw = purge($_POST["password"]);
                $pw_protected = crypt($pw,$un);
                login($un, $pw_protected);
		}
		else{
			echo "<script type = 'text/javascript'>
				alert('Please fill in both fields to login.') </script>";
		}
	}
        //Dr. Mitra's basic purge function
        function purge ($str){
                $purged_str = preg_replace("/\W/", "", $str);
                return $purged_str;
        }	
	function login($un, $pw){
	            $host = "127.0.0.1";
				$user = "root";
				$pwd = "*";
				$dbs = "evanjohnston";
				//$port = "3306";
				$connect = mysqli_connect ($host, $user, $pwd, $dbs);
				$table = "Brainsurge";

                $un=mysqli_real_escape_string($connect, $un);
                $pw=mysqli_real_escape_string($connect, $pw);		

		$result = mysqli_query($connect, "SELECT * from $table where Username = \"$un\"");
		$row = $result->fetch_row();
		if(count($row) == 0){
			echo "<script type = 'text/javascript'>
				alert('That username is not registered.') </script>";	
		}
		else if($row[3] != $pw){
			echo "<script type = 'text/javascript'>
				alert('Username and password do not match.') </script>";	
		}
		else{	
			$name = $row[0];
			setcookie("user", $un);
			setcookie("first", $name);
			header("Location: home.php");
		}
		mysqli_close($connect);
	}
?>

<div id="MB">
<span id="MB_title"><b><u>Myers-Briggs Type Indicator</u></b></span> 
<span id="MB_info" >The  MBTI, is a personality inventory developed by Katharine Cook Briggs and Isabel Briggs Myers, based on the theories of Carl Gustav Jung.This test should take between 20 and 30 mins to complete.<br>Your answers will assign you 4 letters based on 4 metrics:
<table width="100%" style="table-layout:fixed;">
	<ul><tr><td><li> Extraversion vs. Introversion</li></td>
	<td><li> Sensing vs. Intuition</li></td></tr>
	<tr><td><li> Thinking vs. Feeling</li></td>
	<td><li>Judging vs. Perceiving</li></td></tr>
	</ul>
	<tr><td><a href="http://en.wikipedia.org/wiki/Myers-Briggs_Type_Indicator" target="blank">Learn More about the MBTI</a></td>
	<td><a href="./mb.php">Take this test now!</a></td></tr>
</table></span>

<script>
	$("#MB_info").hide();
	$("#MB_title").show();
	$("#MB").hover(function(){
		$("#MB_info").toggle(300);
		$("#MB_title").toggle(300);
	})
</script>

</div>

<div id="Big5">
<span id="Big5_title"><b>The <u>Big</u> 5</b></span>
<span id="Big5_info">The Big Five personality traits are based on the five-factor model of personality. This model has been shown to be consistent for people of different ages and cultures. The Big Five are sometimes referred to as OCEAN:
<table width="100%" style="table-layout:fixed; padding:0;">
	<ul>
	<tr><td colspan="2"><li><center>Openness to Experience</center></li></td></tr>
	<tr><td><li>Conscientiousness </li></td>
	<td><li>Extraversion</li></td></tr>
	<tr><td><li>Agreeableness</li></td>
	<td><li>Neuroticism</li></td></tr>
	</ul>
	<tr><td><a href="http://en.wikipedia.org/wiki/Big_Five_personality_traits" target="blank">Learn More about the <br>Big 5 Personality Traits</a></td>
	<td><a href="./big5.php">Take this test now!</a></td></tr>
</table></span>
	
<script>
	$("#Big5_info").hide();
	$("#Big5_title").show();
	$("#Big5").hover(function(){
		$("#Big5_info").toggle(300);
		$("#Big5_title").toggle(300);
	})
</script>

</div>

<div id="AB">
<span  id="AB_title"><b><i>A/B Personality Types</i></b></span>
<br><span id="AB_info">Type A and B personality theory was developed by cardiologists, rather than psychologists, to determine what kinds of people are more prone or less prone to mental stress and possible heart attacks.
<table width="100%" style="table-layout:fixed;" >
	<tr><td><b>Type A</b></td>
		<td rowspan="2"><a href="http://www.simplypsychology.org/personality-a.html" target="blank">Learn More about <br>Type A and Type B Personality Theory</a></td>
		<td><b>Type B</b></td></tr>
	<ul><tr><td ><li>Goal-oriented</li></td>
		<td><li>Steady worker</li></td></tr>
	<tr><td><li>"Workaholic"</li></td>
		<td rowspan="2"><a href="./typeab.php">Take this test now!</a></td>
		<td><li>Creative</li></td></tr>
	<tr><td><li>Competitive</li></td>
		<td><li>Reflective</li></td></tr></ul>
</table></span>
	
<script>
	$("#AB_info").hide();
	$("#AB_title").show();
	$("#AB").hover(function(){
		$("#AB_info").toggle(300);
		$("#AB_title").toggle(300);
	})
</script>

</div>

<div id="videos">
	<h2> Learn more </h2>
	<iframe id="vid1" width="320" height="185" src="http://www.youtube.com/embed/NZ5o9PcHeL0" 
	frameborder="0" allowfullscreen></iframe>
	<iframe id="vid2" width="320" height="185" src="http://www.youtube.com/embed/c0KYU2j0TM4" 
	frameborder="0" allowfullscreen></iframe>
	<iframe id="vid3" src="http://fast.wistia.net/embed/iframe/c7leyardzk?canonicalUrl=http%3A%2F%2Fwww.truity.com%2Finfp&canonicalTitle=The%20INFP%20Personality%20Type" 
	allowtransparency="true" frameborder="0" width="320" height="185"></iframe>

</div>

<div id="footer">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>

<!-- references
	http://www.learningstorm.org/wp-content/uploads/2014/02/MBTI-personality-test.pdf [mbti]
	http://personality-testing.info/printable/big-five-personality-test.pdf [big 5]
	http://www.psych.uncc.edu/pagoolka/TypeAB.html [type AB]
	http://cmbuzz.com/wp-content/uploads/2011/03/brainstorm.jpg [logo]
-->

</div>
</html>
