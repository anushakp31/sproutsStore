
<?php
session_start();
include_once('includes/config.php');

// Get the item ID and new name from the POST request
$itemId = $_POST['itemId'];
$newName = $_POST['newName'];
//echo $itemId, $newName;
// TODO: Update the item name in the database
// update the item name in the database
$sql = "UPDATE item SET Iname='$newName' WHERE iId='$itemId'";
//if ($db->query($sql) === TRUE) {
//  echo "Item name updated successfully";
//} else {
//  echo "Error updating item name: " . $db->error;
//}
$db->query($sql);
// Send a response back to the client
$response = array(
  'success' => true,
  'message' => 'Item name updated successfully',
        'item_name' => $newName
);
echo json_encode($response);
?>
