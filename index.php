<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $companyName = $_POST['company_name'];
    $companyPhone = $_POST['company_phone'];
    $quantity = $_POST['quantity'];
    $quantityNumber = isset($_POST['quantity_number']) ? $_POST['quantity_number'] : null;
    $messageContent = $_POST['message'];
    $interestedProduct = $_POST['interested_product'];

    // Verify reCAPTCHA
    $recaptchaSecret = "6LfpiUYqAAAAALdw9fSqP07ghNUpICHwsYBVj9qV"; // Replace with your Secret Key
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($verifyResponse);

    // Check if the quantity number is valid if the quantity is "25+"
    if ($quantity == "25+" && (!isset($quantityNumber) || $quantityNumber < 26)) {
        echo "<script>alert('Please enter a number of products that is at least 26.');</script>";
    } elseif ($responseData->success) {
        $to = "shresthasameerman@gmail.com"; // Change to your email
        $subject = "Product Inquiry from $name";
        $message = "Name: $name\nEmail: $email\nMobile: $mobile\nCompany Name: $companyName\nCompany Phone: $companyPhone\nQuantity: $quantity";

        // Append quantity number if "25+" is selected
        if ($quantity == "25+" && $quantityNumber) {
            $message .= "\nNumber of Products: $quantityNumber";
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
     .form-container {
        max-width: 600px;
        margin: 10px auto; /* Decrease the margin above the form */
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: green;
        text-align: center;
        margin-bottom: 5px;
        margin-top: 2px;
    }
    label {
        margin-top: 10px;
        font-weight: bold;
    }
    input[type="text"], 
    input[type="email"], 
    input[type="number"], 
    select, 
    textarea {
        width: calc(100% - 22px);
        padding: 5px;
        margin-bottom: 13px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
        transition: border 0.3s;
    }
    input[type="text"]:focus, 
    input[type="email"]:focus, 
    input[type="number"]:focus, 
    select:focus, 
    textarea:focus {
        border: 1px solid green;
        outline: none;
    }
    .breadcrumb-container {
        background-color: green;
        padding: 15px 0;
        width: 100%;
    }
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        justify-content: flex-start;
        margin-left: 20px;
    }
    .breadcrumb li {
        margin-right: 10px;
        color: white;
    }
    .breadcrumb li:not(:last-child)::after {
        content: ">";
        margin-left: 10px;
    }
    .breadcrumb a {
        text-decoration: none;
        color: white;
    }
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    input[type="submit"] {
        background-color: green;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
        margin-top: 20px; /* Increase the gap above the submit button */
    }
    input[type="submit"]:hover {
        background-color: darkgreen;
        transform: scale(1.05);
    }
    .required {
        color: red;
    }
    textarea {
        resize: vertical;
    }
</style>

    <script>
        function toggleQuantityInput() {
            var quantitySelect = document.getElementById("quantity");
            var quantityNumberDiv = document.getElementById("quantity-number-div");

            if (quantitySelect.value === "25+") {
                quantityNumberDiv.style.display = "block";
            } else {
                quantityNumberDiv.style.display = "none";
            }
        }
    </script>
</head>
<body>

<!-- Green rectangle around breadcrumb -->
<div class="breadcrumb-container">
    <ul class="breadcrumb">
        <li><a href="/home">Home</a></li>
        <li><a href="https://mana.com.np/products/dr-web-anti-virus/dr-web-busniess-edition">Products</a></li>
        <li>Product Inquiry</li>
    </ul>
</div>

<div class="form-container">
    <h1>Dr.Web Enterprise Suite Inquiry Form</h1> <!-- Title in green -->

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
            <option value="Dr.Web Desktop Security Suite">Dr.Web Desktop Security Suite</option>
            <option value="Dr.Web Server Security Suite">Dr.Web Server Security Suite</option>
            <option value="Dr.Web Mail Security Suite">Dr.Web Mail Security Suite</option>
            <option value="Dr.Web Mobile Security Suite">Dr.Web Mobile Security Suite</option>
            <option value="Dr.Web Gateway Security Suite">Dr.Web Gateway Security Suite</option>
        </select><br>

        <label for="quantity">Quantity of Products: <span class="required">*</span></label>
        <select name="quantity" id="quantity" required onchange="toggleQuantityInput()">
            <option value="">Select Quantity</option>
            <option value="1-5">1-5</option>
            <option value="5-10">5-10</option>
            <option value="10-15">10-15</option>
            <option value="15-20">15-20</option>
            <option value="25+">25+</option>
        </select><br>

        <div id="quantity-number-div" style="display:none;">
            <label for="quantity_number">Number of Products:</label>
            <input type="number" name="quantity_number" min="1" placeholder="Enter number of products"><br>
        </div>

        <label for="message">Message:</label><br>
        <textarea name="message" rows="4" placeholder="Enter your message here..."></textarea><br>

        <div class="g-recaptcha" data-sitekey="6LfpiUYqAAAAAA0y04UgGC8zgVHjdUqlwvwSggtE"></div>
        <input type="submit" value="Send Inquiry">
    </form>
</div>

</body>
</html>
