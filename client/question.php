<div class="container">
    <div class="row">
        <div class="col-8">
            <h1 class="heading">Question</h1>
            <?php
            include('./client/common/db.php');

            // Initialize the variables for category ID and user ID
            $cid = isset($_GET['c-id']) ? (int) $_GET['c-id'] : null;  // Category ID (if provided)
            $uid = isset($_GET['u-id']) ? (int) $_GET['u-id'] : null;  // User ID (if provided)
            $latest = isset($_GET['latest']) ? true : false; // Check if 'latest' is set in URL

            // Build the query based on the presence of c-id or u-id or latest
            if ($cid) {
                // If category ID is set, filter by category
                $query = "SELECT * FROM question WHERE category_id = $cid ORDER BY created_at DESC";
            } else if ($uid) {
                // If user ID is set, filter by user
                $query = "SELECT * FROM question WHERE user_id = $uid ORDER BY created_at DESC";
            } else if ($latest) {
                // If 'latest' parameter is set, order by created_at descending (latest questions first)
                $query = "SELECT * FROM question ORDER BY created_at DESC";
            } else {
                // If neither is set, fetch all questions
                $query = "SELECT * FROM question ORDER BY created_at DESC";
            }

            // Execute the query
            $result = $conn->query($query);

            // Check if the query returned results
            if ($result && $result->num_rows > 0) {
                // Loop through and display questions
                foreach ($result as $row) {
                    $title = $row['title'];
                    $id = $row['id'];
                    echo "<div class='row question-list'>
                            <h2><a href='?q-id=$id'>$title</a></h2>
                          </div>";
                }
            } else {
                echo "<p>No questions found.</p>";
            }
            ?>
        </div>

        <div class="col-4">
            <?php include('./client/categorylist.php'); ?>
        </div>
    </div>
</div>
