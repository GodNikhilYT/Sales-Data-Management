<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "erp_portal";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $customer_name = $_POST['customer_name'];
    $seller_name = $_POST['seller_name'];
    $product_quantity = $_POST['product_quantity'];
    $sale_date = $_POST['sell_date'];
    $product_type = $_POST['product_type'];
    $email = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $product_details = $_POST['product_details'];
    $product_price = $_POST['product_price'];
    $terms_agreed = isset($_POST['terms']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO product_sales_details 
        (customer_name, seller_name, product_quantity, sale_date, product_type, email_address, phone_number, product_details, product_price, agreed_terms) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssisisssdi", $customer_name, $seller_name, $product_quantity, $sale_date, $product_type, $email, $phone_number, $product_details, $product_price, $terms_agreed);
    
    if ($stmt->execute()) {
        echo "<p>Product details submitted successfully!</p>";

        // Send confirmation email to user
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jaatnikhil777@gmail.com'; // Your email
            $mail->Password = 'ixhzgsmmtduhmwqv';        // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email to User
            $mail->setFrom('jaatnikhil777@gmail.com', 'Nikhil Support');
            $mail->addAddress($email); // User email
            $mail->isHTML(true);
            $mail->Subject = "Thank you for contacting us!";
            $mail->Body = "
                <p>Hi <strong>$customer_name</strong>,</p>
                <p>Thank you for your product purchase request &#128578;</p>
                <p><strong>Product Details:</strong></p>
                <ul>
                    <li><b>Seller Name:</b> $seller_name</li>
                    <li><b>Product Quantity:</b> $product_quantity</li>
                    <li><b>Product Type:</b> $product_type</li>
                    <li><b>Product Details:</b> $product_details</li>
                    <li><b>Product Price:</b> ₹ $product_price</li>
                    <li><b>Date:</b> $sale_date</li>
                </ul>
                <p>Best regards,<br>Nikhil Support Team</p>";

            $mail->send();

            echo "<script>alert('Message was sent successfully!'); document.location.href = 'index2.php';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
