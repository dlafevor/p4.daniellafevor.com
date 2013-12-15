<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        // echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
    }

   	public function signup($error = NULL) {
			# Setup view
				$this->template->content = View::instance('v_users_signup');
				$this->template->title   = "Join the Backyard Barker! Sign Up Now!";

        //Pass data to the view
        $this->template->content->error = $error;
					
			# Render template
				echo $this->template;
    }


		public function p_signup() {

      $q = "SELECT token 
						FROM users 
						WHERE email = '".$_POST['email']."'";
							
			$token = DB::instance(DB_NAME)->select_field($q);

			# Found

			# Signup Failed
			if($token) {
					# Note the addition of the parameter "error"
					Router::redirect("/users/signup/email-exists"); 
			}
			# Login passed
			else {
				$_POST['created']  = Time::now();
				$_POST['modified'] = Time::now();
				
				# Encrypt the password  
				$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            
		
				# Create an encrypted token via their email address and a random string
				$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
				
				# Insert this user into the database
				$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
				
				# You should eventually make a proper View for this
				Router::redirect("/users/login"); 
			}
			
			      
    }
		
		public function login($error = NULL) {
		
				# Set up the view
				$this->template->content = View::instance("v_users_login");
				$this->template->title   = "Login to the Backyard Barker";
		
				# Pass data to the view
				$this->template->content->error = $error;
		
				# Render the view
				echo $this->template;
		
		}
		
		public function p_login() {
			# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
    	$_POST = DB::instance(DB_NAME)->sanitize($_POST);

			# Hash submitted password so we can compare it against one in the db
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	
			# Search the db for this email and password
			# Retrieve the token if it's available
			$q = "SELECT token 
					FROM users 
					WHERE email = '".$_POST['email']."' 
					AND password = '".$_POST['password']."'";
	
			$token = DB::instance(DB_NAME)->select_field($q);

			# If we didn't find a matching token in the database, it means login failed

			# Login failed
			if(!$token) {
					# Note the addition of the parameter "error"
					Router::redirect("/users/login/error"); 
			}
			# Login passed
			else {
					/* 
					Store this token in a cookie using setcookie()
					Important Note: *Nothing* else can echo to the page before setcookie is called
					Not even one single white space.
					param 1 = name of the cookie
					param 2 = the value of the cookie
					param 3 = when to expire
					param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
					*/
					setcookie("token", $token, strtotime('+2 weeks'), '/');
					
					# Send them to the main page - or whever you want them to go
					Router::redirect("/posts");
			}
		}
		
		
    public function logout() {
    	
			# Generate and save a new token for next login
			$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
	
			# Create the data array we'll use with the update method
			# In this case, we're only updating one field, so our array only has one entry
			$data = Array("token" => $new_token);
	
			# Do the update
			DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
	
			# Delete their token cookie by setting it to a date in the past - effectively logging them out
			setcookie("token", "", strtotime('-1 year'), '/');
	
			Router::redirect("/users/login");
    }
		
		
		public function profile($email = NULL) {

			if($email == NULL) {
					echo "No user specified";
			}
			else {
				# Setup view
				$this->template->content = View::instance('v_users_profile');
				$this->template->title   = "User Profile";

				# Build the query
			$q = 'SELECT 
            users.first_name,
            users.last_name, 
						users.email,
						users.userState, 
						users.userCity, 
						users.userBio
        FROM users
        WHERE users.user_id = '.$this->user->user_id;
	
			# Run the query
			$myProfile = DB::instance(DB_NAME)->select_rows($q);
	
			# Pass data to the View
			$this->template->content->userProfile = $myProfile;

				# Render template
				echo $this->template;
			}
		}
		public function p_profile() {
			 # Associate this post with this user
			$_POST['user_id']  = $this->user->user_id;

			# Insert
			# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
			$whereClause = 'WHERE user_id = ' .$_POST['user_id'];
			DB::instance(DB_NAME)->update('users', $_POST, $whereClause);

			# Quick and dirty feedback
			Router::redirect("/posts/myposts/");
		}

} # end of the class