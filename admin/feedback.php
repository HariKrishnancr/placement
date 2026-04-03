<?php
session_start();

if (empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");

// Handle admin response submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['respond'])) {
  $feedback_id = mysqli_real_escape_string($conn, $_POST['feedback_id']);
  $admin_response = mysqli_real_escape_string($conn, $_POST['admin_response']);
  
  $sql = "UPDATE feedback SET admin_response='$admin_response', response_date=NOW() WHERE id='$feedback_id'";
  
  if ($conn->query($sql) === TRUE) {
    $_SESSION['response_success'] = "success";
    $_SESSION['response_message'] = "Response sent successfully!";
  } else {
    $_SESSION['response_success'] = "error";
    $_SESSION['response_message'] = "Error sending response. Please try again.";
  }
  
  header("Location: feedback.php");
  exit();
}

// Handle delete feedback
if (isset($_GET['delete'])) {
  $feedback_id = mysqli_real_escape_string($conn, $_GET['delete']);
  $sql = "DELETE FROM feedback WHERE id='$feedback_id'";
  
  if ($conn->query($sql) === TRUE) {
    $_SESSION['response_success'] = "success";
    $_SESSION['response_message'] = "Feedback deleted successfully!";
  } else {
    $_SESSION['response_success'] = "error";
    $_SESSION['response_message'] = "Error deleting feedback.";
  }
  
  header("Location: feedback.php");
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Feedback Management - Placement Portal</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php include 'header.php'; ?>

    <div class="content-wrapper" style="margin-left: 0px;">
      <section id="candidates" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Welcome <b>Admin</b></h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="active-jobs.php"><i class="fa fa-briefcase"></i> Active Drives</a></li>
                    <li><a href="applications.php"><i class="fa fa-address-card-o"></i> Students Profile</a></li>
                    <li><a href="companies.php"><i class="fa fa-arrow-circle-o-right"></i> Co - Ordinators</a></li>
                    <li class="active"><a href="feedback.php"><i class="fa fa-comments"></i> Feedback</a></li>
                    <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="col-md-9 bg-white padding-2">
              <h2><i class="fa fa-comments"></i> Student Feedback</h2>
              <p>Review and respond to student feedback</p>
              
              <?php
              // Get statistics
              $total_sql = "SELECT COUNT(*) as total FROM feedback";
              $pending_sql = "SELECT COUNT(*) as pending FROM feedback WHERE admin_response IS NULL OR admin_response = ''";
              $responded_sql = "SELECT COUNT(*) as responded FROM feedback WHERE admin_response IS NOT NULL AND admin_response != ''";
              
              $total_result = $conn->query($total_sql);
              $pending_result = $conn->query($pending_sql);
              $responded_result = $conn->query($responded_sql);
              
              $total = $total_result->fetch_assoc()['total'];
              $pending = $pending_result->fetch_assoc()['pending'];
              $responded = $responded_result->fetch_assoc()['responded'];
              ?>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-comments"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Feedback</span>
                      <span class="info-box-number"><?php echo $total; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Pending Response</span>
                      <span class="info-box-number"><?php echo $pending; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Responded</span>
                      <span class="info-box-number"><?php echo $responded; ?></span>
                    </div>
                  </div>
                </div>
              </div>
              
              <hr>
              
              <!-- Filter Tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab"><i class="fa fa-list"></i> All Feedback</a></li>
                <li role="presentation"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab"><i class="fa fa-clock-o"></i> Pending</a></li>
                <li role="presentation"><a href="#responded" aria-controls="responded" role="tab" data-toggle="tab"><i class="fa fa-check"></i> Responded</a></li>
              </ul>
              
              <div class="tab-content">
                <!-- All Feedback Tab -->
                <div role="tabpanel" class="tab-pane active" id="all">
                  <?php
                  $sql = "SELECT feedback.*, users.firstname, users.lastname, users.email 
                          FROM feedback 
                          INNER JOIN users ON feedback.id_user = users.id_user 
                          ORDER BY feedback.created_at DESC";
                  $result = $conn->query($sql);
                  
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $has_response = !empty($row['admin_response']);
                  ?>
                      <div class="box box-<?php echo $has_response ? 'success' : 'warning'; ?> box-solid">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                            <small>(<?php echo htmlspecialchars($row['email']); ?>)</small>
                          </h4>
                          <div class="box-tools pull-right">
                            <span class="label label-<?php echo $has_response ? 'success' : 'warning'; ?>">
                              <?php echo $has_response ? 'Responded' : 'Pending'; ?>
                            </span>
                            <a href="feedback.php?delete=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?');">
                              <i class="fa fa-trash"></i>
                            </a>
                          </div>
                        </div>
                        <div class="box-body">
                          <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                          <p><strong>Message:</strong></p>
                          <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                          <p class="text-muted"><small><i class="fa fa-calendar"></i> Submitted on: <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></small></p>
                          
                          <?php if ($has_response) { ?>
                            <hr>
                            <div class="alert alert-success">
                              <strong><i class="fa fa-reply"></i> Your Response:</strong><br>
                              <?php echo nl2br(htmlspecialchars($row['admin_response'])); ?>
                              <br><small class="text-muted">Responded on: <?php echo date('M d, Y h:i A', strtotime($row['response_date'])); ?></small>
                            </div>
                          <?php } ?>
                          
                          <!-- Response Form -->
                          <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#response-<?php echo $row['id']; ?>" aria-expanded="false">
                            <i class="fa fa-reply"></i> <?php echo $has_response ? 'Update Response' : 'Respond'; ?>
                          </button>
                          
                          <div class="collapse" id="response-<?php echo $row['id']; ?>" style="margin-top: 15px;">
                            <form method="post" action="feedback.php">
                              <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                              <div class="form-group">
                                <label>Your Response:</label>
                                <textarea class="form-control" name="admin_response" rows="4" required><?php echo $has_response ? htmlspecialchars($row['admin_response']) : ''; ?></textarea>
                              </div>
                              <button type="submit" name="respond" class="btn btn-success"><i class="fa fa-paper-plane"></i> Send Response</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  } else {
                    echo '<div class="alert alert-info" style="margin-top: 20px;">No feedback received yet.</div>';
                  }
                  ?>
                </div>
                
                <!-- Pending Tab -->
                <div role="tabpanel" class="tab-pane" id="pending">
                  <?php
                  $sql = "SELECT feedback.*, users.firstname, users.lastname, users.email 
                          FROM feedback 
                          INNER JOIN users ON feedback.id_user = users.id_user 
                          WHERE feedback.admin_response IS NULL OR feedback.admin_response = ''
                          ORDER BY feedback.created_at DESC";
                  $result = $conn->query($sql);
                  
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                  ?>
                      <div class="box box-warning box-solid">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                            <small>(<?php echo htmlspecialchars($row['email']); ?>)</small>
                          </h4>
                          <div class="box-tools pull-right">
                            <span class="label label-warning">Pending</span>
                            <a href="feedback.php?delete=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?');">
                              <i class="fa fa-trash"></i>
                            </a>
                          </div>
                        </div>
                        <div class="box-body">
                          <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                          <p><strong>Message:</strong></p>
                          <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                          <p class="text-muted"><small><i class="fa fa-calendar"></i> Submitted on: <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></small></p>
                          
                          <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#response-pending-<?php echo $row['id']; ?>" aria-expanded="false">
                            <i class="fa fa-reply"></i> Respond
                          </button>
                          
                          <div class="collapse" id="response-pending-<?php echo $row['id']; ?>" style="margin-top: 15px;">
                            <form method="post" action="feedback.php">
                              <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                              <div class="form-group">
                                <label>Your Response:</label>
                                <textarea class="form-control" name="admin_response" rows="4" required></textarea>
                              </div>
                              <button type="submit" name="respond" class="btn btn-success"><i class="fa fa-paper-plane"></i> Send Response</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  } else {
                    echo '<div class="alert alert-info" style="margin-top: 20px;">No pending feedback.</div>';
                  }
                  ?>
                </div>
                
                <!-- Responded Tab -->
                <div role="tabpanel" class="tab-pane" id="responded">
                  <?php
                  $sql = "SELECT feedback.*, users.firstname, users.lastname, users.email 
                          FROM feedback 
                          INNER JOIN users ON feedback.id_user = users.id_user 
                          WHERE feedback.admin_response IS NOT NULL AND feedback.admin_response != ''
                          ORDER BY feedback.response_date DESC";
                  $result = $conn->query($sql);
                  
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                  ?>
                      <div class="box box-success box-solid">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                            <small>(<?php echo htmlspecialchars($row['email']); ?>)</small>
                          </h4>
                          <div class="box-tools pull-right">
                            <span class="label label-success">Responded</span>
                            <a href="feedback.php?delete=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?');">
                              <i class="fa fa-trash"></i>
                            </a>
                          </div>
                        </div>
                        <div class="box-body">
                          <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                          <p><strong>Message:</strong></p>
                          <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                          <p class="text-muted"><small><i class="fa fa-calendar"></i> Submitted on: <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></small></p>
                          
                          <hr>
                          <div class="alert alert-success">
                            <strong><i class="fa fa-reply"></i> Your Response:</strong><br>
                            <?php echo nl2br(htmlspecialchars($row['admin_response'])); ?>
                            <br><small class="text-muted">Responded on: <?php echo date('M d, Y h:i A', strtotime($row['response_date'])); ?></small>
                          </div>
                          
                          <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#response-responded-<?php echo $row['id']; ?>" aria-expanded="false">
                            <i class="fa fa-edit"></i> Update Response
                          </button>
                          
                          <div class="collapse" id="response-responded-<?php echo $row['id']; ?>" style="margin-top: 15px;">
                            <form method="post" action="feedback.php">
                              <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                              <div class="form-group">
                                <label>Your Response:</label>
                                <textarea class="form-control" name="admin_response" rows="4" required><?php echo htmlspecialchars($row['admin_response']); ?></textarea>
                              </div>
                              <button type="submit" name="respond" class="btn btn-success"><i class="fa fa-paper-plane"></i> Update Response</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  } else {
                    echo '<div class="alert alert-info" style="margin-top: 20px;">No responded feedback yet.</div>';
                  }
                  ?>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer" style="margin-left: 0px;">
      <div class="text-center">
        <strong>Copyright &copy; 2022 <a href="learningfromscratch.online">Placement Portal</a>.</strong> All rights reserved.
      </div>
    </footer>

    <div class="control-sidebar-bg"></div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../js/adminlte.min.js"></script>
  <script src="../js/sweetalert.js"></script>
</body>

</html>

<?php
if (isset($_SESSION['response_success']) && $_SESSION['response_success'] != '') {
?>
  <script>
    swal({
      title: "<?php echo $_SESSION['response_success'] == 'success' ? 'Success!' : 'Error!'; ?>",
      text: "<?php echo $_SESSION['response_message']; ?>",
      icon: "<?php echo $_SESSION['response_success']; ?>",
      button: "Okay",
    });
  </script>
<?php
  unset($_SESSION['response_success']);
  unset($_SESSION['response_message']);
}
?>
