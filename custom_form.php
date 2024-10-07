<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $companyName = $_POST['company_name'];
    $companyPhone = $_POST['company_phone'];
    $quantity = $_POST['quantity'];
    $customQuantity = $_POST['custom_quantity']; // Custom quantity input
    $messageContent = $_POST['message'];
    $interestedProduct = $_POST['interested_product'];

    // Verify reCAPTCHA
    $recaptchaSecret = ""; // Replace with your Secret Key
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($verifyResponse);

    // Check if the quantity is valid if the quantity is "250+"
    if ($quantity === "250+" && (!isset($customQuantity) || $customQuantity < 251)) {
        echo "<script>alert('Please enter a number of products that is at least 251.');</script>";
    } elseif ($responseData->success) {
        $to = ""; // Change to your email
        $subject = "Product Inquiry from $name";
        $message = "Name: $name\nEmail: $email\nMobile: $mobile\nCompany Name: $companyName\nCompany Phone: $companyPhone\nQuantity: $quantity";

        // Append custom quantity if "250+" is selected
        if ($quantity === "250+" && $customQuantity) {
            $message .= "\nNumber of Products: $customQuantity";
        }

        $message .= "\nMessage: $messageContent\nInterested in Product: $interestedProduct";

        $headers = "From: $email";

        if (mail($to, $subject, $message, $headers)) {
            echo "<script>alert('Mail sent successfully!');</script>";
        } else {
            echo "<script>alert('Mail not sent. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('reCAPTCHA verification failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inquiry Form</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: white; /* White header */
            display: flex;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header img {
            max-height: 50px; /* Adjust logo size */
            margin-right: 20px; /* Space between logo and nav */
        }
        .nav {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .nav li {
            margin-right: 20px;
        }
        .nav a {
            text-decoration: none;
            color: black;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: green;
            text-align: center;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: green; /* Submit button color */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: darkgreen; /* Darker green on hover */
        }
        .required {
            color: red; /* Color for required field indicator */
        }
        .breadcrumbs {
            padding: 10px;
            background: orange; /* Orange background */
            color: white; /* White text */
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .breadcrumbs a {
            color: white; /* White text for links */
            text-decoration: none; /* No underline for links */
        }
        footer {
            background-color: black; /* Black footer */
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative; /* Ensure footer is positioned at the bottom */
            bottom: 0;
            width: 100%;
        }
    </style>

    <script>
        function toggleQuantityInput() {
            var quantitySelect = document.getElementById("quantity");
            var customQuantityDiv = document.getElementById("custom-quantity");

            if (quantitySelect.value === "250+") {
                customQuantityDiv.style.display = "block";
            } else {
                customQuantityDiv.style.display = "none";
            }
        }
    </script>
</head>
<body>

<!-- Header with logo and navigation -->
<div class="header">
    <img src="" alt="Logo"> <!-- Replace with your logo path -->
    <ul class="nav">
        <li><a href="/home">Home</a></li>
        <li><a href="/service">Service</a></li>
        <li><a href="/products">Product</a></li>
        <li><a href="/company/about-us">Company</a></li>
        <li><a href="/contact-us">Contact Us</a></li>
    </ul>
</div>

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <a href="/home">Home</a> &gt;
    <a href="/products">Products</a> &gt;
    <span>Product Inquiry</span>
</div>

<div class="form-container">
    <h1>Dr.Web Enterprise Suite Inquiry Form</h1>

    <form action="" method="POST">
        <label for="name">Name: <span class="required">*</span></label>
        <input type="text" name="name" placeholder="John Doe" required>

        <label for="email">Email: <span class="required">*</span></label>
        <input type="email" name="email" placeholder="johndoe@example.com" required>

        <label for="mobile">Mobile Number: <span class="required">*</span></label>
        <input type="text" name="mobile" placeholder="+977 98XXXXXXXX" required>

        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" placeholder="ABC Corp.">

        <label for="company_phone">Company Phone Number:</label>
        <input type="text" name="company_phone" placeholder="+977 1 XXXXXX">

        <label for="interested_product">Interested in Product:</label><br>
        <select name="interested_product" required>
            <option value="">-Select Product-</option>
            <option value=""></option>
            <option value=""></option>
            <option value=""></option>
            <option value=""></option>
            <option value=""></option>
        </select><br>

        <label for="quantity">Quantity: <span class="required">*</span></label>
        <select id="quantity" name="quantity" onchange="toggleQuantityInput()" required>
            <option value="">-Select Quantity-</option>
            <option value="1-10">1-10</option>
            <option value="11-50">11-50</option>
            <option value="51-100">51-100</option>
            <option value="101-250">101-250</option>
            <option value="250+">250+</option>
        </select>

        <div id="custom-quantity" style="display: none;">
            <label for="custom_quantity">Please specify custom quantity (min. 251): <span class="required">*</span></label>
            <input type="number" name="custom_quantity" min="251" placeholder="Enter custom quantity">
        </div>

        <label for="message">Your Message:</label>
        <textarea name="message" rows="5" placeholder="Your message here..."></textarea>

        <div class="g-recaptcha" data-sitekey=""></div> <!-- Replace with your Site Key -->
        <br>
        <input type="submit" value="Submit">
    </form>
</div>
<footer style="background-color: #000000; padding: 5px;">

    <!-- Include Font Awesome from CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin: 0 55px;">
        <!-- Connect with Us -->
        <div style="flex: 1; text-align: left;">
            <h3 style="font-size: 20px; color: #ffffff; margin-bottom: 20px; font-family: Arial, sans-serif;">Connect with Us</h3>

            <div style="margin: 20px 0;">
                <a href="https://www.facebook.com/GreenTechnologyNepal" target="_blank" title="Facebook" rel="noopener"
                   style="margin: 0 15px; color: #ffffff; text-decoration: none; font-size: 40px; transition: color 0.3s ease;"
                   onmouseover="this.style.color='rgba(0, 123, 255, 1)'" onmouseout="this.style.color='rgba(255, 255, 255, 1)'">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/greentechnologynepal/" target="_blank" title="Instagram" rel="noopener"
                   style="margin: 0 15px; color: #ffffff; text-decoration: none; font-size: 40px; transition: color 0.3s ease;"
                   onmouseover="this.style.color='rgba(155, 89, 182, 1)'" onmouseout="this.style.color='rgba(255, 255, 255, 1)'">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>

            <div style="margin-top: 20px; font-size: 18px; color: #ffffff;">
                <p style="margin: 5px 0;"><i class="fas fa-phone-alt" style="margin-right: 10px;"></i> Phone: +977 1 XXXXX</p>
                <p style="margin: 5px 0;"><i class="fas fa-clock" style="margin-right: 10px;"></i> Operating Hours: Sun-Fri, 10:00 AM - 6:00 PM</p>
            </div>
        </div>

        <!-- Center Section for Company Links -->
        <div style="flex: 1; text-align: center;">
            <h3 style="color: white;">Company Links</h3>
            <div style="display: flex; flex-direction: column; align-items: Justify;">
                <a href="https://greentechnology.com.np/company/about-us"
                   style="padding: 12px 25px; margin: 10px 0; border: none; border-radius: 5px; background-color: #1aa202; color: white; font-size: 16px; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;"
                   onmouseover="this.style.backgroundColor='#13E000'" onmouseout="this.style.backgroundColor='#1AA202'"> About Us </a>
                <a href="https://greentechnology.com.np/company/board-members"
                   style="padding: 12px 25px; margin: 10px 0; border: none; border-radius: 5px; background-color: #1aa202; color: white; font-size: 16px; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;"
                   onmouseover="this.style.backgroundColor='#13E000'" onmouseout="this.style.backgroundColor='#1AA202'"> Board Of Directors </a>
                <a href="https://greentechnology.com.np/company/group-companies"
                   style="padding: 12px 25px; margin: 10px 0; border: none; border-radius: 5px; background-color: #1aa202; color: white; font-size: 16px; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;"
                   onmouseover="this.style.backgroundColor='#13E000'" onmouseout="this.style.backgroundColor='#1AA202'"> Our Group </a>
            </div>
        </div>

        <!-- Our Work Section -->
        <div style="flex: 1; text-align: justify;">
            <h3 style="color:white;margin-left:50px;"> Our Work</h3>
            <p style="font-size: 18px; color: #777777; line-height: 1.8; margin: 20px 0; font-family: Arial, sans-serif; margin-left:50px;">
                <strong style="font-size: 20px; color: #1aa202;">Innovation is the name of the game at Green Technology,</strong>
                <span style="color: #eeeeee;"> with our teams, from software solution development to the design of hardware systems,
                always striving to deliver world-class results. Whether you are trying to make processes smoother, improve your digital presence,
                or leverage the newest technologies, we are here to make your dream come true.</span>
            </p>
        </div>
    </div>

    <!-- Copyright -->
    <div style="margin-top: 20px; font-size: 14px; color: #ffffff; text-align: center;">
        <p id="copyright" style="margin: 0;">© <span id="year"></span> Green Technology Pvt. Ltd. All rights reserved. Trademarks used therein are trademarks or registered trademarks of Green Technology Pvt. Ltd. All other names and brands are registered trademarks of their respective companies.</p>
        <script>
            // Get the current year
            const currentYear = new Date().getFullYear();
            // Set the inner text of the 'year' span
            document.getElementById('year').innerText = currentYear;
        </script>
    </div>
</footer>
</body>
</html>
