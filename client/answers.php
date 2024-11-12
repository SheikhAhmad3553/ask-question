<div class="container">
    <div class="offset-sm-1">
    <h3>Answer:</h3>

    <?php 
    $query = "SELECT * FROM answer WHERE question_id = $qid";
    $result = $conn->query($query);

    foreach ($result as $row) {
        $answer = $row['answer']; // Assign the answer to $answer
        echo "<div>
        <li class='answer-wrapper'>$answer</li>
        </div>";
    }
    ?>
</div>
</div>