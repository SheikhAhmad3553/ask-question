<div>
    <h1 class="heading" >Categories</h1>
    <?php
    include('./client/common/db.php');
    $query = "SELECT * FROM category";
    $result = $conn->query($query);
    foreach ($result as $row) {
        $name = $row['name'];
        $id = $row['id'];
        echo "<div class='row question-list' >
   <h2>  <a href='?c-id=$id'>$name</a></h2>
   
   </div>";
    }
    ?>
</div>