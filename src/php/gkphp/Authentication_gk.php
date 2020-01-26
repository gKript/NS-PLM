<?php
	
	global	$gkcfg;

	define	( 'GK_USER_GUEST'					, "guest" );
/*define	( 'GK_USER_USER'					, "user" );
	define	( 'GK_USER_SUPER'					, "superuser" );
	define	( 'GK_USER_ADMIN'					, "administrator" ); */	
	
	define	( 'GK_MAX_DELTA'					, $gkcfg->param->authentication->timeout );
	define	( 'GK_DAYS_COOKIES'				, $gkcfg->param->authentication->cookie_days );
	define	( 'GK_AUTH_DEBUG_STATUS'	, false );
	
	class gkAuthentication {
		
		var $user;
		var $clean_user;
		var $password;
		var $password_md5;
		var $role;
		var $session;
		var $autoconnect;
		var $first_pass;
		var $image;
		var $level;
	
		var $debug;

		function __construct ( $n_user , $md5_pass , $user_debug = false ) {
			if ( $user_debug == false ) 
				$this->debug = GK_AUTH_DEBUG_STATUS;
			else
				$this->debug = $user_debug;

			$this->first_pass = false;
			$this->image = false;
			$this->session = session_id();
			$this->password_md5 = $md5_pass;
			$this->gk_clean_online_table();
			$this->set_current_user_name( $n_user );
			$r = $this->user;
			$cr = query_get_a_field( "SELECT *  FROM `gk_users` WHERE `user_login` LIKE '$r'" , "user_role" );
			$this->level = query_get_a_field( "SELECT *  FROM `gk_role` WHERE `role_name` LIKE '$cr'" , "role_id" );
			if ( $this->level == NULL ) 
				$this->level = 0;
		}


		function get_level_by_role( $role ) {
			return query_get_a_field( "SELECT *  FROM `gk_role` WHERE `role_name` LIKE '$role'" , "role_id" );
		}

	
		function check_user_level( $uact , $uwhat ) {
			$u = $this->user;
			$r = $this->role;
			
			$reqlev	= query_get_a_field( "SELECT * FROM `gk_permissions`" , $uact.$uwhat );
			$ulevel	= query_get_a_field( "SELECT *  FROM `gk_role` WHERE `role_name` LIKE '$r'" , "role_id" );
			if ( $ulevel >= $reqlev )
				return true;
			return false;
		}
		
		function get_current_user_level() {
			return $this->level;
		}
		

		function set_current_user_name( $n_user ) {
			$this->user = $n_user;
			if ( $n_user == "guest" ) {
				if ( isset( $_COOKIE["GK_USER"] ) ) {
					if ( ! isset( $_COOKIE["GK_PASS"] ) )
						$_COOKIE["GK_PASS"] = "";
					$this->gk_debug( $_COOKIE["GK_USER"]."<br>" );
					$this->gk_debug( $_COOKIE["GK_PASS"]."<br>" );	
					$this->autoconnect = true;
					$this->pasword_md5 = true;
					$this->get_authentication( $_COOKIE["GK_USER"] , $_COOKIE["GK_PASS"] );
				}
				else {
					$this->autoconnect = false;
					$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
					$this->gk_update_values_to_session();
					$query = 'SELECT * FROM `gk_users_online` WHERE `online_session_id` = CONVERT(_utf8 \''.$this->session.'\' USING latin1) COLLATE latin1_swedish_ci';
					$this->gk_debug( $query."<br>" );
					$nrow = query_get_num_rows( $query );
					if ( $nrow ) {
						$this->gk_debug( "Updating last access<br>" );
						$query = "UPDATE `gk_users_online` SET `online_last_access` = ".time()." WHERE `online_session_id` = CONVERT(_utf8 '".$this->session."' USING latin1) COLLATE latin1_swedish_ci";
						$this->gk_debug( $query."<br>" );
						query_sql_run( $query );
						$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
						$this->gk_update_values_to_session();
					}
					else {
						$this->first_pass = true;
						$this->gk_debug( "Insert online guest session<br>" );
						$query = 'INSERT INTO `gk_users_online` (`online_id`, `online_user_name`, `online_clean_name`, `online_user_role`, `online_session_id`, `online_last_access`) VALUES (NULL, \'guest\', \'guest\', \'guest\', \''.$this->session.'\', '.time().' ) ;';
						$this->gk_debug( $query."<br>" );
						query_sql_run( $query );
						$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
						$this->gk_update_values_to_session();
						$this->gk_debug( $this->role."<br>" );
					}
					$_SESSION["auth"] = false;
				}
			}
			else {
				$autoconnect = false;
				$this->pasword_md5 = true;
				$this->get_authentication( $n_user , $_SESSION["pass"] );
			}
		}
	
		function get_current_user_name() {
			return $this->user;
		}
	
		function get_current_clean_user_name() {
			return $this->clean_user;
		}
	
		function get_current_user_role() {
			return $this->role;
		}
		
		function get_image_flag() {
			return $this->image;
		}
	
		function gk_debug( $message ) {
			if ( $this->debug == true ) {
				echo $message;
			}
		}
		
		function first() {
			return $this->first_pass;
		}
	
		function gk_clean_online_table() {
			$query = 'SELECT * FROM `gk_users_online` ';
			$this->gk_debug( $query."<br>" );
			$result = query_get_result( $query );
			if ( $result ) {
				while ( $row = $result->fetch_array() ) {
					$before = date( "U", $row["online_last_access"] );
					$session = $row["online_session_id"];
					$now	= time();
					$delta	= $now - $before;
					$this->gk_debug( $row["online_user_name"]." has $delta seconds of inactivity on " .  GK_MAX_DELTA  . "<br>" );
					if ( $delta > GK_MAX_DELTA ) {
						$this->gk_debug( "<font COLOR=\"#C7A700\">DELETING ".$row["online_user_name"]." session</font><br>" );
						$query = "DELETE FROM `gk_users_online` WHERE `gk_users_online`.`online_session_id` = CONVERT(_utf8 '$session' USING latin1) COLLATE latin1_swedish_ci LIMIT 1";
						query_sql_run( $query );
					}
					else {
						$this->gk_debug( "<font COLOR=\"#C7A700\">User ".$row["online_user_name"]." is ok</font><br>" );
					}
				}
			}
		}
	
		function gk_clean_online_session_id() {
			$query = 'SELECT * FROM `gk_users_online` WHERE `online_session_id` = CONVERT(_utf8 \''.$this->session.'\' USING latin1) COLLATE latin1_swedish_ci';
			$this->gk_debug( $query."<br>" );
			$result = query_get_result( $query );
			if ( $result ) {
				$this->gk_debug( "Deleting last access<br>" );
				$query = "DELETE FROM `gk_users_online` WHERE `online_session_id` = CONVERT(_utf8 '".$this->session."' USING latin1) COLLATE latin1_swedish_ci";
				$this->gk_debug( $query."<br>" );
				query_sql_run( $query );
				$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
				$this->gk_update_values_to_session();
			}
			else
				$this->gk_debug( "User not found<br>" );
		}
			
		function user_exist( $user ) {
			$this->gk_debug( "I am in user_exist <br>" );
			$this->gk_debug( "Checking for user $user exist<br>" );
			$query= 'SELECT * FROM `gk_users` where user_login = \''.$user.'\' ';
			$this->gk_debug( $query."<br>" );
			$result = query_get_result( $query );
			if ( $result ) {
				$this->gk_debug( "find an user in registered list<br>" );
				$row = $result->fetch_array();
				extract( $row );
				$this->gk_debug( "find $user_login and check with $user<br>" );
				if ( $user_login == $user ) {
					$this->gk_debug( "<font COLOR=\"#C7A700\">$user_login exist</font><br>" );
					if ( $row["image"] == 1 )
						$this->image = true;
					return true;
				}
				$this->gk_debug( "<font COLOR=\"#C7A700\">$user NOT exist</font><br>" );
				return false;
			}
			$this->gk_debug( "No result from database so $user NOT exist<br>" );
			return false;
		}
	
		function get_authentication( $user , $passw ) {
			$this->gk_debug( "I am in get_authentication <br>" );
			if ( $user == "guest" ) {
				$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
				$this->gk_update_values_to_session();
				return GK_USER_GUEST;
			}
			$this->gk_debug( "Trying to authenticate user $user with password $passw<br>" );
			if ( $this->user_exist( $user ) == false ) {
				$this->gk_debug( "<font COLOR=\"#C7A700\">User $user NOT exist</font><br>" );
				$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
				$this->gk_update_values_to_session();
				return GK_USER_GUEST;
			}
			else {
				$this->gk_debug( "User exist<br>" );
				$this->gk_debug( "Check for user online<br>" );
				$query = 'SELECT * FROM `gk_users_online` WHERE `online_session_id` = CONVERT(_utf8 \''.$this->session.'\' USING latin1) COLLATE latin1_swedish_ci';
				$this->gk_debug( $query."<br>" );
				$result = query_get_result( $query );
				if ( $result ) {
					$this->gk_debug( "<font COLOR=\"#C7A700\">found the user online</font><br>" );
					$row = $result->fetch_array();
					extract( $row , EXTR_PREFIX_ALL , "gkv_" );
					$this->gk_debug( $row["online_user_name"]."<br>" );
					$this->gk_debug( $_SESSION["user"]."<br>" );
					$this->gk_debug( "Check for user name<br>" );
					if ( $row["online_user_name"] == $_SESSION["user"] ) {
						$this->gk_debug( "Updating last access<br>" );
						$query = "UPDATE `gk_users_online` SET `online_last_access` = ".time()." WHERE `online_session_id` = CONVERT(_utf8 '".$this->session."' USING latin1) COLLATE latin1_swedish_ci";
						$this->gk_debug( $query."<br>" );
						query_sql_run( $query );
						$this->gk_update_internal_values( $row["online_user_name"] , $row["online_clean_name"] , $row["online_user_role"] , $_SESSION["pass"] , true );
						$this->gk_update_values_to_session();
						$this->gk_debug( "<font COLOR=\"#C7A700\">OK. User authenticated</font><br>" );
						return $row["online_user_role"];
					}
					else {
						$this->gk_debug( "<font COLOR=\"#C7A700\">NOT OK. Authentication failed</font><br>" );
						$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
						$this->gk_update_values_to_session();
						$this->gk_debug( $this->role."<br>" );
						return GK_USER_GUEST;
					}
				}
				$this->gk_debug( "User is not online<br>" );
				$query = 'SELECT * FROM `gk_users` where user_login = \''.$user.'\' ';
				$this->gk_debug( $query."<br>" );
				$result = query_get_result( $query );
				if ( $result ) {
					$this->gk_debug( "User founduuuu on the registered list<br>" );
					$row = $result->fetch_array();
					extract( $row );
					$this->gk_debug( "find $user_login and check with $user<br>" );
					if ( $this->password_md5 == true ) {
						$this->gk_debug( "MD5 false : Check for password<br>" );
						$this->gk_debug( $passw." : ".md5( $passw )."<br>" );
						$this->gk_debug( $user_password."<br>" );
						$tmppassw = md5( $passw );
					}
					else {
						$this->gk_debug( "MD5 true : Check for password<br>" );
						$this->gk_debug( $passw."<br>" );
						$this->gk_debug( $user_password."<br>" );
						$tmppassw = $passw;
					}
					if ( $user_password == $tmppassw ) {
						if ( $this->autoconnect == true ) {
							$this->gk_set_cookie( $user , $user_password );
						}
						$this->gk_debug( "<font COLOR=\"#C7A700\">OK. User authenticated</font><br>" );
						$query = 'INSERT INTO `gk_users_online` (`online_id`, `online_user_name`, `online_clean_name`, `online_user_role`, `online_session_id`, `online_last_access`) VALUES (NULL, \''.$user_login.'\', \''.$user_name.'\', \''.$user_role.'\', \''.$this->session.'\', '.time().' ) ;';
						$this->gk_debug( $query."<br>" );
						query_sql_run( $query );
						$this->gk_update_internal_values( $user , $user_name , $user_role , $user_password , true );
						$this->gk_update_values_to_session();
						$this->gk_debug( $this->role."<br>" );
						return $this->role;
					}
					else {
						$this->gk_debug( "<font COLOR=\"#C7A700\">NOT OK. Authentication failed</font><br>" );
						$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
						$this->gk_update_values_to_session();
						$this->gk_debug( $this->role."<br>" );
						return GK_USER_GUEST;
					}
				}
				else {
					$this->gk_debug( "<font COLOR=\"#C7A700\">NOT OK. Authentication failed</font><br>" );
					$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
					$this->gk_update_values_to_session();
					$this->gk_debug( $this->role."<br>" );
					return GK_USER_GUEST;
				}
				$this->gk_debug( $this->role."<br>" );
				return GK_USER_GUEST;
			}
		$this->gk_debug( $this->role."<br>" );
		return GK_USER_GUEST;
		}
	
		function gk_update_internal_values( $nuser , $cuser , $nrole , $pass , $md5pass ) {
			$this->user = $nuser;
			$this->clean_user = $cuser;
			$this->role = $nrole;
			$this->password = $pass;
			$this->password_md5 = $md5pass;
			$this->level = $this->get_level_by_role( $nrole );
			$this->session = session_id();
		}
	
	
		function gk_update_values_to_session() {
			$_SESSION["user"] = $this->user;
			$_SESSION["clean_user"] = $this->clean_user;
			$_SESSION["role"] = $this->role;
			$_SESSION["pass"] = $this->password_md5;
		}
	
	
		function gk_logout( $session ) {
			$query = "SELECT * FROM `gk_users_online` WHERE `online_session_id` = CONVERT(_utf8 '$session' USING latin1) COLLATE latin1_swedish_ci";
			$this->gk_debug( $query."<br>" );
			$result = query_get_result( $query );
			if ( $result ) {
				$query = "DELETE FROM `gk_users_online` WHERE `gk_users_online`.`online_session_id` = CONVERT(_utf8 '$session' USING latin1) COLLATE latin1_swedish_ci LIMIT 1";
				query_sql_run( $query );
				$this->gk_update_internal_values( "guest" , "guest" , GK_USER_GUEST , "guest" , false );
				$this->gk_update_values_to_session();
				if ( isset( $_COOKIE["GK_USER"] ) )
					$this->gk_clean_cookie();
			}
			else {
				echo "Session $session not found";
			}
		}
		
		function gk_set_cookie( $user , $pass ) {
			if ( $this->debug == true ) {
				$this->gk_debug( "COOKIES for user $user Passw $pass<br>" );
				$this->gk_debug( "Expiration date ".strftime( "%A, %d/%m/%Y" , ( time() + ( 3600  * 24 * 365 ) ) )."<br>" );
				$this->gk_debug( "<strong>In DEBUG autoconnect disabled</strong><br>" );
			}
			else {
//				$opt = array( "samesite" => "None" , "secure" => "false" , "expires" => ( time() + ( 3600  * 24 * GK_DAYS_COOKIES ) ) );
				$opt = array( "samesite" => "None" , "expires" => ( time() + ( 3600  * 24 * GK_DAYS_COOKIES ) ) );
				setcookie( "GK_USER" , $user , $opt );
				setcookie( "GK_PASS" , $pass , $opt );
			}
		}
		
		function gk_clean_cookie() {
			$this->autoconnect = false;
			setcookie( "GK_USER" , "" );
			setcookie( "GK_PASS" , "" );
		}
	
		function gk_can_admin() {
			if ( ( $this->role == "Administrator" ) || ( $this->role == "SuperUser" ) )
				return true;
			return false;
		}
	
		function gk_cannot_admin() {
			if ( ( $this->role != "Administrator" ) && ( $this->role != "SuperUser" ) )
				return true;
			return false;
		}
	
		function gk_get_real_ip() {
			//check ip from share internet
			if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			//to check ip is pass from proxy
			elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
	
	
	}

?>

