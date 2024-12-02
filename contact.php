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
    /* Style inputs with type="text", select elements and textareas */
    input[type=text],
    select,
    textarea {
      width: 100%;
      /* Full width */
      padding: 12px;
      /* Some padding */
      border: 1px solid #ccc;
      /* Gray border */
      border-radius: 4px;
      /* Rounded borders */
      box-sizing: border-box;
      /* Make sure that padding and width stays in place */
      margin-top: 6px;
      /* Add a top margin */
      margin-bottom: 16px;
      /* Bottom margin */
      resize: vertical
        /* Allow the user to vertically resize the textarea (not horizontally) */
    }

    /* Style the submit button with a specific background color etc */
    input[type=submit] {
      background-color: #04AA6D;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* When moving the mouse over the submit button, add a darker green color */
    input[type=submit]:hover {
      background-color: #45a049;
    }

    /* Add a background color and some padding around the form */
    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }
  </style>
</head>

<body>
  <?php include 'partials/_dbconnect.php' ?>
  <?php include 'partials/_header.php' ?>
  <?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $subject = $_POST['subject'];

    $contact = false;
    if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])==true){
      $contact = true;
      if(isset($fname) && ($lname) && ($email) && ($phone) && ($city) && ($state) && ($zip) && ($subject)){
        $sql = "INSERT INTO `contact_us` (`fname`, `lname`, `email`, `phone_no`, `city`, `state`, `zip`, 
                            `subject`, `date`)
                VALUES ('$fname', '$lname', '$email', '$phone ', '$city', 
                        '$state', '$zip', '$subject', current_timestamp())";
        
        $result = mysqli_query($conn, $sql);
  
        if($result){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Thank You!</strong> Your information submitted successfully. We will contact you soon.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }
      }
    }
    else {
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Sorry!</strong> Please Login or Signup to contact with us.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
  ?>
  
  <div class="container py-5 my-5">
    <h1 class="text-center" style="font-size: 60px">Contact Us</h1>
    <h4 class="lead mb-5 text-center">Please fill form in a decent manner</h4>
    <hr class="mb-5" width="100%;" color="grey" size="5">

    <form action="/phpt/forum/contact.php" method="post">

      <label for="fname">First Name</label>
      <input type="text" id="fname" name="firstname" placeholder="Your name..">

      <label for="lname">Last Name</label>
      <input type="text" id="lname" name="lastname" placeholder="Your last name..">

      <div class="row my-3">
        <div class="col">
          <label for="email">Email address</label>
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email..">
        </div>
        <div class="col">
          <label for="phone">Phone No.:</label>
          <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number..">
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city" id="city" placeholder="City.." required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="state">State</label>
          <input type="text" class="form-control" name="state" id="state" placeholder="State.." required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="zip">Zip</label>
          <input type="number" class="form-control" name="zip" id="zip" placeholder="Zip.." required>
        </div>
      </div>

      <label for="subject">Subject</label>
      <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
      <div class="d-flex justify-content-center">
      <button class="btn btn-success btn-lg btn-block" style="width: 20%;" type="submit" value="Submit">Contact</button> 
      </div>

    </form>
  </div>
  <?php include 'partials/_footer.php'; ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>