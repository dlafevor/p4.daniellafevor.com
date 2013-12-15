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

    public function add() {

        # Setup view
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "New Post";

        # Render template
        echo $this->template;

    }

    public function p_add() {

			# Associate this post with this user
			$_POST['user_id']  = $this->user->user_id;

			# Unix timestamp of when this post was created / modified
			$_POST['created']  = Time::now();
			$_POST['modified'] = Time::now();

			# Insert
			# Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
			DB::instance(DB_NAME)->insert('posts', $_POST);

			# Quick and dirty feedback
			Router::redirect("/posts/myposts");
    }
		
		public function delete($post_id) {
			# Delete this connection
			$where_condition = 'WHERE post_id = '.$post_id;
			DB::instance(DB_NAME)->delete('posts', $where_condition);
			# Send them back
			Router::redirect("/posts/myposts");
	}
		
		public function index() {
			# Set up the View
			$this->template->content = View::instance('v_posts_index');
			$this->template->title   = "Barking";
	
			# Build the query
			$q = 'SELECT 
            posts.content,
            posts.created,
            posts.user_id AS post_user_id,
            users_followed.user_id AS follower_id,
            users.first_name,
            users.last_name, 
						users.email
        FROM posts
        INNER JOIN users_followed 
            ON posts.user_id = users_followed.user_id_followed
        INNER JOIN users 
            ON posts.user_id = users.user_id
        WHERE users_followed.user_id = '.$this->user->user_id;
	
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
            posts.post_id, 
						posts.content,
            posts.created,
						users.first_name,
            users.last_name, 
						users.email
        FROM posts
				INNER JOIN users ON posts.user_id = users.user_id
        WHERE posts.user_id = '.$this->user->user_id;
	
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
						users.first_name,
            users.last_name, 
						users.email
        FROM posts
				INNER JOIN users ON posts.user_id = users.user_id';
	
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
					WHERE user_id = ".$this->user->user_id;
	
			# Execute this query with the select_array method
			# select_array will return our results in an array and use the "users_id_followed" field as the index.
			# This will come in handy when we get to the view
			# Store our results (an array) in the variable $connections
			$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
	
			# Pass data (users and connections) to the view
			$this->template->content->users       = $users;
			$this->template->content->connections = $connections;
	
			# Render the view
			echo $this->template;
	}
	public function follow($user_id_followed) {
    # Prepare the data array to be inserted
    $data = Array(
        "created" => Time::now(),
        "user_id" => $this->user->user_id,
        "user_id_followed" => $user_id_followed
        );
    # Do the insert
    DB::instance(DB_NAME)->insert('users_followed', $data);
    # Send them back
    Router::redirect("/posts/users");

	}
	public function unfollow($user_id_followed) {
			# Delete this connection
			$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
			DB::instance(DB_NAME)->delete('users_followed', $where_condition);
			# Send them back
			Router::redirect("/posts/users");
	}
}