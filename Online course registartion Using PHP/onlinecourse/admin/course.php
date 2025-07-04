<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for Insertion
    if (isset($_POST['submit'])) {
        $coursecode = $_POST['coursecode'];
        $coursename = $_POST['coursename'];
        $courseunit = $_POST['courseunit'];
        $seatlimit = $_POST['seatlimit'];
        // Server-side validation
        if (
            preg_match('/^[a-zA-Z0-9]+$/', $coursecode) &&
            preg_match('/^[a-zA-Z\s]+$/', $coursename) &&
            preg_match('/^[0-9]+$/', $courseunit) &&
            preg_match('/^[0-9]+$/', $seatlimit)
        ) {
            $ret = mysqli_query($con, "insert into course(courseCode,courseName,courseUnit,noofSeats) values('$coursecode','$coursename','$courseunit','$seatlimit')");
            if ($ret) {
                echo '<script>alert("Course Created Successfully !!")</script>';
                echo '<script>window.location.href=course.php</script>';
            } else {
                echo '<script>alert("Error : Course not created!!")</script>';
                echo '<script>window.location.href=course.php</script>';
            }
        } else {
            echo '<script>alert("Invalid input. Please check: Course Code (alphanumeric), Course Name (letters only), Course Unit (numbers only), Seat Limit (numbers only).")</script>';
            echo '<script>window.location.href=course.php</script>';
        }
    }

    // Code for Deletion
    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from course where id = '" . $_GET['id'] . "'");
        echo '<script>alert("Course deleted!!")</script>';
        echo '<script>window.location.href=course.php</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Admin | Course</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php'); ?>
    <!-- LOGO HEADER END-->
<?php if ($_SESSION['alogin'] != "") {
    include('includes/menubar.php');
} ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line">Course</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Course
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>

                        <div class="panel-body">
                            <form name="dept" method="post" onsubmit="return validateCourse()">
                                <div class="form-group">
                                    <label for="coursecode">Course Code</label>
                                    <input type="text" class="form-control" id="coursecode" name="coursecode" placeholder="Course Code" required />
                                </div>
                                <div class="form-group">
                                    <label for="coursename">Course Name</label>
                                    <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Course Name" required />
                                </div>
                                <div class="form-group">
                                    <label for="courseunit">Course Unit</label>
                                    <input type="text" class="form-control" id="courseunit" name="courseunit" placeholder="Course Unit" required />
                                </div>
                                <div class="form-group">
                                    <label for="seatlimit">Seat Limit</label>
                                    <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat Limit" required />
                                </div>
                                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?></font>
            <div class="col-md-12">
                <!-- Bordered Table -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Course
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Course Unit</th>
                                        <th>Seat Limit</th>
                                        <th>Creation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$sql = mysqli_query($con, "select * from course");
$cnt = 1;
while ($row = mysqli_fetch_array($sql)) {
?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row['courseCode']); ?></td>
                                        <td><?php echo htmlentities($row['courseName']); ?></td>
                                        <td><?php echo htmlentities($row['courseUnit']); ?></td>
                                        <td><?php echo htmlentities($row['noofSeats']); ?></td>
                                        <td><?php echo htmlentities($row['creationDate']); ?></td>
                                        <td>
                                            <a href="edit-course.php?id=<?php echo $row['id'] ?>">
                                                <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
                                            </a>
                                            <a href="course.php?id=<?php echo $row['id'] ?>&del=delete" onclick="return confirm('Are you sure you want to delete?')">
                                                <button class="btn btn-danger">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
<?php
    $cnt++;
} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Bordered Table -->
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.js"></script>
    <script>
        function validateCourse() {
            var coursecode = document.getElementById('coursecode').value;
            var coursename = document.getElementById('coursename').value;
            var courseunit = document.getElementById('courseunit').value;
            var seatlimit = document.getElementById('seatlimit').value;
            var codeRegex = /^[a-zA-Z0-9]+$/;
            var nameRegex = /^[a-zA-Z\s]+$/;
            var numberRegex = /^[0-9]+$/;
            if (!codeRegex.test(coursecode)) {
                alert('Invalid Course Code. Must be alphanumeric.');
                return false;
            }
            if (!nameRegex.test(coursename)) {
                alert('Invalid Course Name. Must contain letters only.');
                return false;
            }
            if (!numberRegex.test(courseunit)) {
                alert('Invalid Course Unit. Must contain numbers only.');
                return false;
            }
            if (!numberRegex.test(seatlimit)) {
                alert('Invalid Seat Limit. Must contain numbers only.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php } ?>