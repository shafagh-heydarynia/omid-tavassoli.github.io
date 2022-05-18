<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>Register</title>

    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/5.1/examples/sign-in/"
    />

    <!-- Bootstrap core CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="register.css" rel="stylesheet" />
  </head>
  <?php
        include_once "config.php";
        connect();
  ?>
  <body class="text-center">
    <main class="form-signin">
      <form action="#" method="post">
        <h1 class="h3 mb-3 fw-normal">Register</h1>
        <?php
              if(setpost('btn-submit'))
              {
                $firstname = trim(post('firstname'));
                $lastname = trim(post('lastname'));
                $phone = trim(post('phone'));
                $password = trim(post('password'));
              }
              else
              {
                $firstname = "";
                $lastname = "";
                $phone = "";
              }
        ?>
        <div class="form-floating">
          <input
            type="text"
            class="form-control"
            id="floatingInput"
            placeholder="name@example.com"
            name="firstname"
            value="<?php print $firstname; ?>"
          />
          <label for="floatingInput">first name</label>
        </div>
        <?php
              if(setpost('btn-submit'))
              {
                $licence1 = false;
                if($firstname == "")
                {
                  print '<div class="alert alert-primary" role="alert">
                                first name can not be empty !
                        </div>';
                }
                else
                {
                  $licence1 = true;
                }
              }
        ?>
        <div class="form-floating">
          <input
            type="text"
            class="form-control"
            id="floatingInput"
            placeholder="name@example.com"
            name="lastname"
            value="<?php print $lastname; ?>"
          />
          <label for="floatingInput">last name</label>
        </div>
        <?php
              if(setpost('btn-submit'))
              {
                $licence2 = false;
                if($lastname == "")
                {
                  print '<div class="alert alert-primary" role="alert">
                                last name can not be empty !
                        </div>';
                }
                else
                {
                  $licence2 = true;
                }
              }
        ?>
        <div class="form-floating">
          <input
            type="text"
            class="form-control"
            id="floatingInput"
            placeholder="name@example.com"
            name="phone"
            value="<?php print $phone; ?>"
          />
          <label for="floatingInput">phone number</label>
        </div>
        <?php
              if(setpost('btn-submit'))
              {
                $licence3 = false;
                if($phone == "")
                {
                  print '<div class="alert alert-primary" role="alert">
                                phone number can not be empty !
                        </div>';
                }
                elseif(!is_numeric($phone))
                {
                  print '<div class="alert alert-primary" role="alert">
                                in phone number can not use alphabet characters !
                        </div>';
                }
                elseif(strlen($phone) !== 11)
                {
                  print '<div class="alert alert-primary" role="alert">
                                phone number is not valid !
                        </div>';
                }
                elseif(mysqli_fetch_assoc(mysqli_query($dblink,"SELECT * FROM users WHERE phone = '$phone'")) == true)
                {
                  print '<div class="alert alert-primary" role="alert">
                                phone number has been taken !
                        </div>';
                }
                else
                {
                  $licence3 = true;
                }
              }
        ?>
        <div class="form-floating">
          <input
            type="password"
            class="form-control"
            id="floatingPassword"
            placeholder="Password"
            name="password"
          />
          <label for="floatingPassword">Password</label>
        </div>
        <?php
              if(setpost('btn-submit'))
              {
                $licence4 = false;
                $salt = "@&bpnt";
                if($password == "")
                {
                  print '<div class="alert alert-primary" role="alert">
                                password can not be empty !
                        </div>';
                }
                elseif(strlen($password) > 8)
                {
                  print '<div class="alert alert-primary" role="alert">
                                password can not be more than 8 charakters !
                        </div>';
                }
                else
                {
                  $password = sha1($password.$salt);
                  $licence4 = true;
                }
              }
        ?>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="btn-submit">
          register
        </button>
        <?php      
            if(setpost('btn-submit'))
            {  
              if($licence1 && $licence2 && $licence3 && $licence4)
              {
                date_default_timezone_set("Asia/Tehran");
                $date = date("Y-m-d H:i:s");
                mysqli_query($dblink,"INSERT INTO users (firstname,lastname,phone,password,register_date_time) VALUES ('$firstname','$lastname','$phone','$password','$date')");
                if(mysqli_insert_id($dblink) > 0)
                {
                  
                  print '<div class="alert alert-primary" role="alert">
                            register successful!
                            <br>
                            <a href="login.php">Log in</a>
                        </div>';
                }
                else
                {
                  print '<div class="alert alert-primary" role="alert">
                            register failed!
                        </div>';
                }
              }
            }
        ?>
        <p class="mt-5 mb-3 text-muted">alredy have an account <a href="login.php">Log in</a></p>
      </form>
    </main>
  <?php
        disconnect();
  ?>
  </body>
</html>