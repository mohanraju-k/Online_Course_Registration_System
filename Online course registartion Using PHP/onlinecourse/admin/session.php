<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for Insertion
    if (isset($_POST['submit'])) {
        $sesssion = $_POST['sesssion'];
        // Server-side validation: Ensure session is numeric
        if (preg_match('/^[0-9]+$/', $sesssion)) {
            $ret = mysqli_query($con, "insert into session(session) values('$sesssion')");
            if ($ret) {
                echo '<script>alert("Session Created Successfully !!")</script>';
                echo '<script>window.location.href=session.php</script>';
            } else {
                echo '<script>alert("Error : Session not created")</script>';
                echo '<script>window.location.href=session.php</script>';
            }
        } else {
            echo '<script>alert("Invalid input. Session must contain only numbers.")</script>';
            echo '<script>window.location.href=session.php</script>';
        }
    }

    // Code for Deletion
    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from session where id = '" . $_GET['id'] . "'");
        echo '<script>alert("Session Deleted")</script>';
        echo '<script>window.location.href=session.php</script>';
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Session</title>
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
                    <h1 class="page-head-line">Add session</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Session
                        </div>
                        <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>

                        <div class="panel-body">
                            <form name="session" method="post" onsubmit="return validateSession()">
                                <div class="form-group">
                                    <label for="sesssion">Create Session</label>
                                    <input type="text" class="form-control" id="sesssion" name="sesssion" placeholder="Session" required />
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
                        Manage Session
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Session</th>
                                        <th>Creation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$sql = mysqli_query($con, "select * from session");
$cnt = 1;
while ($row = mysqli_fetch_array($sql)) {
?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row['session']); ?></td>
                                        <td><?php echo htmlentities($row['creationDate']); ?></td>
                                        <td>
                                            <a href="session.php?id=<?php echo $row['id'] ?>&del=delete" onclick="return confirm('Are you sure you want to delete?')">
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
        function validateSession() {
            var session = document.getElementById('sesssion').value;
            var regex = /^[0-9]+$/;
            if (!regex.test(session)) {
                alert('Invalid input. Session must contain only numbers.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<?php } ?>