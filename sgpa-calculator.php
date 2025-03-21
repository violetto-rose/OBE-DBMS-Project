<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>SGPA Calculator</title>

    <meta name="author" content="violetto-rose" />
    <meta name="description"
        content="A project on OBE (Outcome based education) tracker with Course and Program outcome details along with subject information." />

    <!--Styles-->
    <link rel="stylesheet" href="CSS/sgpa.css" />

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!--Script-->
    <script src="JS/cookies.js"></script>
</head>

<!--Body-->

<body>

    <!--Nav bar-->
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="mailto:manjumadhav.va@gmail.com">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!--Title-->
    <div class="title">
        <div class="flex">
            <div class="pagetitle">
                <p>SGPA Calculator</p>
            </div>
        </div>
    </div>

    <!--Selection-->
    <form method="post">
        <div class="selection">
            <!--Scheme-->
            <div class="scheme">
                <label for="scheme">Select your scheme</label>
                <select id="scheme" name="scheme">
                    <option value="2022">2022</option>
                </select>
            </div>

            <!-- Semester -->
            <div class="semester">
                <label for="semester">Select your semester</label>
                <select id="semester" name="semester">
                    <option value="3">3rd Semester</option>
                    <option value="4">4th Semester</option>
                    <option value="5">5th Semester</option>
                    <option value="6">6th Semester</option>
                    <option value="7">7th Semester</option>
                    <option value="8">8th Semester</option>
                </select>
            </div>

            <div class="mybutton">
                <button type="submit" name="submit">Submit</button>
            </div>
        </div>
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "OBE";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to fetch subjects based on selected semester and scheme
    function fetchSubjects($conn, $semester, $scheme)
    {
        $stmt = $conn->prepare("SELECT * FROM csd_main WHERE semester = ? AND scheme_year = ? ORDER BY subject_number");
        $stmt->bind_param("ii", $semester, $scheme);
        $stmt->execute();

        // Store the result set in a variable
        $result = $stmt->get_result();

        // Free the previous statement to avoid "Commands out of sync" error
        $stmt->free_result();
        $stmt->close();

        return $result;
    }

    // Function to fetch subject details
    function fetchSubjectDetails($conn, $subject_code)
    {
        $stmt_details = $conn->prepare("SELECT subject_name, credits FROM subjects WHERE subject_code = ?");
        $stmt_details->bind_param("s", $subject_code);
        $stmt_details->execute();
        $result = $stmt_details->get_result();

        // Fetch the result row
        $row = $result->fetch_assoc();

        // Free the result and close the statement
        $stmt_details->free_result();
        $stmt_details->close();

        return $row;
    }

    // Fetching credits based on selected semester and scheme
    if (isset($_POST['submit']) || isset($_POST['calculate'])) {
        $semester = $_POST['semester'];
        $scheme = $_POST['scheme'];

        $result = fetchSubjects($conn, $semester, $scheme);

        if (!$result) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        if ($result->num_rows > 0) {
            echo "<form method='post'>";
            echo "<table>";
            echo "<tr><th>Subject Name</th><th>Credits</th><th>Marks</th></tr>";
            $marks = isset($_POST['marks']) ? $_POST['marks'] : [];
            $credits = isset($_POST['credits']) ? $_POST['credits'] : [];
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $subject_code = $row["subject_code"];

                // Fetch subject_name and credits from the database
                $subject_details = fetchSubjectDetails($conn, $subject_code);

                // Check if subject details are fetched properly
                if ($subject_details) {
                    $currentMarks = isset($marks[$i]) ? $marks[$i] : '';
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($subject_details['subject_name']) . "</td>";
                    echo "<td class='credits'>" . $subject_details['credits'] . "</td>";
                    echo "<td><input type='text' name='marks[]' value='" . htmlspecialchars($currentMarks) . "'></td>";
                    echo "<input type='hidden' name='credits[]' value='" . $subject_details['credits'] . "'>";
                    echo "</tr>";
                    $i++;
                } else {
                    // Handle case where subject details are not found
                    echo "<tr><td colspan='3'>Subject details not found for subject code: $subject_code</td></tr>";
                }
            }
            echo "</table>";
            echo "<input type='hidden' name='semester' value='$semester'>";
            echo "<input type='hidden' name='scheme' value='$scheme'>";
            echo "<div class='my-btn'>
                    <button type='submit' name='calculate' value='Calculate'>Calculate</button>
                </div>";
            echo "</form>";
        } else {
            echo "<div class='result'><h2>No subjects found for selected semester and scheme.</h2></div>";
        }
    }

    if (isset($_POST['calculate'])) {
        $marks = $_POST['marks'];
        $credits = $_POST['credits'];
        $semester = $_POST['semester'];
        $scheme = $_POST['scheme'];

        $total_credits = 0;
        $total_grade_points = 0;

        function getGradePoint($marks)
        {
            if ($marks >= 90 && $marks <= 100) {
                return 10;
            } elseif ($marks >= 80 && $marks < 90) {
                return 9;
            } elseif ($marks >= 70 && $marks < 80) {
                return 8;
            } elseif ($marks >= 60 && $marks < 70) {
                return 7;
            } elseif ($marks >= 55 && $marks < 60) {
                return 6;
            } elseif ($marks >= 50 && $marks < 55) {
                return 5;
            } elseif ($marks >= 40 && $marks < 50) {
                return 4;
            } else {
                return 0;
            }
        }

        function allNumeric($marks)
        {
            foreach ($marks as $value) {
                if (!is_numeric($value)) {
                    return false;
                }
            }
            return true;
        }

        // Calculating total credits and total grade points
        for ($i = 0; $i < count($marks); $i++) {
            $total_credits += $credits[$i];
            $total_grade_points += getGradePoint($marks[$i]) * $credits[$i];
        }

        // Calculating SGPA
        if ($total_credits != 0 && allNumeric($marks)) {
            $sgpa = $total_grade_points / $total_credits;
            echo "<div class='result'><h2>Your SGPA is: " . round($sgpa, 2) . "</h2></div>";
        } else {
            echo "<div class='result'><h2>Invalid input for SGPA calculation.</h2></div>";
        }
    }

    $conn->close();
    ?>
</body>

</html>
