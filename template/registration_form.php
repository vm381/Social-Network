<?php

	require_once("../classes/User.php");

	$okay = true;

	if(isset($_POST["registration"])) {
			$password_1 = htmlspecialchars($_POST["password_1"]);
			$password_2 = htmlspecialchars($_POST["password_2"]);
			$first_name = htmlspecialchars($_POST["first_name"]);
			$last_name = htmlspecialchars($_POST["last_name"]);
			$username = htmlspecialchars($_POST["username"]);
			$city = htmlspecialchars($_POST["city"]);
			$school = htmlspecialchars($_POST["school"]);
			$birthday = htmlspecialchars($_POST["birthday"]);
			$gender = htmlspecialchars($_POST["gender"]);
			$user = new User($first_name, $last_name, $username, $password_1, $password_2, $birthday, $gender, $city, $school);

			$okay = $user->registration();
			if($okay) {
				if(!file_exists("../db/files/$username")){
					mkdir("../db/files/$username", 0777);
					$file=fopen("../db/files/$username/citati.txt", "w");
					fclose($file);
				}

				if (is_uploaded_file($_FILES["profile_picture"]["tmp_name"])) {
					$ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
					if ($ext == "jpeg" || $ext == "jpg" || $ext == "png") {
						move_uploaded_file($_FILES["profile_picture"]["tmp_name"], "../db/files/$username/{$username}.${ext}");
					}
				}

				header("Location: login_form.php");
			}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Welcome </title>
</head>
<body>

	<?php
		if(!$okay) {
			echo "<h3> Check out the details! </h3>";
		}
	?>

	<form action="registration_form.php" method="post" enctype="multipart/form-data">
		First name: <br> <input type="text" name="first_name"> <br>
		Last name: <br> <input type="text" name="last_name"> <br>
		Username: <br> <input type="text" name="username"> <br>
		City: <br> <input type="text" name="city"> <br>
		School: <br> <input type="text" name="school"> <br>
		Password: <br> <input type="password" name="password_1"> <br>
		Confirm password: <br> <input type="password" name="password_2"> <br>
		Birthday: <br> <input type="date" name="birthday"> <br>
		Gender: <br>
		<input type="radio" name="gender" value="m" checked> M
		<input type="radio" name="gender" value="f"> F
		<br>

		<input type="file" name="profile_picture">
		<br>

		<input type="submit" name="registration" value="Sign up">
	</form>
</body>
</html>
