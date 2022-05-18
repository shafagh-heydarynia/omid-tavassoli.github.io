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
    <title>Log in</title>

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
        <h1 class="h3 mb-3 fw-normal">Log in</h1>
        <?php
              if(setpost('btn-submit'))
              {
                $phone = trim(post('phone'));
                $password = trim(post('password'));
              }
              else
              {
                $phone = "";
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
                $licence1 = false;
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
                    $licence1 = true;
                }
                else
                {
                    print '<div class="alert alert-primary" role="alert">
                                  phone number is not exist !
                          </div>';
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
                $licence2 = false;
                $salt = "@&bpnt";
                $passwordsalty = sha1($password.$salt);
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
                elseif(mysqli_fetch_assoc(mysqli_query($dblink,"SELECT * FROM users WHERE password = '$passwordsalty'")))
                {
                  $licence2 = true;
                  print "succesful";
                }
                else
                {
                    print '<div class="alert alert-primary" role="alert">
                                  password is incorrect !
                          </div>';
                }
              }
        ?>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="btn-submit">
          Log in
        </button>
        <?php      
            if(setpost('btn-submit'))
            {  
              if($licence1 && $licence2)
              {
                  $row = mysqli_fetch_assoc(mysqli_query($dblink,"SELECT id FROM users WHERE phone = '$phone'"));
                  $id = $row['id'];
                //   header("Location:profile.php?id='$id'");
                //   die;
                  redirect("profile","id",$id);
              }
            }
        ?>
        <p class="mt-5 mb-3 text-muted">Dont have an account <a href="register.php">register</a></p>
      </form>
    </main>
  <?php
        disconnect();
  ?>
  </body>
</html>