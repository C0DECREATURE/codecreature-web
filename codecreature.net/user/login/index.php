<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect to user settings page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../settings");
    exit;
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, access, icon, last_login FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $access, $icon, $last_login);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["user_access"] = $access;                            
                            $_SESSION["user_icon"] = $icon;                            
                            
														// check if this is the user's first login
														$welcome = $last_login == NULL ? '?welcome=true' : '';
														
														// record the last login time
														date_default_timezone_set('America/New_York'); // EST
														$current_date = date('Y-m-d H:i:s');
														$date_sql = "UPDATE users SET last_login='".$current_date."' WHERE id=".$id;
														if ($link->query($date_sql) === TRUE) { echo "User last_login updated successfully";
														} else { echo "Error updating last_login: " . $conn->error; }
														
                            // Redirect user to welcome page
                            header("location: ../settings".$welcome);
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>codecreature login</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20251216"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20251216" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20251216"></script>
		
		<!-- fonts -->
		<script>fonts.load('ComicSansMS','SuperComic');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20251216"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20251216" id="svg-icons-js"></script>
		
		<!--user common stylesheet-->
		<link href="../style.css?fileversion=20251216" rel="stylesheet" type="text/css" media="all">
	</head>
	<body>
		<div class="wrapper">
			<h1>Login</h1>
			<p>Please fill in your credentials to login.</p>
			
			<?php 
			if(!empty($login_err)){
				echo '<div class="alert alert-danger">' . $login_err . '</div>';
			}        
			?>
			
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group">
					<label for="username">Username</label>
					<input
						type="text"
						id="username" name="username"
						class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
						value="<?php echo $username; ?>">
					<span class="invalid-feedback"><?php echo $username_err; ?></span>
				</div>    
				<div class="form-group">
					<label for="password">Password</label>
					<input
						type="password"
						id="password" name="password"
						class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
					<span class="invalid-feedback"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-green" value="Login">
				</div>
				<p>Don't have an account? <a href="../register/">Sign up now</a>.</p>
			</form>	
		</div>
	</body>
</html>