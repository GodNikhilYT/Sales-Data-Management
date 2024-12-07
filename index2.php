<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo-pin.png" type="image\x-icon">
    <link rel="stylesheet" href="index2.css">
    <title>SellEase</title>
</head>

<body>
    <header class="fixed-header">
        <section class="sect1">
            <div class="banner">
                <div class="banner-01">
                    <img src="3jndsjd.png" alt="icon">
                </div>
                <div class="banner-02">
                    <ul>
                        <li id="user-name"><a href="#">Nikhil</a></li>
                        <li><a href="index.php">LogOut</a></li>
                    </ul>
                </div>
            </div>
        </section>
    </header>

    <main>
        <section>
            <div class="wrapper">
                <div class="title">
                   Add Selling Product Details
                </div>
                <?php
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
    $sale_date = $_POST['sell_date']; // Corrected here
    $product_type = $_POST['product_type'];
if (empty($product_type)) {
    die("<p>Please select a product type.</p>");
}

    $phone_number = $_POST['phone_number'];
    $product_details = $_POST['product_details'];
    $product_price = $_POST['product_price'];
    $terms_agreed = isset($_POST['terms']) ? 1 : 0;
    $email = $_POST['email_address']; // Correctly fetched here

    $stmt = $conn->prepare("INSERT INTO product_sales_details 
    (customer_name, seller_name, product_quantity, sale_date, product_type, email_address, phone_number, product_details, product_price, agreed_terms) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssissssddi", $customer_name, $seller_name, $product_quantity, $sale_date, $product_type, $email, $phone_number, $product_details, $product_price, $terms_agreed);
    if (!$stmt->execute()) {
        echo "<p>Error: " . $stmt->error . "</p>";
        error_log("SQL Error: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}
?>

                 <form action="mail.php" method="POST">
                    <div class="form">
                        <div class="inputfield">
                            <label>Customer Name</label>
                            <input type="text" class="input" name="customer_name" required>
                        </div>
                        <div class="inputfield">
                            <label>Seller Name</label>
                            <input type="text" class="input" name="seller_name">
                        </div>
                        <div class="inputfield">
                            <label>Product Quantity</label>
                            <input type="number" class="input" name="product_quantity" required>
                        </div>
                        <div class="inputfield">
                            <label>Date</label>
                            <input type="date" class="input" name="sell_date" required>
                        </div>
                        <div class="inputfield">
                            <label>Select Product Type</label>
                            <div class="custom_select">
                            <select name="product_type" required>
                                    <option value="">Select</option>
                                    <option value="Animal & Pet Supplies">Animal & Pet Supplies</option> 
                                    <option value="Apparel & Accessories">Apparel & Accessories</option>
                                    <option value="Arts & Entertainment">Arts & Entertainment</option>
                                    <option value="Baby & Toddler">Baby & Toddler</option>
                                    <option value="Business & Industrial">Business & Industrial</option>
                                    <option value="Cameras & Optics">Cameras & Optics</option>
                                    <option value="Electronic">Electronic</option>
                                    <option value="Food, Beverages & Tobacco">Food, Beverages & Tobacco</option>
                                    <option value="Furniture">Furniture</option>   
                                </select>
                            </div>
                        </div>
                        <div class="inputfield">
                            <label>Email Address</label>
                            <input type="email" class="input" name="email_address" required>
                        </div>
                        <div class="inputfield">
                            <label>Phone Number</label>
                            <input type="text" class="input" name="phone_number" required>
                        </div>
                        <div class="inputfield">
                            <label>Product Details</label>
                            <textarea class="textarea" name="product_details" required></textarea>
                        </div>
                        <div class="inputfield">
                            <label>Product Price</label>
                            <input type="text" class="input" name="product_price" required>
                        </div>
                        <div class="inputfield terms">
                            <label class="check">
                                <input type="checkbox" name="terms" required>
                                <span class="checkmark"></span>
                            </label>
                            <p id="agree">Agreed to terms and conditions</p>
                        </div>
                        <div class="inputfield">
                            <input type="submit" value="Submit" class="btn">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

</body>
</html>
