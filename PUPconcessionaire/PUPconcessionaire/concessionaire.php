
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta content="noindex, nofollow" name="robots">
<meta content="PUP Portal" name="Description" />
<meta content="PUP Portal" name="abstract" />
<meta content="PUP" name="author" />
<meta content="Polytechnic University of the Philippines" name="copyright" />
<meta content="Higher Education" name="category" />
<meta content="" name="timestamp" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>PUP - Concessionaire Management System (Beta)</title>
<link href="https://cdn.pup.edu.ph/img/ico/favicon.ico" rel="icon" type="image/x-icon" />
<link href="https://cdn.pup.edu.ph/frameworks/adminlte3.0.5/dist/css/adminlte.min.css" rel="stylesheet" />
<link href="https://cdn.pup.edu.ph/css/si.css" rel="stylesheet" />
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
<script src="https://kit.fontawesome.com/044ae73695.js" crossorigin="anonymous"></script>
</head>

<body class="sidebar-collapse fixed">

<div class="wrapper">
  <div class="content-wrapper">
    <div id="bgslider" class="bgslider">
      <div class="col-md-4 card frost">
        <div class="toplayer login-card-body">
          <div class="box-header with-border">
            <div class="text-center mb-2">
              <img alt="PUP" class="img-circle" src="https://cdn.pup.edu.ph/img/symbols/logo88x88.png" /></div>
            <h2 class="box-title text-center"><strong>PUP</strong> Concessionaire Management System <sup class="text-sm font-weight-lighter">&beta;eta</sup></h2>
          </div>

         <div class="box-body login-box-msg">
            <section id="introduction">
              <p><i class="fas fa-arrow-down"></i>&nbsp;Please click or tap the appropriate button.</p>
            </section>
            <div class="row">
              <div class="col-12">
                
              <div >
                <form method="post" action="userlogin.php">
                    <button class="btn btn-lg btn-danger  btn-block bg-danger" class="userbutton" type="submit" name="user_login_btn">Client</button>
                </form>

                <form method="post" action="studentlogin.php">
                    <button style="margin-top: 16px;" class="btn btn-lg btn-warning  btn-block bg-warning" class="userbutton" type="submit" name="student_login_btn">Student</button>
                </form>
                <!-- <a href="/appointment/Authentication/Student/" class="btn btn-lg btn-info  btn-block bg-primary">ODRS<br><small>(Claiming Request in OUR,OUS)</small></a> -->
                  <form method="post" action="adminlogin.php">
                      <button style="margin-top: 16px;" class="btn btn-lg btn-info  btn-block bg-info" class="submitbutton" type="submit" name="admin_login_btn">Admin</button>
                  </form>

              </div>
            </div>
            <p>By using this service, you understood and agree to the PUP Online Services <a class="text-primary" href="https://www.pup.edu.ph/terms" target="_blank">Terms of Use</a> and <a class="text-primary" href="https://www.pup.edu.ph/privacy" target="_blank">Privacy Statement</a> </p>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.pup.edu.ph/frameworks/adminlte3.0.5/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.pup.edu.ph/frameworks/adminlte3.0.5/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://apps.pup.edu.ph/appointment/assets/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="https://cdn.pup.edu.ph/frameworks/adminlte3.0.5/dist/js/adminlte.min.js"></script>
<script src="https://cdn.pup.edu.ph/js/si.js"></script>

</body>
</html>
