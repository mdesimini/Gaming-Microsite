<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Matt Desimini Microsite</title>
    <meta name="description" content="Matt Desimini's Microsite for the Jr. Web Developer Position at Octagon.">
    <meta name="author" content="Matt Desimini">
    <link rel="icon" href="../images/md-icon.gif" type="image/gif" sizes="16x16">
    <!-- Fonts from Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin">

    <link rel="stylesheet" href="../css/hamburgers.css">
    <link rel="stylesheet" href="../css/spectre.css">
    <link rel="stylesheet" href="../css/main.css">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    $firstname = $lastname = $email = $zipcode = $state = "";
    $firstnameErr = $lastnameErr = $emailErr = $zipcodeErr = $stateErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      if (empty($_POST["firstname"])) {
        $firstnameErr = "First Name is required";
      } else {
        $firstname = validate_form($_POST["firstname"]);

        if (!preg_match("/[a-zA-Z]+/",$firstname)) {
          $firstnameErr = "Characters Only"; 
        }
      }

      if (empty($_POST["lastname"])) {
        $lastnameErr = "Last Name is required";
      } else {
        $lastname = validate_form($_POST["lastname"]);

        if (!preg_match("/[a-zA-Z-']+/",$lastname)) {
          $lastnameErr = "Characters, Hyphens, Apostrophes only"; 
        }
      }    

      if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } else {
        $email = validate_form($_POST["email"]);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format"; 
        }
      }

      if (empty($_POST["zipcode"])) {
        $zipcodeErr = "Zip Code is required";
      } else {
        $zipcode = validate_form($_POST["zipcode"]);

        if (!preg_match("/[0-9]{5}/",$zipcode)) {
          $zipcodeErr = "5 numbers"; 
        }
      }    

      if (empty($_POST["state"])) {
        $stateErr = "State is required";
      } else {
        $state = validate_form($_POST["state"]);

        if (!preg_match("/[a-zA-Z]{2}+/",$state)) {
          $stateErr = "Select a valid state"; 
        }
      }        

    }

    function validate_form($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    
    if($firstnameErr == "" && $lastnameErr == "" && $emailErr == "" && $zipcodeErr == "" && $stateErr == "") {
        
        if(isset($_POST['submit'])) {
        
        include('../include/db.php');  
        
        $statement = $link->prepare("INSERT INTO contact_form(firstname, lastname, email, zipcode, state)
            VALUES(:fname, :lname, :email, :zip, :state)");
        $statement->execute(array(
            "fname" => "$firstname",
            "lname" => "$lastname",
            "email" => "$email",
            "zip" => "$zipcode",
            "state" => "$state"
        ));      
            
        //header('Location: index.php?status=1');
        echo("<script>location.href = 'index.php?status=1';</script>");            
        exit;            
        
        }
    }
    
    else {
        
        //header('Location: index.php?status=0');
        echo("<script>location.href = 'index.php?status=0';</script>");            
        exit;
        
    }
    ?>      
    <div class="container">
    <header class="navbar">
      <section class="navbar-section">
            <a href="../index.html"><img id="logo" src="../images/logo.png" alt="logo"></a>
      </section>
      <section class="navbar-section">
        <a href="../index.html#news" id="scrollToNews" class="btn btn-link hide-xs">News</a>
        <a href="../index.html#vid" id="scrollToEsports" class="btn btn-link hide-xs">eSports</a>
        <a href="../contact/" id="contact" class="btn btn-link hide-xs">Contact Us</a>
        <button class="hamburger hamburger--collapse show-xs" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>            
      </section>
    </header>
        <div id="mobile-nav" class="mobile-nav-container">
            <nav>
                <a href="../index.html#news" id="scrollToNewsMobile">News</a>                     
                <a href="../index.html#vid" id="scrollToEsportsMobile">eSports</a> 
                <a href="../contact/">Contact Us</a> 
            </nav>        
        </div>        
    </div>
    
    <div class="contact">
        <div class="columns">
                  <div class="column column col-6 col-mx-auto col-md-12 col-xs-12">
                      <?php
                         if(isset($_GET['status'])){
                             $status = $_GET['status'];
                             if($status == 1){
                                echo "<h3 style='text-align:center; color: green;'>Success!</h3>";
                             }else if($status == 0){
                                echo "<h3 style='text-align:center; color: red;'>Unable to send message</h3>";
                             }
                         }                      
                      ?>
                    <h1>Contact Us</h1>
                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                      <div class="form-group">
                        <div class="col-3">
                          <label class="form-label" for="firstname">First Name</label>
                        </div>
                        <div class="col-9">
                          <input class="form-input" type="text" id="firstname" name="firstname" pattern="[a-zA-Z]+" placeholder="First Name" required>
                          <span class="error"><?php echo $firstnameErr;?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-3">
                          <label class="form-label" for="lastname">Last Name</label>
                        </div>
                        <div class="col-9">
                          <input class="form-input" type="text" id="lastname" name="lastname" pattern="[a-zA-Z-']+" placeholder="Last Name" required>
                          <span class="error"><?php echo $lastnameErr;?></span>
                        </div>
                      </div>                        
                      <div class="form-group">
                        <div class="col-3">
                          <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="col-9">
                          <input class="form-input" type="email" id="email" name="email" placeholder="Email" required>
                          <span class="error"><?php echo $emailErr;?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-3 col-xl-3">
                          <label class="form-label" for="zipcode">Zip Code</label>
                        </div>
                        <div class="col-2 col-xl-4">
                          <input class="form-input" type="text" id="zipcode" pattern="[0-9]{5}" minlength="5" maxlength="5" name="zipcode" placeholder="Zip Code" required>
                          <span class="error"><?php echo $zipcodeErr;?></span>
                        </div>
                        <div class="col-7 col-xl-5"></div>                          
                      </div>                        
                      <div class="form-group">
                        <div class="col-3 col-xl-3">
                          <label class="form-label" for="state">State</label>
                        </div>     
                        <div class="col-2 col-xl-4">
                          <select id="state" name="state" class="form-select" required>
                              <option value="">-</option>
                              <option value="AK">AK</option>
                              <option value="AL">AL</option>
                              <option value="AR">AR</option>
                              <option value="AZ">AZ</option>
                              <option value="CA">CA</option>
                              <option value="CO">CO</option>
                              <option value="CT">CT</option>
                              <option value="DC">DC</option>
                              <option value="DE">DE</option>
                              <option value="FL">FL</option>
                              <option value="GA">GA</option>
                              <option value="HI">HI</option>
                              <option value="IA">IA</option>
                              <option value="ID">ID</option>
                              <option value="IL">IL</option>
                              <option value="IN">IN</option>
                              <option value="KS">KS</option>
                              <option value="KY">KY</option>
                              <option value="LA">LA</option>
                              <option value="MA">MA</option>
                              <option value="MD">MD</option>
                              <option value="ME">ME</option>
                              <option value="MI">MI</option>
                              <option value="MN">MN</option>
                              <option value="MO">MO</option>
                              <option value="MS">MS</option>
                              <option value="MT">MT</option>
                              <option value="NC">NC</option>
                              <option value="ND">ND</option>
                              <option value="NE">NE</option>
                              <option value="NH">NH</option>
                              <option value="NJ">NJ</option>
                              <option value="NM">NM</option>
                              <option value="NV">NV</option>
                              <option value="NY">NY</option>
                              <option value="OH">OH</option>
                              <option value="OK">OK</option>
                              <option value="OR">OR</option>
                              <option value="PA">PA</option>
                              <option value="RI">RI</option>
                              <option value="SC">SC</option>
                              <option value="SD">SD</option>
                              <option value="TN">TN</option>
                              <option value="TX">TX</option>
                              <option value="UT">UT</option>
                              <option value="VA">VA</option>
                              <option value="VT">VT</option>
                              <option value="WA">WA</option>
                              <option value="WI">WI</option>
                              <option value="WV">WV</option>
                              <option value="WY">WY</option>
                          </select> 
                          <span class="error"><?php echo $stateErr;?></span>    
                         <div class="col-7 col-xl-5"></div>                                                      
                        </div>  
                      </div>   
                        <div class="form-group">
                            <div class="column col-4 col-mr-auto" style="width: 100%; text-align: center; padding: 10px;">
                                <button class="btn" name="submit" type="submit" value="Submit">Submit</button>                          
                            </div>
                        </div>                        
                    </form>
                  </div>
        </div>                
    </div>
    
    <div class="container">
        <div class="columns columns-flex" id="standings">
            <div class="column col-4 col-mx-auto col-md-12 col-xs-12 hide-sm">
            <?php
            
            include('../include/db.php');
        
            $query = "SELECT id, firstname, lastname, email, zipcode, state FROM contact_form";

            $stmt = $link->prepare( $query );
            $stmt->execute();

            //return $stmt;       
            
            echo "<h4 style='text-align:left; margin-top: 20px;' >Database Submissions (Proof)</h4>";
            echo "<table class='table table-striped table-hover table-scroll' style='margin-bottom: 20px;'>";
                echo "<thead>";
                   echo "<tr>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Zip Code</th>";
                    echo "<th>State</th>";
                   echo "</tr>";
                echo "</thead>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    extract($row);

                    echo "<tr>";
                        echo "<td>".$row['firstname']."</td>";
                        echo "<td>".$row['lastname']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['zipcode']."</td>";
                        echo "<td>".$row['state']."</td>";
                    echo "</tr>";

                }

            echo "</table>";        
        
        ?>
        </div>
        </div>
    </div>
        
    <footer class="container">
      <div class="columns">
        <div class="column col-6 col-xs-12">
            <img id="small-logo" width="100" src="../images/logo-small.png" alt="small-logo">
        </div>
        <div class="column col-6 col-xs-12">
          <ul>
            <li><a href="../index.html#news" id="scrollToNews2">News</a></li>  
            <li><a href="../index.html#vid" id="scrollToEsports2">eSports</a></li>  
            <li><a href="../contact/">Contact</a></li>  
          </ul>
        </div>
      </div>    
        <hr/>        
        <p>Matt Desimini 2018</p>
    </footer>
    
    <script src="../js/scrollTo.js"></script>
    <script src="../js/mobile-menu.js"></script>
</body>

</html>