<?php
include_once('includes/config.php');

$itemId = $_GET['itemId'];

// Select the item with the specified itemId
$sql = "SELECT * FROM `item` WHERE `iId` = '$itemId'";
$result = mysqli_query($db, $sql);

// Display the item details as HTML
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo "<h3>"."ItemName : ". $row['Iname'] . "</h3>";
  echo "<h3>" ."ItemPrice : ". $row['Sprice'] . "</h3>";

} else {
  echo "Item not found.";
}

// Close the database connection
mysqli_close($db);
?>
