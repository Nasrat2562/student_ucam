<?php
session_start(); // Start session to access session variables

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_ucam"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student information from `students` table and profile picture from `users` table
$loggedInUser = $_SESSION['username'];
$sql = "SELECT s.name, s.gender, s.blood_group, s.contact_no, s.nationality, s.father_name, s.mother_name, 
        s.sms_contact, s.date_of_birth, s.marital_status, s.religion, s.email, s.guardian_name, 
        s.father_profession, s.mother_profession, s.present_address, s.permanent_address, s.guardian_address, 
        s.mailing_address, u.profile_picture FROM students s
        JOIN users u ON s.username = u.username
        WHERE s.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUser);
$stmt->execute();
$stmt->bind_result($name, $gender, $blood_group, $contact_no, $nationality, $father_name, $mother_name, 
                  $sms_contact, $dob, $marital_status, $religion, $email, $guardian_name, 
                  $father_profession, $mother_profession, $present_address, $permanent_address, 
                  $guardian_address, $mailing_address, $profile_picture);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        .profile-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 20px;
        }
        .profile-photo img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-details {
            width: 70%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2><?php echo htmlspecialchars($name); ?>!</h2>
    
    <div class="profile-container">
        <!-- Profile Photo Section -->
        <div class="profile-photo">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
        </div>

        <!-- Profile Information Table -->
        <div class="profile-details">
            <table>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($name); ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($gender); ?></td>
                </tr>
                <tr>
                    <th>Blood Group</th>
                    <td><?php echo htmlspecialchars($blood_group); ?></td>
                </tr>
                <tr>
                    <th>Contact No</th>
                    <td><?php echo htmlspecialchars($contact_no); ?></td>
                </tr>
                <tr>
                    <th>Nationality</th>
                    <td><?php echo htmlspecialchars($nationality); ?></td>
                </tr>
                <tr>
                    <th>Father's Name</th>
                    <td><?php echo htmlspecialchars($father_name); ?></td>
                </tr>
                <tr>
                    <th>Mother's Name</th>
                    <td><?php echo htmlspecialchars($mother_name); ?></td>
                </tr>
                <tr>
                    <th>SMS Contact</th>
                    <td><?php echo htmlspecialchars($sms_contact); ?></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><?php echo htmlspecialchars($dob); ?></td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td><?php echo htmlspecialchars($marital_status); ?></td>
                </tr>
                <tr>
                    <th>Religion</th>
                    <td><?php echo htmlspecialchars($religion); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($email); ?></td>
                </tr>
                <tr>
                    <th>Guardian's Name</th>
                    <td><?php echo htmlspecialchars($guardian_name); ?></td>
                </tr>
                <tr>
                    <th>Father's Profession</th>
                    <td><?php echo htmlspecialchars($father_profession); ?></td>
                </tr>
                <tr>
                    <th>Mother's Profession</th>
                    <td><?php echo htmlspecialchars($mother_profession); ?></td>
                </tr>
                <tr>
                    <th>Present Address</th>
                    <td><?php echo htmlspecialchars($present_address); ?></td>
                </tr>
                <tr>
                    <th>Permanent Address</th>
                    <td><?php echo htmlspecialchars($permanent_address); ?></td>
                </tr>
                <tr>
                    <th>Guardian's Address</th>
                    <td><?php echo htmlspecialchars($guardian_address); ?></td>
                </tr>
                <tr>
                    <th>Mailing Address</th>
                    <td><?php echo htmlspecialchars($mailing_address); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

