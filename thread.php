<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Welcome-to-iDiscuss</title>

    <style>
        #ques {
            min-height: 753px;
        }
    </style>
</head>

<body>

    <?php include 'partials/_dbconnect.php' ?>
    <?php include 'partials/_header.php' ?>
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `thread` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        $sql2 = "SELECT user_email FROM `users` WHERE sno= '$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) 
                VALUES ('$comment', '$id', '$sno', current_timestamp());";

        $result = mysqli_query($conn, $sql);
        $showAlert = true;
    }
    if($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your comment is successfully inserted
           
         </div>';
    }
    ?>
    
    <div class="container my-4" id="ques">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>Don't start a topic in wrong category. Don't cross-post the same thing in multiple topics. Don't post no-content replies. Don't divert a topic by changing it midstream.</p>
            <p>Posted By: <em><?php echo $posted_by;?></em></p>
        </div>
        <?php
        if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])==true){
            echo '
             <h2>Post a Comment</h2>
        <form class="my-4" action="'.$_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <label for="comment">Add Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'. $_SESSION["sno"].' "> 
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
            ';
        }
        else {
            echo '<h2>Post a Comment</h2>
            <div class="container">
            <p class="lead">You are not able to post a comment. Please login to post any comment.</p>
            </div>';
        }
        ?>
        <h2>Comments</h2>
        <?php
        $sql = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];
            $noResult = false;

            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '
        <div class="container py-2">
            <div class="media">
                <img class="mr-3" src="img/userdefault.webp" width="64" alt="Generic placeholder image">
                <div class="media-body">
                    <p class="font-weight-bold my-0">'. $row2['user_email'] .' at '. $comment_time. '</p> '. $content . '
                </div>
            </div>  
        </div>';
        }
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid my-3">
        <div class="container">
            <h1 class="display-4">No Comments Found</h1>
            <p class="lead">Be the first to write a comment</p>
        </div>
    </div>';
        }
        ?>
    </div>

    <?php include 'partials/_footer.php'; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>