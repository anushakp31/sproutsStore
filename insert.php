<?php
session_start();
include_once('includes/config.php');

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // get form data
  $item_name = $_POST["itemName"];
  $price = $_POST["itemPrice"];

  // validate form data
  if (empty($item_name) || empty($price)) {
    echo json_encode(array("success" => false, "message" => "Please enter both item name and price."));
    exit;
  }

  // insert data into database
  $sql = "INSERT INTO item (Iname, Sprice) VALUES ('$item_name', $price)";
  if ($db->query($sql) === TRUE) {
    $response = array(
      'success' => true,
      'message' => 'Item name inserted successfully',
      'item_name' => $item_name
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
