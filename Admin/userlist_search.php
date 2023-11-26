<?php
include '../Users/config.php';

// Fetch user data from the database based on the search query
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($link, $_GET['search']);
    $sql = "SELECT `id`, `date_created`, `first_name`, `last_name`, `username` FROM `user` WHERE `first_name` LIKE '%$searchQuery%' OR `last_name` LIKE '%$searchQuery%' OR `username` LIKE '%$searchQuery%'";
    $result = mysqli_query($link, $sql);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Output the search results
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["date_created"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>";
        echo "<div class='dropdown'>";
        echo "<select style='background: #CFE8FF; border-radius: 5px; padding: 5px; color: #000;' name='action' onchange='deleteUser(" . $row["id"] . ")'>Select Action<i class='bx bxs-down-arrow'></i>";
        echo "<option value=''>Select Action</option>";
        echo "<option value='delete'>Delete</option>";
        echo "</select>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    // Handle the case where there is no search query
    echo "<tr><td colspan='5'>No search query provided</td></tr>";
}

// Close connection
mysqli_close($link);
?>
