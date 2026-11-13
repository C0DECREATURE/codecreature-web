<?php
// Include database connection file
require_once "../connect.php";
// Include password functions file
require_once "../password-functions.php";
// Include username functions file
require_once "../username-functions.php";
// Include user database functions
require_once "../database.php";

// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect to user details page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		echo "logged in";
    header("location: ../details");
    exit;
}
 
// Define variables and initialize with empty values
$email = "";
$email_err = "";

// check for IP ban
$ban = getBanInfo("IP_address",$_SERVER['REMOTE_ADDR']);
$canMakeAccount = empty($ban) || empty($ban["new_account"]) || $ban["new_account"] != true;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && $canMakeAccount){
		// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif(!preg_match('/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/', trim($_POST["email"]))){
        $email_err = "Please enter a valid email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($users_conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email has already been used.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
		
    // Validate username
    if(!empty($_POST["username"])) $new_username = trim($_POST["username"]);
		$username_err = getUsernameErr($new_username);
    
		if(empty($username_err)) {
			// Prepare a select statement
			$sql = "SELECT id FROM users WHERE username = ?";
			
			if($stmt = mysqli_prepare($users_conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				// Set parameters
				$param_username = $new_username;
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "This username is already taken.";
					}
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}

				// Close statement
				mysqli_stmt_close($stmt);
			}
    }
		
    // Validate password
	$password_err = getPasswordErr(trim($_POST["password"]),trim($_POST["username"]),trim($_POST["email"]));
	if(empty($password_err)) { $password = trim($_POST["password"]); }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
			
			// Prepare an insert statement
			$sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
			 
			if($stmt = mysqli_prepare($users_conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
				
				// Set parameters
				$param_email = $email;
				$param_username = $new_username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Redirect to login page
					header("location: ../login/");
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}
				
				// Close statement
				mysqli_stmt_close($stmt);
			}
    }
    
    // Close connection
    mysqli_close($users_conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>sign up</title>
		
		<!-- universal base javascript -->
		<script src="/codefiles/required.js?fileversion=20260410"></script>
		<!-- universal base css -->
		<link href="/codefiles/required.css?fileversion=20260410" rel="stylesheet" type="text/css"></link>
		
		<!-- page settings -->
		<script src="/codefiles/page-settings.min.js?fileversion=20260410"></script>
		
		<!-- fonts -->
		<script>fonts.load('ComicSansMS','SuperComic');</script>
		
		<!--base stylesheet-->
		<link href="/style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!-- typing quirk alt text -->
		<script src="/codefiles/typing-quirks.min.js?fileversion=20260410"></script>
		<!-- svg icons -->
		<script src="/graphix/svg-icons/svg-icons.js?fileversion=20260410" id="svg-icons-js"></script>
		
		<!--user common stylesheet-->
		<link href="../style.css?fileversion=20260410" rel="stylesheet" type="text/css" media="all">
		
		<!--this page's stylesheet-->
		<link href="style.css?fileversion=20261113" rel="stylesheet" type="text/css" media="all">
</head>
<body>
	<main>
		<header>
			<h1>Sign Up</h1>
		</header>
		<?php // if banned, send error message
		if (!$canMakeAccount) { ?>
			<p>Signing up is blocked from your IP address.</p>
			<div class="ban-info">
				<div><span class="accent">Time remaining:</span> <?php echo $ban["expire_text"]; ?></div>
				<div><span class="accent">Reason:</span> <?php echo $ban["reason"]; ?></div>
			</div>
			<p>Email <a href="mailto:admin@codecreature.net">admin@codecreature.net</a> if you believe this is an error.</p>
			<p class="accent">Already have an account? <a href="../login/">Log in here</a>.</p>
		<?php } else { ?>
		<p>
			<span class="accent">Complete this form to create an account!</span>
			<br>Already have an account? <a href="../login/">Log in here</a>.
		</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<label for="email" class="accent">email: </label>
				<input type="email" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
				<span class="invalid-feedback"><?php echo $email_err; ?></span>
			</div>
			<div class="form-group">
				<label for="username" class="accent">username: </label>
				<input
					type="text"
					id="username" name="username"
					minlength="3"
					maxlength="<?php echo $username_length; ?>"
					class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
					value="<?php echo $new_username; ?>">
				<span class="invalid-feedback"><?php echo $username_err; ?></span>
			</div>
			<span>For your safety, choose a password you don't use on other sites!</span>
			<div class="form-group">
				<label for="password" class="accent">password: </label>
				<input
					type="password"
					id="password" name="password"
					minlength="<?php echo $password_length; ?>"
					class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
					value="<?php echo $password; ?>">
				<span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<label for="confirm_password" class="accent">confirm password: </label>
				<input
					type="password"
					id="confirm_password" name="confirm_password"
					minlength="<?php echo $password_length; ?>"
					class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
					value="<?php echo $confirm_password; ?>">
				<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="checkbox" id="verify_age" name="verify_age" class="form-control" required>
				<label for="verify_age">I am at least 13 years old.</label>
			</div>
			<div class="form-group">
				<input type="checkbox" id="accept_rules" name="accept_rules" class="form-control" required>
				<label for="accept_rules">I have read and understood the <a href="/chat/rules" target="_blank">chat rules</a>.</label>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-green" value="Submit">
			</div>
		</form>
		<?php } ?>
		<p><a href="/home"><< return home</a></p>
	</main>    
</body>
</html>