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
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Date of Birth</th>
              <th>Mobile</th>
              <th>State</th>
              <th>City</th>
              <th>Files</th>
              <th width="100">Edit</th>
              <th width="100">Delete</th>
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
                  <td><?php echo ucfirst($user['gender']); ?></td>
                  <td><?php echo $user['dob']; ?></td>
                  <td><?php echo $user['mobile']; ?></td>
                  <td><?php echo $user['state_name']; ?></td>
                  <td><?php echo $user['city_name']; ?></td>
                  <td><img src="<?php echo base_url('uploads/' . $user['profile_picture']); ?>" alt="Profile Picture"
                      style="width: 10px; height: 10px;">
                  </td>
                  <td>
                    <a href="<?php echo base_url() . 'index.php/user/edit/' . $user['user_id']; ?>"
                      class="btn btn-primary">Edit</a>
                  </td>
                  <td>
                    <a href="<?php echo base_url() . 'index.php/user/delete/' . $user['user_id']; ?>"
                      class="btn btn-danger">Delete</a>
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