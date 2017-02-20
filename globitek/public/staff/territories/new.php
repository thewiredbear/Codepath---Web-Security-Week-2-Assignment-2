<?php
require_once('../../../private/initialize.php');
require_once('../../../private/functions.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}

$state_id=$_GET['id'];

// Set default values for all variables the page needs.
$errors = array();
$territory = array( "name" => "","state_id" => "","position" => "");
$territory["state_id"] = $state_id;

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST["name"])){
    $territory["name"] = $_POST["name"]; 
  }
  // if(isset($_POST["state_id"])){
  //   $territory["state_id"] = $_POST["state_id"]; 
  // }
  if(isset($_POST["position"])) {
    $territory["position"] = $_POST["position"]; 
  }


  $result = insert_territory($territory);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to("show.php?id=" . $new_id);
  } else {
    $errors = $result;
    echo display_errors($errors);
  }
}


?>
<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo $territory['state_id'];?>">Back to State Details</a><br />

  <h1>New Territory</h1>

  <!-- TODO add form -->

  <?php echo display_errors($errors); ?>
  <form action="<?php $_PHP_SELF?>" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo $_POST['name']; ?>" /><br />
    Position:<br />
    <input type="number" name="position" value="<?php echo $territory["position"]; ?>" /><br />
    <br />
    <input type="submit" name="submit" value="Create"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
