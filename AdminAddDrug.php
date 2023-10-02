<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Drug_No = $_POST["Drug_No"];
    $Drug_Name = $_POST["Drug_Name"];
    $Serial_Number = $_POST["Serial_Number"]; // corrected variable name
    $Quantity = $_POST["Quantity"]; // corrected variable name
    $Man_DATE = $_POST["Man_DATE"];
    $Exp_Date = $_POST["Exp_Date"];

    // Handle image upload
    $imageData = file_get_contents($_FILES["Drug_image"]["tmp_name"]);

    $sql = "INSERT INTO drug (Drug_No, Drug_Name, Serial_Number, Quantity, Man_DATE, Exp_Date, Drug_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind parameters including the image data
    $stmt->bind_param("ississb", $Drug_No, $Drug_Name, $Serial_Number, $Quantity, $Man_DATE, $Exp_Date, $imageData);
    $result = $stmt->execute();

    if ($result === false) {
        die("Error: " . $stmt->error);
    }

    if ($stmt->affected_rows > 0) {
        echo "Drug information inserted successfully.";
    } else {
        echo "Failed to insert drug information.";
    }

    $stmt->close();
}

$conn->close();
?>

