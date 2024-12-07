<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="logo-pin.png" type="image\x-icon">
    <title>AccessMart</title>
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
                        <li><a href="#footer">Help</a></li>
                    </ul>
                </div>
            </div>
        </section>
    </header>

    <main>
        <section class="sect2">
            <div class="form">
                <ul class="tab-group">
                    <li class="tab active"><a href="#signup">Sign Up</a></li>
                    <li class="tab"><a href="#login">Log In</a></li>
                </ul>

                <div class="tab-content">
                    <div id="signup">
                        <h1>Sign Up for New User</h1>

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
                            $servername = "localhost:3307";
                            $username = "root";
                            $password = "";
                            $dbname = "erp_portal";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Get form data
                            $first_name = $_POST['first_name'];
                            $last_name = $_POST['last_name'];
                            $email = $_POST['email'];
                            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                            // Insert into database
                            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

                            if ($stmt->execute()) {
                                echo "<p>Sign-up successful!</p>";
                            } else {
                                echo "<p>Error: " . $stmt->error . "</p>";
                            }
                            $stmt->close();
                            $conn->close();
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="top-row">
                                <div class="field-wrap">
                                    <label>First Name<span class="req">*</span></label>
                                    <input type="text" name="first_name" required autocomplete="on" />
                                </div>

                                <div class="field-wrap">
                                    <label>Last Name<span class="req">*</span></label>
                                    <input type="text" name="last_name" required autocomplete="on" />
                                </div>
                            </div>

                            <div class="field-wrap">
                                <label>Email Address<span class="req">*</span></label>
                                <input type="email" name="email" required autocomplete="on" />
                            </div>

                            <div class="field-wrap">
                                <label>Set A Password<span class="req">*</span></label>
                                <input type="password" name="password" required autocomplete="off" />
                            </div>

                            <button type="submit" name="signup" class="button button-block">Get Started</button>
                        </form>
                    </div>

                    <div id="login">
    <h1>Welcome Back</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "erp_portal";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                // Redirect to index2.php upon successful login
                header("Location: index2.php");
                exit();
            } else {
                echo "<p>Invalid credentials. Please try again.</p>";
            }
        } else {
            echo "<p>No account found with that email.</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="" method="POST">
        <div class="field-wrap">
            <label>Email Address<span class="req">*</span></label>
            <input type="email" name="email" required>
        </div>

        <div class="field-wrap">
            <label>Password<span class="req">*</span></label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" name="login" class="button button-block">Log In</button>
    </form>
</div>

                </div>
            </div>
            <script src="index.js"></script>
        </section>
    </main>

    <br><br>
    <footer class="footer" id="footer">
        <div class="footer-container">
            <div class="footer-left">
                <h2>Let's Go</h2>
                <p>
                    Welcome to Mart Controller System, your go-to solution for efficient inventory and sales management.
                    Track, analyze, and control your mart operations in real-time.
                </p>
                <button class="btn"><a href="#">Let's Go Started</a></button>
            </div>
            <div class="footer-right">
                <p><b>Email:</b> <a href="programmingcs50@gmail.com">programmingcs50@gmail.com</a></p>
                <p><b>Phone:</b> <a href="tel:+917302347468">(+91) 7302347468</a></p>
                <p>
                    <b>Address:</b> Kashipur, Uttarakhand <br>
                    <b>District:</b> Udham Singh Nagar <br>
                    <b>PIN:</b> 244713
                </p>
                <p> <b>&copy; Nikhil Choudhary</b> 2024. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
