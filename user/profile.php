<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter profile.php in URL.
if(empty($_SESSION['id_user'])) {
  header("Location: ../index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Job Portal</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />


      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <!-- NAVIGATION BAR -->
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.php">Job Portal</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">     
            <ul class="nav navbar-nav navbar-right">
              <li><a href="profile.php">Profile</a></li>
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>

    <section>
      <div class="container">
        <div class="row">
          <h2 class="text-center">Profile</h2>
          <form method="post" action="updateprofile.php">
          <?php
            //Sql to get logged in user details.
            $sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
            $result = $conn->query($sql);

            //If user exists then show his details.
            //Todo: Create Seprate Page For Password Change.
            if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
            ?>
          <div class="col-md-4 well">      
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo $row['firstname']; ?>" required="">
              </div>
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $row['lastname']; ?>" required="">
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
              </div>
          </div>
          <div class="col-md-4 well">
            <div class="form-group">
              <label for="address">Address</label>
              <textarea id="address" name="address" class="form-control" rows="5" placeholder="Address"><?php echo $row['address']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" value="<?php echo $row['city']; ?>" placeholder="city">
            </div>
            <div class="form-group">
              <label for="state">State</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="state" value="<?php echo $row['state']; ?>">
            </div>
          </div>
          <div class="col-md-4 well">
            <div class="form-group">
                <label for="contactno">Contact Number</label>
                <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Contact Number" value="<?php echo $row['contactno']; ?>">
              </div>
              <div class="form-group">
                <label for="qualification">Highest Qualification</label>
                <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Highest Qualification" value="<?php echo $row['qualification']; ?>">
              </div>
              <div class="form-group">
                <label for="stream">Stream</label>
                <input type="text" class="form-control" id="stream" name="stream" placeholder="stream" value="<?php echo $row['stream']; ?>">
              </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-md-offset-4 well">
              <div class="form-group">
                <label for="passingyear">Passing Year</label>
                <input type="date" class="form-control" id="passingyear" name="passingyear" placeholder="Passing Year" value="<?php echo $row['passingyear']; ?>">
              </div>
              <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" min="1960-01-01" max="2005-01-31" value="<?php echo $row['dob']; ?>">
              </div>
              <div class="form-group">
                <label for="age">Age</label>
                <input type="text" class="form-control" id="age" name="age" placeholder="Age" value="<?php echo $row['age']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="<?php echo $row['designation']; ?>">
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
                  <?php
              }
            }
          ?>
          </form>


          <div class="row">
              <div class="col-md-12 well">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-md-10">
                              <h3 class="panel-title"></h3>
                          </div>
                          <div class="col-md-2" align="right">
                              <button type="button" name="add" id="addExp" class="btn btn-success">Add Experience</button>
                          </div>
                      </div>
                  </div>
                  <table id="expList" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                          <th>Designation</th>
                          <th>Org.Name</th>
                          <th>Description</th>
                          <th>From</th>
                          <th>To</th>
                          <th></th>
                          <th></th>
                      </tr>
                      </thead>
                  </table>
              </div>
          </div>
          <div class="row">
                  <div class="col-md-12 well">
                      <div class="panel-heading">
                          <div class="row">
                              <div class="col-md-10">
                                  <h3 class="panel-title"></h3>
                              </div>
                              <div class="col-md-2" align="right">
                                  <button type="button" name="add" id="addEdu" class="btn btn-success">Add Education</button>
                              </div>
                          </div>
                      </div>
                      <table id="eduList" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                              <th>Degree</th>
                              <th>Institute</th>
                              <th>From</th>
                              <th>To</th>
                              <th>Obtained Marks</th>
                              <th>Total Marks</th>
                              <th></th>
                              <th></th>
                          </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          <div class="row">
              <div class="col-md-12 well">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-md-10">
                              <h3 class="panel-title"></h3>
                          </div>
                          <div class="col-md-2" align="right">
                              <button type="button" name="add" id="addCer" class="btn btn-success">Add Certificate</button>
                          </div>
                      </div>
                  </div>
                  <table id="cerList" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                          <th>Certificate</th>
                          <th>Date</th>
                          <th>Description</th>
                          <th></th>
                          <th></th>
                      </tr>
                      </thead>
                  </table>
              </div>
          </div>



            <div id="expModal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="expForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"
                                <label for="designation1" class="control-label">Designation</label>
                                <input type="text" class="form-control" id="designation1" name="designation" placeholder="Designation">
                            </div>
                            <div class="form-group">
                                <label for="org_name" class="control-label">Org. Name</label>
                                <input type="text" class="form-control"  id="org_name" name="org_name" placeholder="Org. Name">
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">Description</label>
                                <input type="textarea" class="form-control"  id="description" name="description" required>
                            </div>
                            <div class="form-group">
                                <label for="from_date" class="control-label">From</label>
                                <input type="date" class="form-control"  id="from_date" name="from_date" required>
                            </div>
                            <div class="form-group">
                                <label for="to_date" class="control-label">To</label>
                                <input type="date" class="form-control"  id="to_date" name="to_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="expId" id="expId" />
                            <input type="hidden" name="action" id="action" value="" />
                            <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div></div>
            <div id="eduModal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="eduForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"
                                <label for="degree" class="control-label">Degree</label>
                                <input type="text" class="form-control" id="degree" name="degree" placeholder="Degree">
                            </div>
                            <div class="form-group">
                                <label for="institute" class="control-label">Institute</label>
                                <input type="text" class="form-control"  id="institute" name="institute" placeholder="Institute">
                            </div>

                            <div class="form-group">
                                <label for="from_date" class="control-label">From</label>
                                <input type="date" class="form-control"  id="from_date_edu" name="from_date" required>
                            </div>
                            <div class="form-group">
                                <label for="to_date" class="control-label">To</label>
                                <input type="date" class="form-control"  id="to_date_edu" name="to_date" required>
                            </div>
                            <div class="form-group">
                                <label for="obtained_marks" class="control-label">Obtained Marks</label>
                                <input type="text" class="form-control"  id="obtained_marks" name="obtained_marks" required>
                            </div>
                            <div class="form-group">
                                <label for="total_marks" class="control-label">Total Marks</label>
                                <input type="text" class="form-control"  id="total_marks" name="total_marks" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="eduId" id="eduId" />
                            <input type="hidden" name="action" id="actionEdu" value="" />
                            <input type="submit" name="saveEdu" id="saveEdu" class="btn btn-info" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div></div>
            <div id="cerModal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="cerForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"
                                <label for="certificate" class="control-label">Certificate</label>
                                <input type="text" class="form-control" id="certificate" name="certificate" placeholder="Certificate">
                            </div>
                            <div class="form-group">
                                <label for="cer_description" class="control-label">Description</label>
                                <input type="text" class="form-control"  id="cer_description" name="description" placeholder="Description">
                            </div>
                            <div class="form-group">
                                <label for="certification_date" class="control-label">Certification Date</label>
                                <input type="date" class="form-control"  id="certification_date" name="certification_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="cerId" id="cerId" />
                            <input type="hidden" name="action" id="actionCer" value="" />
                            <input type="submit" name="saveCer" id="saveCer" class="btn btn-info" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div></div>



          </div>
      </div>
    </section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--    <!-- Include all compiled plugins (below), or include individual files as needed -->-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>

    <script src="js/ajax.js"></script>


    <script type="text/javascript">
      $('#dob').on('change', function() {
        var today = new Date();
        var birthDate = new Date($(this).val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();

        if(m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }

        $('#age').val(age);
      });
    </script>
  </body>
</html>