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
<html xmlns="http://www.w3.org/1999/html">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="stylesheet.css">
  <style>

  </style>
</head>
<body>

<!--<center><h2>Arlington Sprouts </h2></center>-->
<header>
  <div class="header">

    <a href="index.php" class="logo"> <img src="images/logo1.png" height="50" width="60"></a>
    <a href="index.php" class="name" style="font-family:Brush Script MT ; font-size: 25px">ArlingtonSprouts</a>

    <div class="header-right">

      <a href="index.php" class="onHover">Home</a>

      <a href=#blank class="onHover">About</a>
      <a href="search.php" class="onHover">Products</a>


      <a href=#blank class="onHover">Login</a>
      <a href=#blank class="onHover">Register</a>
      <a href=#blank class="onHover">Location</a>
      &emsp; &emsp;

    </div>
  </div>

</header>
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
    <button class='DeleteButton' onclick='deleteItem(" . $row['iId'] . ")'>Delete</button>
  <button class='UpdateButton' onclick='editName(" . $row['iId'] . ", this.parentNode)'>Update</button>

</li>
";

  }
  echo "</ul>";
} else {
  echo "No results found.";
}
?>

<div id="itemDetails"></div>

<div id="delete-overlay"></div>
<div id="delete-modal-box">

    <p>Are you sure you want to delete this item?</p>

      <button id="confirm-delete-button">Yes</button>
      <button id="cancel-delete-button">Cancel</button>
    </div>
</div>

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

  });

  function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
      a1 = li[i].getElementsByTagName("a")[0];
      a2 = li[i].getElementsByTagName("a")[1];
      txtValue1 = a1.textContent || a1.innerText;
      txtValue2 = a2.textContent || a2.innerText;
      if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
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
        console.log(itemDetails);
        // Add item details to the clicked li element
        var detailsElement = document.createElement("div");
        detailsElement.classList.add('detailsBox');
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

  function deleteItem(id) {
    const modalBox = document.getElementById('delete-modal-box');
    const overlay = document.getElementById('delete-overlay');
    const confirmButton = document.getElementById('confirm-delete-button');
    const cancelButton = document.getElementById('cancel-delete-button');

    modalBox.style.display = 'block';
    overlay.style.display = 'block';

    confirmButton.addEventListener('click', function() {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'delete-item.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
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
      xhr.send('itemId=' + encodeURIComponent(id));
      modalBox.style.display = 'none';
      overlay.style.display = 'none';
    });

    cancelButton.addEventListener('click', function() {
      modalBox.style.display = 'none';
      overlay.style.display = 'none';
    });
  }





</script>
<div class=" footer">
  <div class="footer-left">
    <p>Copyrights 2022
      All Rights Reserved</p>
  </div>


  <div class=" footer-right">
    Follow Us &nbsp;
    <a href="#blank"> <img src="images/instagram.png"> &nbsp; </a>
    <a href="#blank"> <img src="images/twitter.png"> &nbsp;</a>
    <a href="#blank"> <img src="images/facebook.png"> &nbsp;</a>

  </div>

</div>
</body>
</html>
