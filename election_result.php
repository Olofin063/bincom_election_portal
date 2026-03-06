<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Bincom Test | Election Portal</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- External Css -->
  <link rel="stylesheet" href="assets/css/line-awesome.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

  <!-- Custom Css -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="assets/css/job-2.css">

  <!-- Fonts -->
  <link href="../../../../css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" href="assets/images/favicon.png">
  <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/images/icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/images/icon-114x114.png">


</head>

<body>

  <div class="ugf-wraper">
    <div class="ugf-nav-wrap">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7 col-sm-8 p-sm-0">
            <div class="ugf-nav">
              <div class="logo-wrap">
                <a href="../index.html">
                  <img src="" class="logo" alt="">
                </a>
              </div>
              <div class="job-wrap">
                <h3>Polling Unit Result</h3>
                <ul>
                  <li><img src="assets/images/map-marker.png" alt="">Nigeria</li>
                  <li><img src="assets/images/map-marker.png" alt="">Delta State</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-sm-8 p-sm-0">
          <div class="ufg-job-application-wrapper">
            <a href="index.html" class="btn btn-outline-secondary mb-3">&larr; Back to Home</a>
            <form method="post" class="job-application-form" id="commentForm">

              <!-- PHP script -->
              <?php
              include 'db_conn.php';

              ?>
              <div class="input-type-block">
                <h4>Select Polling Unit</h4>

              </div>
              <div class="form-group">
                <div class="d-flex gap-2">
                  <select id="inputCountry" class="form-control" name="pollingunit" required="">
                    <option value="" disabled selected>-- Select Polling Unit --</option>
                    <?php
                    $query = "SELECT uniqueid, polling_unit_name FROM polling_unit";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['uniqueid'] . "'>" . htmlspecialchars($row['polling_unit_name']) . "</option>";
                    }
                    ?>
                  </select>
                  <button type="submit" class="btn">View Results</button>
                </div>

                 <!-- Results table -->
                  <div class="results-table mt-4">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pollingunit'])) {
                      $pollingUnitId = $_POST['pollingunit'];
  
                      // Fetch results for the selected polling unit
                      $query = "SELECT party_abbreviation, party_score FROM announced_pu_results WHERE polling_unit_uniqueid = '$pollingUnitId'";
                      $result = mysqli_query($conn, $query);
  
                      if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-bordered'>";
                        echo "<thead><tr><th>Party</th><th>Votes</th></tr></thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr><td>" . htmlspecialchars($row['party_abbreviation']) . "</td><td>" . htmlspecialchars($row['party_score']) . "</td></tr>";
                        }
                        echo "</tbody></table>";
                      } else {
                        echo "<p>No results found for the selected polling unit.</p>";
                      }
                    }
                    ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.validate.min.js"></script>


  <script src="assets/js/custom.js"></script>
</body>

</html>