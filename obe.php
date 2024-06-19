<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>OBE CO-PO Tracker</title>

  <meta name="author" content="violetto-rose" />
  <meta name="description"
    content="A project on OBE (Outcome based education) tracker with Course and Program outcome details along with subject information." />

  <!--Styles-->
  <link rel="stylesheet" href="CSS/obe.css" />

  <!--Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
</head>

<!--Body-->

<body>
  <?php

  // Function to add suffix to semester numbers
  function addSuffix($semester)
  {
    switch ($semester) {
      case 3:
        return $semester . 'rd';
      case 4:
      case 5:
      case 6:
      case 7:
      case 8:
        return $semester . 'th';
      default:
        return ''; // Handle other cases as needed
    }
  }

  // Establish a database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "OBE";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch data from the database based on the selected scheme and semester
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $scheme = $_POST["scheme"];
    $semester = $_POST["semester"];
    $stmt = $conn->prepare("SELECT * FROM csd_main WHERE scheme_year = ? AND semester = ? ORDER BY subject_number");
    $stmt->bind_param("ii", $scheme, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='head'>
            <h1>Department of Computer Science and Design</h1>
            <h2>OBE Report of " . addSuffix($semester) . " Semester, $scheme Scheme</h2>
            <br />
            <hr />
          </div>";

    if ($result->num_rows > 0) {
      echo "<div class='subjects-container'>";
      while ($row = $result->fetch_assoc()) {
        // Fetch additional details for each subject
        $subject_code = $row["subject_code"];
        $subject_name = "";
        $faculty = "";
        $credits = 0;
        $course_outcomes = array();

        // Query to fetch subject details
        $stmt_details = $conn->prepare("SELECT subject_name, faculty, credits FROM subjects WHERE subject_code = ?");
        $stmt_details->bind_param("s", $subject_code);
        $stmt_details->execute();
        $result_details = $stmt_details->get_result();

        if ($result_details->num_rows > 0) {
          $row_details = $result_details->fetch_assoc();
          $subject_name = $row_details["subject_name"];
          $faculty = $row_details["faculty"];
          $credits = $row_details["credits"];
        }

        // Query to fetch course outcomes
        $stmt_outcomes = $conn->prepare("SELECT course_outcome FROM course_outcomes WHERE subject_code = ?");
        $stmt_outcomes->bind_param("s", $subject_code);
        $stmt_outcomes->execute();
        $result_outcomes = $stmt_outcomes->get_result();

        while ($row_outcome = $result_outcomes->fetch_assoc()) {
          $course_outcomes[] = $row_outcome["course_outcome"];
        }

        // Display subject information
        echo "<div class='subject-container'>
                <h2>$subject_name</h2>
                <p><strong>Subject Code:</strong> $subject_code</p>
                <p><strong>Faculty:</strong> $faculty</p>
                <p><strong>Credits:</strong> $credits</p>";

        echo "<div class='course-outcomes'>
                <strong>Course Outcomes:</strong>
                <ul>";
        foreach ($course_outcomes as $outcome) {
          // Split the outcome string by periods and iterate over each segment
          $outcome_segments = explode('.', $outcome);
          foreach ($outcome_segments as $segment) {
            // Trim any leading/trailing whitespace and check if the segment is not empty
            $segment = trim($segment);
            if (!empty($segment)) {
              echo "<li>$segment.</li>";
            }
          }
        }
        echo "</ul>
              </div>";

        echo "</div>";
      }
      echo "</div>";
    } else {
      echo "<div class='result'>
              <p>NO RESULTS</p>
            </div>";
    }
  }
  $conn->close();
  ?>

  <div class='button'>
    <span class="btn">
      <a href="uploads/attainment.xlsx">CO-PO Attainment</a>
    </span>
  </div>

  <div class="button-container">
    <a href="index.html" class="home-button">Home</a>
  </div>

</body>

</html>