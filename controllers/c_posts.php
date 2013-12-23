<?php
class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            #die("Members only. <a href='/users/login'>Login</a>");
					Router::redirect("/users/login");
        }
    }
		public function p_addGame() {
			# Function for posting game results (associated with the user) to the DB
			$_POST['userID']  = $this->user->userID;
			$_POST['created']  = Time::now();
			
			DB::instance(DB_NAME)->insert('minesweepresults', $_POST);
		}
    public function add() {

        # Setup view
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "New Post";

        # Render template
        echo $this->template;
    }

    public function p_add() {

			# Associate this post with this user
			$_POST['userID']  = $this->user->userID;

			# Unix timestamp of when this post was created / modified
			$_POST['created']  = Time::now();
			$_POST['modified'] = Time::now();

			# Insert
			# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
			DB::instance(DB_NAME)->insert('posts', $_POST);

			# Quick and dirty feedback
			Router::redirect("/posts/myposts");
    }
		
		public function delete($userID) {
			# Delete this connection
			$where_condition = 'WHERE userID = '.$userID;
			DB::instance(DB_NAME)->delete('posts', $where_condition);
			# Send them back
			Router::redirect("/posts/myposts");
	}
		
		public function index() {
			# Set up the View
			$this->template->content = View::instance('v_posts_index');
			$this->template->title   = "MineSweeper!";
	
			# Build the query
			$q = 'SELECT 
            posts.content,
            posts.created,
            posts.userID AS post_userID,
            users_followed.userID AS follower_id,
            users.firstName,
            users.lastName, 
						users.email
        FROM posts
					INNER JOIN users_followed ON posts.userID = users_followed.userID_followed
					INNER JOIN users ON posts.userID = users.userID
        WHERE users_followed.userID = '.$this->user->userID;
	
			# Run the query
			$posts = DB::instance(DB_NAME)->select_rows($q);
	
			# Pass data to the View
			$this->template->content->posts = $posts;
	
			# Render the View
			echo $this->template;
		}
	# Beg - Function for pulling back my posts
	
		public function myposts() {
			# Set up the View
			$this->template->content = View::instance('v_posts_myposts');
			$this->template->title   = "My Barking";
	
			# Build the query
			$q = 'SELECT 
            posts.userID, 
						posts.content,
            posts.created,
						users.firstName,
            users.lastName, 
						users.email
        FROM posts
				INNER JOIN users ON posts.userID = users.userID
        WHERE posts.userID = '.$this->user->userID;
	
			# Run the query
			$userposts = DB::instance(DB_NAME)->select_rows($q);
	
			# Pass data to the View
			$this->template->content->myposts = $userposts;
	
			# Render the View
			echo $this->template;
		}
		
		public function allposts() {
			# Set up the View
			$this->template->content = View::instance('v_posts_allposts');
			$this->template->title   = "All The Barking";
	
			# Build the query
			$q = 'SELECT 
            posts.content,
            posts.created,
						users.firstName,
            users.lastName, 
						users.email
        FROM posts
				INNER JOIN users ON posts.userID = users.userID';
	
			# Run the query
			$userallposts = DB::instance(DB_NAME)->select_rows($q);
	
			# Pass data to the View
			$this->template->content->allposts = $userallposts;
	
			# Render the View
			echo $this->template;
		}
	
	# End - Function for pulling back my posts
	
	
	
		public function users() {
	
			# Set up the View
			$this->template->content = View::instance("v_posts_users");
			$this->template->title   = "Users";
	
			# Build the query to get all the users
			$q = "SELECT *
					FROM users";
	
			# Execute the query to get all the users. 
			# Store the result array in the variable $users
			$users = DB::instance(DB_NAME)->select_rows($q);
	
			# Build the query to figure out what connections does this user already have? 
			# I.e. who are they following
			$q = "SELECT * 
					FROM users_followed
					WHERE userID = ".$this->user->userID;
	
			# Execute this query with the select_array method
			# select_array will return our results in an array and use the "users_id_followed" field as the index.
			# This will come in handy when we get to the view
			# Store our results (an array) in the variable $connections
			$connections = DB::instance(DB_NAME)->select_array($q, 'userID_followed');
	
			# Pass data (users and connections) to the view
			$this->template->content->users       = $users;
			$this->template->content->connections = $connections;
	
			# Render the view
			echo $this->template;
	}
	public function follow($userID_followed) {
    # Prepare the data array to be inserted
    $data = Array(
        "created" => Time::now(),
        "userID" => $this->user->userID,
        "userID_followed" => $userID_followed
        );
    # Do the insert
    DB::instance(DB_NAME)->insert('users_followed', $data);
    # Send them back
    Router::redirect("/posts/users");

	}
	public function unfollow($userID_followed) {
			# Delete this connection
			$where_condition = 'WHERE userID = '.$this->user->userID.' AND userID_followed = '.$userID_followed;
			DB::instance(DB_NAME)->delete('users_followed', $where_condition);
			# Send them back
			Router::redirect("/posts/users");
	}
}