<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Information Application</title>
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.min.css'; ?>">
</head>

<body>
  <div class="navbar navbar-dark bg-dark">
    <div class="container">
      <a href="<?php echo base_url() . 'index.php/user/create/' ?>" class="navbar-brand">Customer Information
        App</a>
    </div>
  </div>
  <div class="container" style="padding-top: 10px;">
    <div class="row">
      <div class="col-md-12">
        <!-- Flash messages for success and failure -->
        <?php
        $success = $this->session->flashdata('success');
        if ($success) {
          ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
          <?php
        }
        ?>
        <?php
        $success = $this->session->flashdata('success_delete');
        if ($success) {
          ?>
          <div class="alert alert-danger"><?php echo $success; ?></div>
          <?php
        }
        ?>
        <?php
        $failure = $this->session->flashdata('failure');
        if ($failure != "") {
          ?>
          <div class="alert alert-danger"><?php echo $failure; ?></div>
          <?php
        }
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-6">
            <h3>All Users Details</h3>
          </div>
          <div class="col-6 text-end">
            <a href="<?php echo base_url() . 'index.php/user/create'; ?>" class="btn btn-primary">Create</a>
          </div>
        </div>
      </div>
    </div>
    <hr class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr style="font-size: 17px;">              
              <div>
              <th>ID</th>
              <th>FIRST NAME</th>
              <th>LAST NAME</th>
              <th>EMAIL</th>
              <th>GENDER</th>
              <th>DATE OF BIRTH</th>
              <th>MOBILE</th>
              <th>STATE</th>
              <th>CITY</th>
              <th>FILES</th>
              
              <th width="100" class="text-center">ACTIONS</th>
              </div>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users)) {
              foreach ($users as $user) { ?>
                <tr>
                  <td><?php echo $user['user_id']; ?></td>
                  <td><?php echo $user['firstname']; ?></td>
                  <td><?php echo $user['lastname']; ?></td>
                  <td><?php echo $user['email']; ?></td>
                  <td><?php echo $user['gender']; ?></td>
                  <td><?php echo $user['dob']; ?></td>
                  <td><?php echo $user['mobile']; ?></td>
                  <td><?php echo $user['state_name']; ?></td>
                  <td><?php echo $user['city_name']; ?></td>
                  <td><img src="<?php echo base_url('./uploads/' . $user['profile_picture']); ?>" alt="Profile Picture"
                      style="width: 50px; height: 50px;">
                  </td>
                  <td>
                    <div class="d-flex">
                    <a href="<?php echo base_url() . 'index.php/user/edit/' . $user['user_id']; ?>"
                      class="btn btn-primary me-1">Edit</a>
                  
                    <a href="<?php echo base_url() . 'index.php/user/delete/' . $user['user_id']; ?>"
                      class="btn btn-danger">Delete</a>
                      </div>
                  </td>
                </tr>
              <?php }
            } else { ?>
              <tr>
                <td colspan="11" class="text-center">No Records Found</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>