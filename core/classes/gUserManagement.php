<?php

  /*
    Class UserManagement
    By gVisions (c) 2009
    gUserManagement
    www.gvisions.de
    This file is a part of the gFramework
  */
  
  class UserManagement extends gFramework {

    var $gSessionUse = false;
    private $facebook = 0;
    private $me = 0;
    private $session = 0;
    public $uid = 0;

    /*
      function gSessionUse
      -> var bool use
      Aendert den Inhalt der public var gSessionUse in true oder false. Je nachdem, ob die Klasse genutzt wird, oder nicht.
    */
    function gSessionUse($bool) {
      $this->gSessionUse = $bool;
      echo $this->gSessionUse;
      return true;
    }
  
    

    
    
    
        /*
      function ifLogin
      Prueft, ob der User eingeloggt ist oder nicht.
      Dabei wird erst geschaut, ob das System gSession nutzt oder PHP-Session
    */
    function ifLogin() {
  /*    if ($this->gSessionUse==true){
        if (!class_exists('gSession')) {
        die ('Die Klasse gSession ist nicht definiert.'.E_USER_WARNING);
      }
      $gS = new gSession();
      if ($gS->getSession==$_COOKIE['gSessionID']) {
        return true;
      } else {
        return false;
      }
      } else {*/
        if (isset($_SESSION['login'])) {
          if ($_SESSION['login']==true) {
            return true;
          }
        return false;
        }
      #}
    }
    
    /*
    function UserLogin
    Loggt einen User ein
    -> var str username
    -> var str password
    */
    function UserLogin($username,$password,$md5=true) {
      $db = new db();
      $db->query("SELECT * FROM ".pfw."_user WHERE `username` = '".$username."'")  or die (mysql_error());
      if ($db->num_rows() == "0" OR $db->num_rows() == "") { $_SESSION['login']=false; return false; }   
      $row = $db->fetch();                          
      if ($md5==true) { $md5_p  = md5($password); } else { $md5_p = $password;  }                       
      if ($row->username==$username AND $row->password==$md5_p) {               
        
          //Alle Eingaben ok
          /*if ($this->gSessionUse==true){
            $gS = new gSession();
            $gS->LoginFull($username);
            return true;
          } else {*/
            $_SESSION['login']=true;      
            $_SESSION['userid']=$row->id;
	          $_SESSION['group']=$row->group;
            return true;              
          #}
      } else {
        return false;      
      }
    }
    
    /*
    function UserLogout
    Loggt User aus
    */
    function UserLogout() {
      if ($this->gSessionUse==true){
        $gS = new gSession();
        $gS->DestroySession();
        return true;
      } else {
        session_destroy();
        return true;
      }  
    }
    
    /* 
    function DeleteUser
    Loescht Benutzer aus der Datenbank
    -> var str userid
    */
    function DeleteUser($userid){
      $db = new gmysql();
      $db->query("DELETE FROM `".datenbank."`.`".pfw."_user` WHERE `LoginData`.`id` = ".$userid." LIMIT 1;");
      if ($Framework['Config']['UseProfile']==true) {
        $db->query("DELETE FROM `".db."`.`".prafix."_ProfileData` WHERE `ProfileData`.`userid` = ".$userid." LIMIT 1;");
      }
      $message = $Lang['UserManagement']['DeleteUserOk'];
      $return = array();
      $return['message'] = $message;
      $return['bool'] = true;
      return $return;
    }
    
    /*
    function Registration
    Erstellt einen neuen Benutzer in der Datenbank
    -> var str username
    -> var str password
    -> var str email
    */
    function Registration ($username,$password,$email) {
	if ($username=="" OR $password=="" OR $email=="") { return false; }
      $db = new db();
      $db->query("SELECT id FROM ".pfw."_user WHERE `username` = '$username'");
      if ($db->num_rows()=="") { 
      echo $db->num_rows();
      $sql = "INSERT INTO ".pfw."_user (`id`, `username`, `password`, `mail`, `group`) VALUES (NULL, '".$username."', '".md5($password)."', '".$email."', '7');";
      $db->query($sql);
      /*$return['message'] = $Lang['UserManagement']['RegistrationComplete'];
      $return['bool'] = true;
      return $return;  */
      	return true;
      } else {
	#return false;
}
    }
    
    function isAllowed($userID, $flag) {  
     $groupID = $this->userGroup($userID);
     if ($groupID=="") { $groupID = 0; }
     
     $db = new db();
     $db->query("SELECT * FROM ".pfw."_rights WHERE `value` = '".$flag."'");
     $row = $db->fetch();
     $db->query("SELECT * FROM ".pfw."_group_right WHERE `group` = '$groupID' AND `right` = '".$row->id."'");
     if ($db->num_rows() == "" OR $db->num_rows() == "0" OR $db->num_rows() == 0)
     {
      return false;
     }
     return true;

    }
    
    function userGroup($userID) {
      $db = new db();
      $db->query("SELECT `group` FROM ".pfw."_user WHERE id = $userID");
      $row = $db->fetch();
      return $row->group;
    }

    function getUserName($id=0) {
		if ($id ==0)
			$id = $this->getCurrentUser();
  	    $db = new db();
  	    $db->query("SELECT `username` FROM ".pfw."_user WHERE id = $id");	
        $row = $db->fetch();
        return $row->username;
    }
    function getPassword($id) {
  	    $db = new db();
  	    $db->query("SELECT `password` FROM ".pfw."_user WHERE id = $id");	
        $row = $db->fetch();
        return $row->password;
    }
    function getAvatar($id) {
	   $db = new db();
	   $db->query("SELECT `avatar` FROM ".pfw."_user WHERE id = $id");	
     $row = $db->fetch();
	   if (empty($row->avatar)) { $avatar="noneavatar.png"; } else { $avatar = $row->avatar; }
      	return $avatar;
    }
    
    function getCurrentUser()
    {
    	if ($this->ifLogin())
    	{
    		return $_SESSION["userid"];
    	}
    	else
    	{
    		return 0;
    	}
    }

 }
