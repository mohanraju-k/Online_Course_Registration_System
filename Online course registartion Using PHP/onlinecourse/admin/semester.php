<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for insertion
    if (isset($_POST['submit'])) {
        $semester = $_POST['semester'];
        // Server-side validation: Ensure semester is numeric
        if (preg_match('/^[0-9]+$/', $semester)) {
            $ret = mysqli_query($con, "insert into semester(semester) values('$semester')");
            if ($ret) {
                echo '<script>alert("Semester Created Successfully !!")</script>';
                echo '<script>window.location.href=semester.php</script>';
            } else {
                echo '<script>alert("Something went wrong. Please try again.")</script>';
                echo '<script>window.location.href=semester.php</script>';
            }
        } else {
            echo '<script>alert("Invalid input. Semester must contain only numbers.")</script>';
            echo '<script>window.location.href=semester.php</script>';
        }
    }
    // Code for deletion
    if (isset($_GET['del'])) {
        $sid = $_GET['id'];
        mysqli_query($con, "delete from semester where id ='$sid'");
        echo '<script>alert("Semester Deleted Successfully !!")</script>';
        echo '<script>window.location.href=semester.php</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Semester</title>
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
                    <h1 class="page-head-line">Semester</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Semester
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>

                        <div class="panel-body">
                            <form name="semester" method="post" onsubmit="return validateSemester()">
                                <div class="form-group">
                                    <label for="semester">Add Semester</label>
                                    <input type="text" class="form-control" id="semester" name="semester" placeholder="semester" required />
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
                        Manage Semester
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Semester</th>
                                        <th>Creation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$sql = mysqli_query($con, "select * from semester");
$cnt = 1;
while ($row = mysqli_fetch_array($sql)) {
?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row['semester']); ?></td>
                                        <td><?php echo htmlentities($row['creationDate']); ?></td>
                                        <td>
                                            <a href="semester.php?id=<?php echo $row['id'] ?>&del=delete" onclick="return confirm('Are you sure you want to delete?')">
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
        function validateSemester() {
            var semester = document.getElementById('semester').value;
            var regex = /^[0-9]+$/;
            if (!regex.test(semester)) {
                alert('Invalid input. Semester must contain only numbers.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php } ?>