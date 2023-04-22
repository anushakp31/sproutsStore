<?php
session_start();
include_once('includes/config.php');

// Establish a connection to the MySQL database
$search = '';

// Check if search form has been submitted
if (isset($_POST['search'])) {
  // Get search query from form input
  $search = $_POST['search'];
}

// Select the data to display
$sql = "SELECT * FROM `item` WHERE `Iname` LIKE '%$search%' OR `iId` = '%$search%'";

// Execute the SQL query
$result = mysqli_query($db, $sql);

// Close the database connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="stylesheet.css">
  <style>

  </style>
</head>
<body>

<h2>Arlington Sprouts </h2>
<a href="insert.php"><button>Insert</button></a> &nbsp;
<button id="insert-button">Insert Item</button>

<div id="modal-box">
  <div id="modal-content">
    <h2>Insert Item</h2>
    <form id="insert-form">
      <label for="item-name">Item Name:</label>
      <input type="text" id="item-name" name="item-name" required>
      <label for="item-price">Item Price:</label>
      <input type="number" id="item-price" name="item-price" required>
      <button type="submit">Insert</button>
      <button type="button" id="close-button">Close</button>
    </form>
  </div>
</div>



<br><br>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names or ids.." title="Type in a name or id">
<?php
if (mysqli_num_rows($result) > 0) {
  echo "<ul id='myUL'>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<li>
<a>".$row["iId"].".</a>
  <a href='javascript:;' onclick='showDetails(" . $row['iId'] . ", this.parentNode)'>". $row['Iname'] . "</a>
  <button onclick='editName(" . $row['iId'] . ", this.parentNode)'>Update</button>
  <button onclick='deleteItem(" . $row['iId'] . ")'>Delete</button>
</li>
";

  }
  echo "</ul>";
} else {
  echo "No results found.";
}
?>

<div id="itemDetails"></div>
<script>

  const insertButton = document.getElementById('insert-button');
  const modalBox = document.getElementById('modal-box');
  const closeButton = document.getElementById('close-button');
  const insertForm = document.getElementById('insert-form');

  insertButton.addEventListener('click', function() {
    modalBox.style.display = 'block';
  });

  closeButton.addEventListener('click', function() {
    modalBox.style.display = 'none';
  });

  insertForm.addEventListener('submit', function(event) {
    event.preventDefault();
    const itemName = document.getElementById('item-name').value;
    const itemPrice = document.getElementById('item-price').value;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'insert.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        console.log(xhr.responseText)
        const response = JSON.parse(xhr.responseText);
        console.log(response)
        if (response.success) {
          console.log(xhr.responseText);
          const response = JSON.parse(xhr.responseText);
          console.log(response);
          alert(response.message);
          location.reload();
        } else {
          alert(response.message);
        }
      } else {
        alert('Error: ' + xhr.status);
      }
    };
    xhr.onerror = function() {
      alert('Error: ' + xhr.status);
    };
    xhr.send('itemName=' + encodeURIComponent(itemName) + '&itemPrice=' + encodeURIComponent(itemPrice));


    modalBox.style.display = "none";
    //overlay.style.display = "none";
  });

  function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
  function showDetails(itemId, li) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var itemDetails = this.responseText;
        // Add item details to the clicked li element
        var detailsElement = document.createElement("div");
        detailsElement.innerHTML = itemDetails;
        li.appendChild(detailsElement);
      }
    };
    xmlhttp.open("GET", "get-item-details.php?itemId=" + itemId, true);
    xmlhttp.send();
  }
  function editName(itemId, listItem) {
    console.log(itemId)
    const itemNameLink = listItem.querySelector('a:nth-of-type(2)');
    const itemName = itemNameLink.textContent.trim();

    const inputField = document.createElement('input');
    inputField.value = itemName;

    itemNameLink.replaceWith(inputField);

    const updateButton = listItem.querySelector('button');
    updateButton.textContent = 'Save';
    updateButton.onclick = function() {
      const newName = inputField.value.trim();
      if (newName === '') {
        alert('Please enter a name');
        return;
      }
      console.log(newName)
      updateItemName(itemId, newName, listItem);

    };
  }

  function updateItemName(itemId, newName, listItem) {
    const xhr = new XMLHttpRequest();
    const editInput = listItem.querySelector('input');
    xhr.open('POST', 'update-item-name.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {

        console.log(xhr.responseText);
        const response = JSON.parse(xhr.responseText);
        console.log(response);
        if (response.success) {
          const itemName = document.createElement('a');
          itemName.href = 'javascript:;';
          itemName.onclick = function() {
            showDetails(itemId, listItem);
          };
          itemName.textContent = itemId + ' . ' + newName;
          const oldItemName = listItem.querySelector('a:nth-of-type(1)');
          if (oldItemName) {
            oldItemName.replaceWith(itemName);
          }
          //listItem.querySelector('a:nth-of-type(1)').replaceWith(itemName);

          const updateButton = listItem.querySelector('button');
          updateButton.textContent = 'Update';
          updateButton.onclick = function() {
            editName(itemId, listItem);
          };
          editInput.style.display = 'none';
          location.reload();
        } else {
          alert(response.message);
        }
      } else {
        alert('Error: ' + xhr.status);
      }
    };
    xhr.onerror = function() {
      alert('Error: ' + xhr.status);
    };
    xhr.send('itemId=' + encodeURIComponent(itemId) + '&newName=' + encodeURIComponent(newName));
  }



</script>

</body>
</html>
