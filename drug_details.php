<!DOCTYPE html>
<html>
<head>
    <title>Drug Details</title>
</head>
<body>
    <h1>Drug Details</h1>

    <?php
    require_once("connect.php"); // Assuming "connect.php" contains the database connection code

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "drugdispensingtools");

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the drug ID from the URL
    if (isset($_GET['id'])) {
        $drug_id = $_GET['id'];

        // Retrieve drug details from the database
        $query = "SELECT * FROM drug WHERE Drug_No = $drug_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?>
            <h2><?php echo $row['Drug_Name']; ?></h2>
            <p>Serial Number: <?php echo $row['Serial_Number']; ?></p>
            <p>Quantity: <?php echo $row['Quantity']; ?></p>
            <p>Manufacture Date: <?php echo date("Y-m-d", strtotime($row['Man_DATE'])); ?></p>
            <p>Expiry Date: <?php echo date("Y-m-d", strtotime($row['Exp_Date'])); ?></p>
            <img src="images/<?php echo $row['Drug_image']; ?>" alt="<?php echo $row['Drug_Name']; ?>" width="300">
            
            <!-- Add a link to go back to the search page -->
            <p><a href="ViewPharmaInventory.php">Back to Search</a></p>
    <?php
        } else {
            echo "Drug not found.";
        }
    } else {
        echo "Invalid request.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
