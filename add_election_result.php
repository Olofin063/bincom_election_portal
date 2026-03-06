<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bincom Test | Add Polling Unit Results</title>

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
                                <h3>Add Polling Unit Results</h3>
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
                        <form method="post" class="job-application-form" id="resultsForm">

                            <!-- PHP script -->
                            <?php
                            include 'db_conn.php';

                            // load party list once
                            $partyList = [];
                            $partyQuery = "SELECT partyid, partyname FROM party";
                            $partyResult = mysqli_query($conn, $partyQuery);
                            while ($p = mysqli_fetch_assoc($partyResult)) {
                                $partyList[] = $p;
                            }

                            // handle submission: pollingunit + scores indexed by partyid
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pollingunit'])) {
                                $pollingUnitId = mysqli_real_escape_string($conn, $_POST['pollingunit']);
                                $partyIds = $_POST['partyid'] ?? [];
                                $scores = $_POST['score'] ?? [];

                                $insertStmt = mysqli_prepare($conn, "INSERT INTO announced_pu_results (party_abbreviation, party_score, polling_unit_uniqueid) VALUES (?, ?, ?)");
                                mysqli_stmt_bind_param($insertStmt, 'sii', $abbr, $score, $pollingUnitId);

                                $added = 0;
                                for ($i = 0; $i < count($partyIds); $i++) {
                                    $abbr = mysqli_real_escape_string($conn, $partyIds[$i]);
                                    $score = intval($scores[$i]);

                                    // only insert if a score was provided
                                    if ($score >= 0) {
                                        mysqli_stmt_execute($insertStmt);
                                        $added++;
                                    }
                                }
                                mysqli_stmt_close($insertStmt);

                                if ($added > 0) {
                                    echo "<div class='alert alert-success'>Inserted $added party result(s) for the selected polling unit.</div>";
                                } else {
                                    echo "<div class='alert alert-warning'>No results were saved.</div>";
                                }
                            }
                            ?>

                            <div class="input-type-block">
                                <h4>Select Polling Unit</h4>
                            </div>
                            <div class="form-group">
                                <div class="d-flex gap-2">
                                    <select id="pollingUnit" class="form-control" name="pollingunit" required="">
                                        <option value="" disabled selected>-- Select Polling Unit --</option>
                                        <?php
                                        $query = "SELECT uniqueid, polling_unit_name FROM polling_unit";
                                        $result = mysqli_query($conn, $query);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['uniqueid'] . "'>" . htmlspecialchars($row['polling_unit_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="input-type-block">
                                <h4>Enter Party Results</h4>
                            </div>
                            <table class="table" id="resultsTable">
                                <thead>
                                    <tr>
                                        <th>Party</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($partyList as $p): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($p['partyname']); ?>
                                                <input type="hidden" name="partyid[]" value="<?php echo htmlspecialchars($p['partyid']); ?>">
                                            </td>
                                            <td><input type="number" name="score[]" class="form-control" min="0" /></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Save Results</button>
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