<?php

session_start();

if (isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
  header("Location: index.php");
  exit();
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Placement Portal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="css/custom.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">

  <?php
  include 'uploads/register_page_header.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
    <div class=" content-wrapper" style="margin-left: 0px;">

      <section class="content-header">
        <div class="container">
          <div class="row latest-job margin-top-50 margin-bottom-20 bg-white">
            <h3 class="text-center margin-bottom-20">Create Your Profile</h3>
            <form method="post" id="registerCandidates" action="adduser.php" enctype="multipart/form-data">
              <div class="col-md-6 latest-job ">
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="fname" name="fname" placeholder="First Name *" required>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="lname" name="lname" placeholder="Last Name *" required>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="email" name="email" placeholder="Email *" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control input-lg" rows="4" id="aboutme" name="aboutme" placeholder="Brief intro about yourself *" required></textarea>
                </div>
                <div class="form-group">
                  <label>Date Of Birth</label>
                  <input class="form-control input-lg" type="date" id="dob" min="1960-01-01" max="2025-12-31" name="dob" placeholder="Date Of Birth">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="age" name="age" placeholder="Age" readonly>
                </div>
                <div class="form-group">
                  <label>Passing Year</label>
                  <input class="form-control input-lg" type="date" id="passingyear" name="passingyear" placeholder="Passing Year">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="qualification" name="qualification" placeholder="Highest Qualification">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="stream" name="stream" placeholder="Stream">
                </div>
                <div class="form-group checkbox">
                  <label><input type="checkbox"> I accept terms & conditions</label>
                </div>
                <div class="form-group">
                  <button class="btn btn-flat btn-success">Register</button>
                </div>
                <?php
                //If User already registered with this email then show error message.
                if (isset($_SESSION['registerError'])) {
                ?>
                  <div class="form-group">
                    <label style="color: red;">Email Already Exists! Choose A Different Email!</label>
                  </div>
                <?php
                  unset($_SESSION['registerError']);
                }
                ?>

                <?php if (isset($_SESSION['uploadError'])) { ?>
                  <div class="form-group">
                    <label style="color: red;"><?php echo $_SESSION['uploadError']; ?></label>
                  </div>
                <?php unset($_SESSION['uploadError']);
                } ?>

              </div>
              <div class="col-md-6 latest-job ">
                <div class="form-group">
                  <input class="form-control input-lg" type="password" id="password" name="password" placeholder="Password *" required>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="password" id="cpassword" name="cpassword" placeholder="Confirm Password *" required>
                </div>
                <div id="passwordError" class="btn btn-flat btn-danger hide-me">
                  Password Mismatch!!
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="contactno" name="contactno" minlength="10" maxlength="10" onkeypress="return validatePhone(event);" placeholder="Phone Number">
                </div>
                <div class="form-group">
                  <textarea class="form-control input-lg" rows="4" id="address" name="address" placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="city" name="city" placeholder="City">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="state" name="state" placeholder="State">
                </div>
                <div class="form-group">
                  <textarea class="form-control input-lg" rows="4" id="skills" name="skills" placeholder="Enter Skills"></textarea>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" id="designation" name="designation" placeholder="Designation">
                </div>

                <div class="form-group">
                  <label style="color: red;">File Format PDF Only!</label>
                  <input type="file" name="resume" class="btn btn-flat btn-danger" required>
                </div>
              </div>
            </form>

          </div>
        </div>
      </section>



    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer" style="margin-left: 0px;">
      <div class="text-center">
        <strong>Copyright &copy; 2022 <a href="learningfromscratch.online">Placement Portal</a>.</strong> All rights
        reserved.
      </div>
    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="js/adminlte.min.js"></script>

  <script type="text/javascript">
    function validatePhone(event) {

      //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
      //event.which will return key for mouse events and other events like ctrl alt etc. 
      var key = window.event ? event.keyCode : event.which;

      if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
        // 8 means Backspace
        //46 means Delete
        // 37 means left arrow
        // 39 means right arrow
        return true;
      } else if (key < 48 || key > 57) {
        // 48-57 is 0-9 numbers on your keyboard.
        return false;
      } else return true;
    }

    // Validate name (only letters and spaces)
    function validateName(name) {
      var namePattern = /^[a-zA-Z\s]+$/;
      return namePattern.test(name);
    }

    // Validate email format
    function validateEmail(email) {
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
    }

    // Validate password strength
    function validatePassword(password) {
      // At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
      var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
      return passwordPattern.test(password);
    }

    // Validate file type
    function validateFile(input) {
      var filePath = input.value;
      var allowedExtensions = /(\.pdf)$/i;
      if (!allowedExtensions.exec(filePath)) {
        return false;
      }
      return true;
    }
  </script>

  <script type="text/javascript">
    $('#dob').on('change', function() {
      var today = new Date();
      var birthDate = new Date($(this).val());
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();

      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }

      $('#age').val(age);
    });

    // Real-time validation for first name
    $('#fname').on('blur', function() {
      var fname = $(this).val().trim();
      if (fname === '') {
        $(this).css('border-color', 'red');
        showError($(this), 'First name is required');
      } else if (!validateName(fname)) {
        $(this).css('border-color', 'red');
        showError($(this), 'First name should contain only letters');
      } else {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Real-time validation for last name
    $('#lname').on('blur', function() {
      var lname = $(this).val().trim();
      if (lname === '') {
        $(this).css('border-color', 'red');
        showError($(this), 'Last name is required');
      } else if (!validateName(lname)) {
        $(this).css('border-color', 'red');
        showError($(this), 'Last name should contain only letters');
      } else {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Real-time validation for email
    $('#email').on('blur', function() {
      var email = $(this).val().trim();
      if (email === '') {
        $(this).css('border-color', 'red');
        showError($(this), 'Email is required');
      } else if (!validateEmail(email)) {
        $(this).css('border-color', 'red');
        showError($(this), 'Please enter a valid email address');
      } else {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Real-time validation for password
    $('#password').on('blur', function() {
      var password = $(this).val();
      if (password === '') {
        $(this).css('border-color', 'red');
        showError($(this), 'Password is required');
      } else if (!validatePassword(password)) {
        $(this).css('border-color', 'red');
        showError($(this), 'Password must be 8+ characters with uppercase, lowercase, number and special character');
      } else {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Real-time validation for confirm password
    $('#cpassword').on('blur', function() {
      var cpassword = $(this).val();
      var password = $('#password').val();
      if (cpassword === '') {
        $(this).css('border-color', 'red');
        showError($(this), 'Confirm password is required');
      } else if (cpassword !== password) {
        $(this).css('border-color', 'red');
        showError($(this), 'Passwords do not match');
      } else {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Real-time validation for contact number
    $('#contactno').on('blur', function() {
      var contactno = $(this).val().trim();
      if (contactno !== '' && contactno.length !== 10) {
        $(this).css('border-color', 'red');
        showError($(this), 'Phone number must be exactly 10 digits');
      } else if (contactno !== '') {
        $(this).css('border-color', 'green');
        hideError($(this));
      }
    });

    // Show error message
    function showError(element, message) {
      hideError(element); // Remove existing error first
      element.after('<span class="error-message" style="color: red; font-size: 12px;">' + message + '</span>');
    }

    // Hide error message
    function hideError(element) {
      element.next('.error-message').remove();
    }
  </script>
  <script>
    $("#registerCandidates").on("submit", function(e) {
      e.preventDefault();
      $('#passwordError').hide();
      
      var isValid = true;
      var errorMessages = [];

      // Validate first name
      var fname = $('#fname').val().trim();
      if (fname === '') {
        errorMessages.push('First name is required');
        $('#fname').css('border-color', 'red');
        isValid = false;
      } else if (!validateName(fname)) {
        errorMessages.push('First name should contain only letters');
        $('#fname').css('border-color', 'red');
        isValid = false;
      }

      // Validate last name
      var lname = $('#lname').val().trim();
      if (lname === '') {
        errorMessages.push('Last name is required');
        $('#lname').css('border-color', 'red');
        isValid = false;
      } else if (!validateName(lname)) {
        errorMessages.push('Last name should contain only letters');
        $('#lname').css('border-color', 'red');
        isValid = false;
      }

      // Validate email
      var email = $('#email').val().trim();
      if (email === '') {
        errorMessages.push('Email is required');
        $('#email').css('border-color', 'red');
        isValid = false;
      } else if (!validateEmail(email)) {
        errorMessages.push('Please enter a valid email address');
        $('#email').css('border-color', 'red');
        isValid = false;
      }

      // Validate password
      var password = $('#password').val();
      if (password === '') {
        errorMessages.push('Password is required');
        $('#password').css('border-color', 'red');
        isValid = false;
      } else if (!validatePassword(password)) {
        errorMessages.push('Password must be at least 8 characters with uppercase, lowercase, number and special character');
        $('#password').css('border-color', 'red');
        isValid = false;
      }

      // Validate confirm password
      var cpassword = $('#cpassword').val();
      if (password !== cpassword) {
        errorMessages.push('Passwords do not match');
        $('#passwordError').show();
        $('#cpassword').css('border-color', 'red');
        isValid = false;
      }

      // Validate contact number
      var contactno = $('#contactno').val().trim();
      if (contactno !== '' && contactno.length !== 10) {
        errorMessages.push('Phone number must be exactly 10 digits');
        $('#contactno').css('border-color', 'red');
        isValid = false;
      }

      // Validate about me
      var aboutme = $('#aboutme').val().trim();
      if (aboutme === '') {
        errorMessages.push('Brief intro is required');
        $('#aboutme').css('border-color', 'red');
        isValid = false;
      }

      // Validate resume file
      var resumeInput = $('input[name="resume"]')[0];
      if (resumeInput.files.length === 0) {
        errorMessages.push('Resume file is required');
        isValid = false;
      } else if (!validateFile(resumeInput)) {
        errorMessages.push('Resume must be a PDF file');
        isValid = false;
      }

      // Show validation errors
      if (!isValid) {
        alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
        return false;
      }

      // Submit form if all validations pass
      $(this).unbind('submit').submit();
    });
  </script>
</body>

</html>