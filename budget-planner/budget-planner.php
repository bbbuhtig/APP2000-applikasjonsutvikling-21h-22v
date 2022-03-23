<?php
  session_start();
  $email = $_SESSION['email'];

  include '../connect_mysql/connect.php';
	$conn = OpenCon();

  $sql = "SELECT * FROM Customer WHERE EMail='$email'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $id = $row['CustomerID'];

  $sqlimage = "SELECT name FROM images WHERE CustomerID='$id'";
  $resultimage = mysqli_query($conn,$sqlimage);
  $rowimage = mysqli_fetch_array($resultimage);

  $image = $rowimage['name'];
  $image_src = "upload/".$image;

  // Gjør klar litt data for siden
  $sql = "SELECT * from budget WHERE customerID=" . $id .
    " AND YEAR(creationDate)=" . (int)date('Y') . 
    " AND MONTH(creationDate)=" . (int)date('m') . ";";

  $result   = $conn->query($sql);
  $row      = $result->fetch_assoc();
  $budgetID = isset($row["budgetID"])? $row["budgetID"] : 0;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../main.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <title>Finance Budget App</title>
  </head>
  <body>
    <header>
        <div id="sideMenu">
          <div style="align-self: flex-start;">
            <a href="../home.php"
              ><div class="block sideMenuItem">
                <img
                alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/14443/home.svg"
                  class="sideMenuIcon"
                />Home
              </div></a
            >
            <a href="../budget.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/17167/pie-chart.svg"
                  class="sideMenuIcon"
                />Budget
              </div></a
            >
            <a href="../budget-planner.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/11983/from-a-to-z.svg"
                  class="sideMenuIcon"
                />Budget planner
              </div></a
            >
            <a href="../achievements.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/84275/trophy.svg"
                  class="sideMenuIcon"
                />Achievements
              </div></a
            >
          </div>
          <div style="align-self: flex-end; margin-bottom: 40px;">
            <a href="../profile.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/7025/user.svg"
                  class="sideMenuIcon"
                />Profile
              </div></a
            >
            <a href="../faq.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/348371/help.svg"
                  class="sideMenuIcon"
                />Help
              </div></a
            >
            <a href="../index.php"
              ><div class="block sideMenuItem">
                <img
                  alt="side_menu_icon"
                  src="https://www.svgrepo.com/show/334066/log-out-circle.svg"
                  class="sideMenuIcon"
                />Log out
              </div>
            </a>
          </div>
        </div>
  
        <img
            id="menuClosed"
            alt="menuLogo"
            class="headerLogo"
            src="https://www.svgrepo.com/show/336031/hamburger-button.svg"
        />
        
        <img 
            src="../pictures/logo_header.png" 
            alt="logo_header" 
            class="finance-logo"
        />

        <a href="../profile.php" style="margin-top: 2%; margin-right: 1%; position: absolute; right: 0">
        <img 
            src="../<?php echo $image_src;  ?>" 
            alt="profile_photo" 
            class="profile-logo"
        />
        </a>


    </header>

    <main>
      <form action="upload-budget.php" method="post">

        <!-- Sender første entrien i arrayen, slik at vi ikke får feil ved tomm form -->
        <input type="hidden" name="income-name[]" value="0">
        <input type="hidden" name="income-value[]" value="0">
        <input type="hidden" name="expense-name[]" value="0">
        <input type="hidden" name="expense-value[]" value="0">
        <input type="hidden" name="future-name[]" value="0">
        <input type="hidden" name="future-value[]" value="0">
        <input type="hidden" name="future-date[]" value="0">

        <h1 style="text-align: center;">Budget Planner</h1>
        <div class="grid-container">
          <div class="contentBoxBudgetPlanner" id="lol" style="margin: 50px 50px 50px 70px; padding: 50px;">
            <h2>Income</h2>
            <div id="incomeInputs">
            <!-- Her legger scriptet til forskjellige incomes -->
            </div>
            <button class="addButton" type="button" id="addButton-income"><i class="fas fa-plus-square"></i></button>
          </div>

          <div class="contentBoxBudgetPlanner" id="high" style="margin: 50px 70px 50px 50px; padding: 50px;">
            <h2>Expenses</h2>
            <div id="expenseInputs">
            <!-- Her legger scriptet til forskjellige expenses -->
            </div>
            <button class="addButton" type="button" id="addButton-expense"><i class="fas fa-plus-square"></i></button>
          </div>
          
          <div class="contentBoxBudgetPlanner" style="margin: 50px 50px 50px 70px; padding: 50px;">
            <h2>Summary</h2>
            <label id="contentBox-budget-planner" style="margin-top: 50px; width: 180px;">Total income</label>
            <input type="number" id="totalIncome" readonly="readonly"/> <br>
            <label id="contentBox-budget-planner" style="width: 180px;">Total expenses</label>
            <input type="number" id="totalExpense" readonly="readonly"/> <br>
            <label id="contentBox-budget-planner" style="width: 180px;">Difference</label>
            <input type="number" id="difference" readonly="readonly"/> <br>

            <button class="submitButton" type="submit">Submit</button>
          </div>
        </div>
        <div class="block">
          <div class="contentBox" style="width: 100vw;">
            <h2>Long term goals</h2>
            <div id="futureInputs">
              <!-- Her legger scriptet til forskjellige saving goals -->
            </div>
            <button class="addButton" type="button" id="addButton-future"><i class="fas fa-plus-square"></i></button>
          </div>
        </div>
      </form>
    </main>

    <footer>
      <ul>
        <li>
          <a href="../home.php">Home</a>
        </li>
        <li>
          <a href="../faq.php">FAQ</a>
        </li>
        <li>
          <a href="../about.php">About</a>
        </li>
        <li>
          <a href="../contactForm/index.php">Contact</a>
        </li>
      </ul>
      <p>&copy; 2021 Finance Budget App AS</p>
    </footer>
    <script src="../main.js"></script>
    <script src="budget-planner.js"></script>
    <script>

      // constructor(name, classes, defaultArr, arr = [])
      var name, classes, defaultArr;

      // Income
      name        = "income";
      classes     = [new Field("name", "text"), new Field("value", "number")];
      defaultArr  = ["income", 0];

      var incomePlanner = new Planner(name, classes, defaultArr);
      document.getElementById("addButton-income").onclick = function() {
        incomePlanner.add();
      }

      // Expense
      name        = "expense";
      classes     = [new Field("name", "text"), new Field("value", "number")];
      defaultArr  = ["expense", 0];

      var expensePlanner = new Planner(name, classes, defaultArr);
      document.getElementById("addButton-expense").onclick = function() {
        expensePlanner.add();
      }

      // Saving goals
      name        = "future";
      classes     = [new Field("name", "text"), new Field("value", "number"), new Field("date", "date")];
      defaultArr  = ["saving goal", 0, null, 0];

      var futurePlanner = new Planner(name, classes, defaultArr);
      document.getElementById("addButton-future").onclick = function() {
        futurePlanner.add();
      }

      // Les budget-planner js for de fleste funksjonene som blir kalt her

      //funnksjon for å hente inn data fra tidligere budget om det er fra samme mående
      <?php

        if($budgetID != 0) {

          $sql    = "SELECT * FROM transactions WHERE budgetID='$budgetID';";
          $result = $conn->query($sql);
          echo "console.log(" . $budgetID . ");";
          while($row = $result->fetch_assoc()) {

            if($row["transactionType"] == "income") {

              //echo "incomeInput.push(['" . $row['transactionName'] . "', " . $row['transactionValue'] . "]);";
              echo "incomePlanner.add(['" . $row['transactionName'] . "', " . $row['transactionValue'] . "]);";

            } else {

              //echo "expenseInput.push(['" . $row['transactionName'] . "', " . $row['transactionValue'] . "]);";
              echo "expensePlanner.add(['" . $row['transactionName'] . "', " . $row['transactionValue'] . ", 1]);";
            }
          }
        }

        $sql = "SELECT * FROM goal WHERE customerID='$id';";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {

          echo "futurePlanner.add(['" . $row['goalName'] . "', " . $row['goalValue'] . ", '" . $row['goalDate'] . "']);"; 
        }
      ?>

      // Legger til saving goals i expense
      for(var i = 0;i < futurePlanner.arr.length;i++) {
        var name  = futurePlanner.arr[i][0];
        var match = false;

        for(var j = 0;j < expensePlanner.arr.length;j++) {
          if(name == expensePlanner.arr[j][0]) {
            match = true;
            break;
          }
        }

        if(!match) {
          expensePlanner.add([name, 0]);
        }

      }

      updateSummary(incomePlanner, expensePlanner);

    </script>
  </body>
</html>
