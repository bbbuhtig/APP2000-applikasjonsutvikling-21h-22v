
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../main.css" />
    <title>Finance Budget App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <header class="block" style="margin-top: 30px;">
      <!-- <h1 class="myTextFont">Finance Budget App</h1> -->
      <img src="../pictures/logo.png" alt="logo" width="300" height="300" />
    </header>

    <main>
      <div></div>
      <form class="block" action="edit.php" method="post">

        <div class="contentBox">
          <label style="margin-top: 50px;">Confirm e-mail</label>
          <input type="text" name='email' required>
          <a><button type="submit" class="loginButton" value="Edit" name="update_btn">Delete account</button></a>
          <p>
          </p>
          <h3 style="margin-top: 100px;"><a href="../profile.php">Cancel</a></h3>
        </div>
      </form>
    </main>

    <footer>
      <ul>
        <li>
          <a href="../home.html">Home</a>
        </li>
        <li>
          <a href="../faq.html">FAQ</a>
        </li>
        <li>
          <a href="../about.html">About</a>
        </li>
        <li>
          <a href="../contacts.html">Contact</a>
        </li>
      </ul>
      <p>&copy; 2021 Finance Budget App AS</p>
    </footer>
  </body>
</html>