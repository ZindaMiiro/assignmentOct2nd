<!DOCTYPE html>
<html>
<head>
    <title>Pharma Inventory</title>
    <style>
        .drug-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .drug-card {
            width: 30%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .drug-card img {
            max-width: 100%;
            height: auto;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to perform drug search
            function searchDrug() {
                var searchQuery = $("#search").val();
                $.ajax({
                    url: "search.php",
                    type: "GET",
                    data: { search: searchQuery },
                    success: function(response) {
                        $("#drugContainer").html(response);
                    }
                });
            }

            // Perform search on form submission
            $("form").submit(function(e) {
                e.preventDefault();
                searchDrug();
            });

            // Perform search on input change
            $("#search").on("input", function() {
                searchDrug();
            });
        });
    </script>
</head>
<body>
    <h1>Pharma Inventory</h1>

    <h2>Search Drug</h2>
    <form method="GET" action="">
        <label for="search">Search by Drug Name:</label>
        <input type="text" name="search" id="search" placeholder="Enter drug name">
        <input type="submit" value="Search">
    </form>
    <p>Enter the drug name in the search bar above to dynamically filter the drug information.</p>

    <div id="drugContainer">
        <?php
        require_once("connect.php"); // Assuming "connect.php" contains the database connection code

        // Select the database
        if (!mysqli_select_db($conn, "drugdispensingtools")) {
            die("Error: " . mysqli_error($conn));
        }

        $sql = "SELECT * FROM drug";
        $results = $conn->query($sql);

        if ($results === false) {
            die("Error: " . $conn->error);
        }

        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
        ?>
                <div class="drug-card">
                    <img src="images/<?php echo $row['Drug_image']; ?>" alt="<?php echo $row['Drug_Name']; ?>">
                    <br>
                    <a href="drug_details.php?id=<?php echo $row['Drug_No']; ?>">View Details</a>
                </div>
        <?php
            }
        } else {
        ?>
            <p>No data found in the Drug table.</p>
        <?php } ?>
    </div>
</body>
</html>
