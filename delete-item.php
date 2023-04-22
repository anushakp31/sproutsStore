<?php
session_start();
include_once('includes/config.php');

// check if item ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["itemId"])) {
  $itemId = $_POST["itemId"];

  // delete item from database
  $sql = "DELETE FROM item WHERE iId = $itemId";
  if ($db->query($sql) === TRUE) {
    $response = array(
      'success' => true,
      'message' => 'Item deleted successfully'
    );
  } else {
    $response = array(
      'success' => false,
      'message' => 'Error: ' . $db->error
    );
  }
  echo json_encode($response);
  $db->close();
  exit;
}
?>
