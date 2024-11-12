<div class="container">
    <div class="row">
        <div class="col-8">
            <h1 class="heading">Question</h1>
            <?php
    include('./client/common/db.php');
    $query = "SELECT * FROM question WHERE id = $qid";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $cid = $row['category_id'];

    echo "<h3 class='margin-bottom-15 question-title'>Question: " . $row['title'] . "</h3>
          <p>" . $row['description'] . "</p>";

    include('./client/answers.php');
?>

<form action="./server/requests.php" method="post">
    <input type="hidden" name="question_id" value="<?php echo $qid; ?>">
    <textarea name="answer" class="form-control margin-bottom-15" placeholder="Your Answer..."></textarea>
    <button class="btn btn-primary margin-bottom-15">Write Your Answer</button>
</form>
</div>

<div class="col-4">
    <?php
    $categoryQuery = "SELECT name FROM category WHERE id = $cid";
    $categoryresult = $conn->query($categoryQuery);  // Use correct variable
    $categoryRow = $categoryresult->fetch_assoc();  // Fetch the result
    echo "<h3>".$categoryRow['name']."</h3>";

    $query = "SELECT * FROM question WHERE category_id = $cid and id!=$qid";
    $result = $conn->query($query);

    foreach ($result as $row) {
        $id = $row['id'];
        $title = $row['title'];
        echo "<div class='question-list'>
                <h2><a href='question-details.php?id=$id'>$title</a></h2>
              </div>";
    }
    ?>
</div>

    </div>
</div>