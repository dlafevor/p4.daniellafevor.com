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
				$this->template->title   = "Join MineSweeper! Sign Up Now!";

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
				$userID = DB::instance(DB_NAME)->insert('users', $_POST);
				
				# You should eventually make a proper View for this
				Router::redirect("/users/login"); 
			}
			
			      
    }
		
		public function login($error = NULL) {
		
				# Set up the view
				$this->template->content = View::instance("v_users_login");
				$this->template->title   = "Login to the MineSweeper!";
		
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
					Router::redirect("/");
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
							users.firstName,
							users.lastName, 
							users.email,
							users.userState, 
							users.userCity, 
							users.userBio
					FROM users
					WHERE users.userID = '.$this->user->userID;
		
				# Run the query
				$myProfile = DB::instance(DB_NAME)->select_rows($q);
		
				# Pass data to the View
				$this->template->content->userProfile = $myProfile;
				
				#Build Data for Won Games
				$qWon = 
					'SELECT COUNT(gameID) AS gamesWon
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 1 AND userID = '.$this->user->userID;
				#Run the query
				$getWonScores = DB::instance(DB_NAME)->select_rows($qWon);
				# Pass data to the View
				$this->template->content->gamesWon = $getWonScores;
				
				#Build Data for Won Games - Medium
				$qWonMed = 
					'SELECT COUNT(gameID) AS gamesWon
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 2 AND userID = '.$this->user->userID;
				#Run the query
				$getWonScoresMed = DB::instance(DB_NAME)->select_rows($qWonMed);
				# Pass data to the View
				$this->template->content->gamesWonMed = $getWonScoresMed;
				
				#Build Data for Won Games - Difficulty
				$qWonDif = 
					'SELECT COUNT(gameID) AS gamesWon
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 3 AND userID = '.$this->user->userID;
				#Run the query
				$getWonScoresDif = DB::instance(DB_NAME)->select_rows($qWonDif);
				# Pass data to the View
				$this->template->content->gamesWonDif = $getWonScoresDif;
				
				#Build Data for Lost Games
				$qLost = 
					'SELECT COUNT(gameID) AS gamesLost
					FROM minesweepresults
					WHERE isWon = 0 AND difficulty = 1 AND userID = '.$this->user->userID;
				#Run the query
				$getLostScores = DB::instance(DB_NAME)->select_rows($qLost);
				# Pass data to the View
				$this->template->content->gamesLost = $getLostScores;
				
				#Build Data for Lost Games - Medium
				$qLostMed = 
					'SELECT COUNT(gameID) AS gamesLost
					FROM minesweepresults
					WHERE isWon = 0 AND difficulty = 2 AND userID = '.$this->user->userID;
				#Run the query
				$getLostScoresMed = DB::instance(DB_NAME)->select_rows($qLostMed);
				# Pass data to the View
				$this->template->content->gamesLostMed = $getLostScoresMed;
				
				#Build Data for Lost Games - Difficult
				$qLostDif = 
					'SELECT COUNT(gameID) AS gamesLost
					FROM minesweepresults
					WHERE isWon = 0 AND difficulty = 3 AND userID = '.$this->user->userID;
				#Run the query
				$getLostScoresDif = DB::instance(DB_NAME)->select_rows($qLostDif);
				# Pass data to the View
				$this->template->content->gamesLostDif = $getLostScoresDif;
				
				#Build Data for Top Ten
				$qMyTopTen = 
					"SELECT gameTime, created
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 1 AND userID = '".$this->user->userID."' 
					ORDER BY gameTime ASC 
					LIMIT 10";
					
				#Run the query
				$getTopTen = DB::instance(DB_NAME)->select_rows($qMyTopTen);
				# Pass data to the View
				$this->template->content->topTen = $getTopTen;
				
				#Build Data for Top Ten - Medium
				$qMyTopTenMed = 
					"SELECT gameTime, created
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 2 AND userID = '".$this->user->userID."' 
					ORDER BY gameTime ASC 
					LIMIT 10";
					
				#Run the query
				$getTopTenMed = DB::instance(DB_NAME)->select_rows($qMyTopTenMed);
				# Pass data to the View
				$this->template->content->topTenMed = $getTopTenMed;
				
				#Build Data for Top Ten - Difficult
				$qMyTopTenDif = 
					"SELECT gameTime, created
					FROM minesweepresults
					WHERE isWon = 1 AND difficulty = 3 AND userID = '".$this->user->userID."' 
					ORDER BY gameTime ASC 
					LIMIT 10";
					
				#Run the query
				$getTopTenDif = DB::instance(DB_NAME)->select_rows($qMyTopTenDif);
				# Pass data to the View
				$this->template->content->topTenDif = $getTopTenDif;
				
				# Render template
				echo $this->template;
			}
		}
		public function p_profile() {
			 # Associate this post with this user
			$_POST['userID']  = $this->user->userID;

			# Insert
			# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
			$whereClause = 'WHERE userID = ' .$_POST['userID'];
			DB::instance(DB_NAME)->update('users', $_POST, $whereClause);

			# Quick and dirty feedback
			Router::redirect("/posts");
		}

} # end of the class