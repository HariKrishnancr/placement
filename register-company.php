<?php
session_start();

if (isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
  header("Location: index.php");
  exit();
}

require_once("db.php");
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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">

  <?php
  include 'uploads/register_page_header.php';
  ?>
  <div class="wrapper">



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px;">

      <section class="content-header">
        <div class="container">
          <div class="row latest-job margin-top-50 margin-bottom-20 bg-white">
            <h3 class="text-center margin-bottom-20">Placement Cell Profile</h3>
            <form method="post" id="registerCompanies" action="addcompany.php" enctype="multipart/form-data">
              <div class="col-md-6 latest-job ">
                <div class="form-group">
                  <input class="form-control input-lg" type="text" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" name="companyname" placeholder="Designation">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" name="website" placeholder="Website">
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control input-lg" rows="4" name="aboutme" placeholder="Roles & Responsibility"></textarea>
                </div>
                <div class="form-group checkbox">
                  <label><input type="checkbox" required> I accept terms & conditions</label>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-flat btn-success">Register</button>
                </div>
                <?php
                //If Company already registered with this email then show error message.
                if (isset($_SESSION['registerError'])) {
                ?>
                  <div>
                    <p class="text-center" style="color: red;">Email Already Exists! Choose A Different Email!</p>
                  </div>
                <?php
                  unset($_SESSION['registerError']);
                }
                ?>
                <?php
                if (isset($_SESSION['uploadError'])) {
                ?>
                  <div>
                    <p class="text-center" style="color: red;"><?php echo $_SESSION['uploadError']; ?></p>
                  </div>
                <?php
                  unset($_SESSION['uploadError']);
                }
                ?>
              </div>
              <div class="col-md-6 latest-job ">
                <div class="form-group">
                  <input class="form-control input-lg" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="password" name="cpassword" placeholder="Confirm Password" required>
                </div>
                <div id="passwordError" class="btn btn-flat btn-danger hide-me">
                  Password Mismatch!!
                </div>
                <div class="form-group">
                  <input class="form-control input-lg" type="text" name="contactno" placeholder="Phone Number" minlength="10" maxlength="10" autocomplete="off" onkeypress="return validatePhone(event);" required>
                </div>
                <div class="form-group">
                  <select class="form-control  input-lg" id="country" name="country">
                    <option selected="" value="">Select Country</option>
                    <?php
                    $sql = "SELECT * FROM countries";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['name'] . "' data-id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                      }
                    }
                    ?>

                  </select>
                </div>
                <div id="stateDiv" class="form-group" style="display: none;">
                  <select class="form-control  input-lg" id="state" name="state">
                    <option value="" selected="">Select State</option>
                  </select>
                </div>
                <div id="cityDiv" class="form-group" style="display: none;">
                  <select class="form-control  input-lg" id="city" name="city">
                    <option selected="">Select City</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Upload your profile picture</label>
                  <input type="file" name="image" class="form-control input-lg">
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

    // Validate website URL
    function validateWebsite(url) {
      if (url === '') return true; // Optional field
      var urlPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+(\.[a-zA-Z]{2,})+(\/.*)?$/;
      return urlPattern.test(url);
    }

    // Validate image file
    function validateImage(input) {
      if (input.files.length === 0) return true; // Optional field
      var filePath = input.value;
      var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      if (!allowedExtensions.exec(filePath)) {
        return false;
      }
      return true;
    }
  </script>

  <script>
    $("#country").on("change", function() {
      var id = $(this).find(':selected').attr("data-id");
      $("#state").find('option:not(:first)').remove();
      if (id != '') {
        $.post("state.php", {
          id: id
        }).done(function(data) {
          $("#state").append(data);
        });
        $('#stateDiv').show();
      } else {
        $('#stateDiv').hide();
        $('#cityDiv').hide();
      }
    });
  </script>

  <script>
    $("#state").on("change", function() {
      var id = $(this).find(':selected').attr("data-id");
      $("#city").find('option:not(:first)').remove();
      if (id != '') {
        $.post("city.php", {
          id: id
        }).done(function(data) {
          $("#city").append(data);
        });
        $('#cityDiv').show();
      } else {
        $('#cityDiv').hide();
      }
    });
  </script>
  <script>
    // Real-time validation
    $(document).ready(function() {
      // Validate name
      $('input[name="name"]').on('blur', function() {
        var name = $(this).val().trim();
        if (name === '') {
          $(this).css('border-color', 'red');
          showError($(this), 'Full name is required');
        } else if (!validateName(name)) {
          $(this).css('border-color', 'red');
          showError($(this), 'Name should contain only letters');
        } else {
          $(this).css('border-color', 'green');
          hideError($(this));
        }
      });

      // Validate email
      $('input[name="email"]').on('blur', function() {
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

      // Validate password
      $('input[name="password"]').on('blur', function() {
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

      // Validate confirm password
      $('input[name="cpassword"]').on('blur', function() {
        var cpassword = $(this).val();
        var password = $('input[name="password"]').val();
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

      // Validate contact number
      $('input[name="contactno"]').on('blur', function() {
        var contactno = $(this).val().trim();
        if (contactno === '') {
          $(this).css('border-color', 'red');
          showError($(this), 'Phone number is required');
        } else if (contactno.length !== 10) {
          $(this).css('border-color', 'red');
          showError($(this), 'Phone number must be exactly 10 digits');
        } else {
          $(this).css('border-color', 'green');
          hideError($(this));
        }
      });

      // Validate website
      $('input[name="website"]').on('blur', function() {
        var website = $(this).val().trim();
        if (website !== '' && !validateWebsite(website)) {
          $(this).css('border-color', 'red');
          showError($(this), 'Please enter a valid website URL');
        } else if (website !== '') {
          $(this).css('border-color', 'green');
          hideError($(this));
        }
      });

      // Show error message
      function showError(element, message) {
        hideError(element);
        element.after('<span class="error-message" style="color: red; font-size: 12px;">' + message + '</span>');
      }

      // Hide error message
      function hideError(element) {
        element.next('.error-message').remove();
      }
    });

    $("#registerCompanies").on("submit", function(e) {
      e.preventDefault();
      $('#passwordError').hide();
      
      var isValid = true;
      var errorMessages = [];

      // Validate name
      var name = $('input[name="name"]').val().trim();
      if (name === '') {
        errorMessages.push('Full name is required');
        $('input[name="name"]').css('border-color', 'red');
        isValid = false;
      } else if (!validateName(name)) {
        errorMessages.push('Name should contain only letters');
        $('input[name="name"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate email
      var email = $('input[name="email"]').val().trim();
      if (email === '') {
        errorMessages.push('Email is required');
        $('input[name="email"]').css('border-color', 'red');
        isValid = false;
      } else if (!validateEmail(email)) {
        errorMessages.push('Please enter a valid email address');
        $('input[name="email"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate password
      var password = $('input[name="password"]').val();
      if (password === '') {
        errorMessages.push('Password is required');
        $('input[name="password"]').css('border-color', 'red');
        isValid = false;
      } else if (!validatePassword(password)) {
        errorMessages.push('Password must be at least 8 characters with uppercase, lowercase, number and special character');
        $('input[name="password"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate confirm password
      var cpassword = $('input[name="cpassword"]').val();
      if (password !== cpassword) {
        errorMessages.push('Passwords do not match');
        $('#passwordError').show();
        $('input[name="cpassword"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate contact number
      var contactno = $('input[name="contactno"]').val().trim();
      if (contactno === '') {
        errorMessages.push('Phone number is required');
        $('input[name="contactno"]').css('border-color', 'red');
        isValid = false;
      } else if (contactno.length !== 10) {
        errorMessages.push('Phone number must be exactly 10 digits');
        $('input[name="contactno"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate website
      var website = $('input[name="website"]').val().trim();
      if (website !== '' && !validateWebsite(website)) {
        errorMessages.push('Please enter a valid website URL');
        $('input[name="website"]').css('border-color', 'red');
        isValid = false;
      }

      // Validate image file
      var imageInput = $('input[name="image"]')[0];
      if (imageInput.files.length > 0 && !validateImage(imageInput)) {
        errorMessages.push('Profile picture must be an image file (jpg, jpeg, png, gif)');
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