<?php

require 'secrets.php';

session_start(); // Start the session

$mysqli = new mysqli("localhost", DB_UID, DB_PWD, "example_db");

if ($mysqli->connect_errno) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

echo "Connected successfully. Host info: " . $mysqli->host_info;

// Initialize the "show_completed" session item if not set
if (!isset($_SESSION['show_completed'])) {
    $_SESSION['show_completed'] = false;
}

// Handle form submissions (Add, mark as complete, show completed tasks)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        // Mark a task as complete
        $id = $_POST['id'];
        $sql = "UPDATE todos SET completed = 1 WHERE id = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            echo "Task marked as complete.";
        } else {
            echo "ERROR: Could not prepare query: $sql. " . $mysqli->error;
        }

    } else {
        // Add a new task
        $new_title = $_POST['title'];
        $sql = "INSERT INTO todos(title, completed) VALUES (?, 0)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $new_title);
            $stmt->execute();
            echo "Task added successfully.";
        } else {
            echo "ERROR: Could not prepare query: $sql. " . $mysqli->error;
        }
    }
}

// Handle "Show/Hide Completed" button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show_completed'])) {
    // Toggle the session variable to indicate whether to show completed tasks
    $_SESSION['show_completed'] = !$_SESSION['show_completed'];
    // Reload the page
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit;
}

?>

<!-- HTML section for displaying to-do list -->
<h2>To-do list items</h2>

<!-- Form to toggle showing completed tasks -->
<form method="post" action="todo.php">
    <button type="submit" name="show_completed" value="toggle">
        <?php echo ($_SESSION['show_completed'] ? "Hide" : "Show"); ?> completed
    </button>
</form>

<table>
    <tbody>
        <tr>
            <th>Item</th>
            <th>Added on</th>
            <th>Complete</th>
        </tr>

        <?php

        // Retrieve tasks based on whether to show completed tasks or not
        $sql = ($_SESSION['show_completed'] ? "SELECT id, title, created, completed FROM todos" : "SELECT id, title, created, completed FROM todos WHERE completed = 0");

        if ($result = $mysqli->query($sql)) {

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . ($row['completed'] ? '<del>' . $row['title'] . '</del>' : $row['title']) . "</td>";
                    echo "<td>" . $row['created'] . "</td>";
                    echo '<td>';
                    if (!$row['completed']) {
                        echo '<form method="post" action="todo.php">
                            <input type="hidden" name="id" value="'.$row['id'].'">
                            <button type="submit">Done</button>
                            </form>';
                    }
                    echo '</td>';
                    echo "</tr>";
                }

                echo "</table>";
                $result->free();
            } else {
                echo "No records matching your query were found.";
            }

        } else {
            echo "ERROR: Could not execute $sql. " . $mysqli->error;
        }

        ?>

    </tbody>
</table>

<!-- Form for adding new tasks -->
<form method="post" action="todo.php">
    <input type="text" name="title" placeholder="To-do item">
    <button type="submit">Submit</button>
</form>
