<?php
  require_once("validation_functions.php");

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . $country_id . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . $id . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
    // TODO add validations
    if(is_blank($state["name"])){
      $errors[]="State name cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($state["name"],['min' => 2,'max' => 255])==false){
        $errors[]="The length for state name has to between 2 and 255";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^a-zA-Z]/",$state["name"])){
        $errors[]="The state name can only have letters";
      }
    }

    if(is_blank($state["code"])){
      $errors[]="State code cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($state["code"],['min' => 2,'max' => 3])==false){
        $errors[]="The length for state name has to between 2 and 5";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^A-Z]/", $state["code"])){
        $errors[]="The state code can only have capital letters";
      }
    }
    

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $name=htmlspecialchars($state["name"]);
    $code=htmlspecialchars($state["code"]);
    $country_id=htmlspecialchars($state["country_id"]);
    $sql = "INSERT into states". " (name,code,country_id) "." VALUES('$name','$code','$country_id')"; // TODO add SQL
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $name=htmlspecialchars($state["name"]);
    $code=htmlspecialchars($state["code"]);
    $country_id=htmlspecialchars($state["country_id"]);
    $id=htmlspecialchars($state["id"]);
    $sql = "UPDATE states SET name='$name',code='$code',country_id='$country_id' WHERE id='$id' "; // TODO add SQL
    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . $state_id . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . $id . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
    // TODO add validations
    if(is_blank($territory["name"])){
      $errors[]="Territory name cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($territory["name"],['min' => 2,'max' => 255])==false){
        $errors[]="The length for Territory name has to between 2 and 255";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^a-zA-Z]/",$territory["name"])){
        $errors[]="The territory name can only have letters";
      }
    }

    if(is_blank($territory["code"])){
      $errors[]="Territory code cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($territory["code"],['min' => 2,'max' => 3])==false){
        $errors[]="The length for territory name has to between 2 and 5";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^A-Z]/", $territory["code"])){
        $errors[]="The territory code can only have capital letters";
      }
    }
    

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $name=htmlspecialchars($territory["name"]);
    $state_id=htmlspecialchars($territory["state_id"]);
    $position=htmlspecialchars($territory["position"]);
    $sql = "INSERT into territories (name,state_id,position) VALUES('$name','$state_id','$position')"; // TODO add SQL
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $name=htmlspecialchars($territory["name"]);
    $state_id=htmlspecialchars($territory["state_id"]);
    $position=htmlspecialchars($territory["position"]);
    $id=htmlspecialchars($territory["id"]);
    $sql = "UPDATE territories SET name='$name',state_id='$state_id',position='$position' WHERE id='$id';"; // TODO add SQL
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . $id . "';";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
    // TODO add validations
    if(is_blank($salesperson["first_name"])){
      $errors[]="First name cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($salesperson["name"],['min' => 2,'max' => 255])==false){
        $errors[]="The length for first name has to between 2 and 255";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^a-zA-Z]/",$salesperson["name"])){
        $errors[]="The first name can only have letters";
      }
    }

    if(is_blank($salesperson["last_name"])){
      $errors[]="State code cannot be blank";
    }else{
      //MY CUSTOM VALIDATION
      if(has_length($salesperson["last_name"],['min' => 2,'max' => 255])==false){
        $errors[]="The length for last name has to between 2 and 5";
      }
      //MY CUSTOM VALIDATION
      if(preg_match("/[^a-zA-Z]/", $salesperson["last_name"])){
        $errors[]="The last name can only have letters";
      }
    }

    if(is_blank($salesperson["phone"])){
      $errors[]="The number cannot be empty";
    }else{
      if(has_length($salesperson["phone"],['min'=> 2,'max'=>255])==false){
        errors[]="The length for the phone number has to be between 2 and 255";
      }
      if(preg_match("/[^0-9\(\)-]/", $salesperson["phone"])){
        $errors[]="Phone number can only have digits (, ) and -";
      }
    }
    

    return $errors;

  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $firstname = htmlspecialchars($salesperson["first_name"]);
    $lastname = htmlspecialchars($salesperson["last_name"]);
    $phone = htmlspecialchars($salesperson["phone"]);
    $email = htmlspecialchars($salesperson["email"]);
    $sql = "INSERT into salespeople". " (first_name,last_name,phone,email) "." VALUES('$firstname','$lastname','$phone','$email')"; // TODO add SQL
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }


  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    echo $salesperson["last_name"];
    $firstname = htmlspecialchars($salesperson["first_name"]);
    $lastname = htmlspecialchars($salesperson["last_name"]);
    $email = htmlspecialchars($salesperson["email"]);
    $phone = htmlspecialchars($salesperson["phone"]);
    $id = htmlspecialchars($salesperson["id"]);
    //$sql = "UPDATE salespeople SET first_name=" . "'$firstname'" . ", last_name="."'$lastname'".", email="."'$email'".", phone="."'$phone'"." WHERE id="."'$id'"." LIMIT 1 ;"; // TODO add SQL
    $sql = "UPDATE salespeople SET first_name = '$firstname' , last_name = '$lastname' , email = '$email' , phone = 'phone' WHERE id = '$id' ";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    }
    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;
    date_default_timezone_set('UTC');

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    // $sql = "INSERT INTO users ";
    // $sql += "(first_name, last_name, email, username, created_at) ";
    // $sql += "VALUES (";
    // $sql += "'" . $user['first_name'] . "',";
    // $sql += "'" . $user['last_name'] . "',";
    // $sql += "'" . $user['email'] . "',";
    // $sql += "'" . $user['username'] . "',";
    // $sql += "'" . $created_at . "',";
    // $sql += ");";

    $firstname = htmlspecialchars($user["first_name"]);
    $lastname = htmlspecialchars($user["last_name"]);
    $email = htmlspecialchars($user["email"]);
    $username = htmlspecialchars($user["username"]);

    $sql = "INSERT INTO users" . " (first_name,last_name,username,email,created_at)" . " VALUES('$firstname','$lastname','$username','$email','$created_at')";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . $user['first_name'] . "', ";
    $sql .= "last_name='" . $user['last_name'] . "', ";
    $sql .= "email='" . $user['email'] . "', ";
    $sql .= "username='" . $user['username'] . "' ";
    $sql .= "WHERE id='" . $user['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

?>
