<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }
	.responsive{
		width: 100%;
		height: auto;
        object-fit: cover;
        object-position: bottom;
	}
        @media only screen and (max-width: 500px) {
            .responsive {
                width: 100%;
                float: none;
                text-align: center;
            }
        }
    .card{
        padding: 3em;
        height: 5em;
    }
    </style>

    <title>AngelCare Hospital</title>

    <meta name="viewport" content="width=device-width; initial-scale=1.0">

</head>
<body>
<header>
    <div class="header">

        <a href="index.php" class="logo"> <img src="images/logo1.png" height="50" width="60"></a>
        <a href="index.php" class="name" style="font-family:Brush Script MT ; font-size: 25px">ArlingtonSprouts</a>

        <div class="header-right">

            <a href="index.php" class="onHover">Home</a>

            <a href="about.html" class="onHover">About</a>


            <a href="search.html" class="onHover">Login</a>
            <a href="newuser.html" class="onHover">Register</a>
            <a href="locations.html" class="onHover">Location</a>
            &emsp; &emsp;

        </div>
	</div>

</header>


<!--<div class="background-banner">-->
<img class="banner responsive" src="images/backgroundImage.png " style="height: 760px;"/>
<div class="cards">
    <div class="card">
        <a href="bookAppoint.html">Request an Appointment</a>
    </div>
    <div class="card">
        <a href="patientlogin.html"> Login as Patient</a>
    </div>
    <div class="card">
        <td><a href="doctorlogin.html">Login as Doctor</a>
    </div>
</div>

<div class="specialty">
    <div class="headline"> Why choose <br> Arlington Sprouts ?</div>
    <div class=box style="overflow-x:auto; ">

        <table style="width:100%">
            <tr>

                <th>Wide Range of Organic Products</th>
                <th>Fresh Produce</th>
            </tr>
            <tr>
                <td>Discover a healthier way of living with Sprouts. Our stores offer a wide range of organic products that are free from harmful chemicals and ethically sourced</td>
                <td>Experience the freshest produce at Sprouts. We take great care in selecting and storing our produce to ensure that it's always of the highest quality.
                </td>

            </tr>
            <tr>
                <th>Affordable Prices</th>
                <th>Great Customer Service </th>

            </tr>
            <tr>
                <td>We believe that healthy eating shouldn't break the bank. That's why we offer competitive prices on all of our products. Plus, with weekly deals and specials, you can save even more money on your grocery bill.</td>
                <td>We put our customers first. Our friendly and knowledgeable staff are always here to help you find what you need. Plus, we offer a variety of convenient services like online ordering and delivery.
                </td>

            </tr>
        </table>



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
    </div>
</div>

</body>
</html>
    </body>
</html>
