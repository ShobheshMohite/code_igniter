<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Information Application</title>
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.min'; ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>


<div class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="<?php echo base_url() . 'index.php/user/create/' ?>" class="navbar-brand">Customer Information
      App</a>
  </div>
</div>
<div class="container" style="padding-top : 10px;">
  <h3>Edit Customer Details</h3>

  <form method="post" name="createUser" action="<?php echo base_url() . 'index.php/user/edit/' . $user['user_id']; ?>"
    enctype="multipart/form-data">
    <div class="row">

      <div class="col-md-6">
        <hr>
        <div class="form-group">
          <label for="firstname">First Name</label>
          <input type="text" name="firstname" placeholder="Enter First Name"
            value="<?php echo set_value('firstname', $user['firstname']); ?>" class="form-control">

          <?php echo form_error('firstname'); ?>
        </div>

        <div class="form-group">
          <label for="lastname">Last Name</label>
          <input type="text" name="lastname" placeholder="Enter Last Name"
            value="<?php echo set_value('lastname', $user['lastname']); ?>" class="form-control">

          <?php echo form_error('lastname'); ?>


          <div class="form-group" style="padding-bottom: 10px">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter Email"
              value="<?php echo set_value('email', $user['email']); ?>" class="form-control">

            <?php echo form_error('email'); ?>
          </div>

          <!-- Gender -->
          <div class="form-group">
            <label for="gender">Gender</label><br>

            <input type="radio" name="gender" value="Male" <?php echo $user['gender'] == 'Male' ? 'checked' : ''; ?>>
            Male

            <input type="radio" name="gender" value="Female" <?php echo $user['gender'] == 'Female' ? 'checked' : ''; ?>>
            Female<br>
            <?php echo form_error('gender'); ?>
          </div>

          <!-- DOB-->
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" value="<?php echo set_value('dob', $user['dob']); ?>" class="form-control"
              max="<?php echo date('Y-m-d'); ?>">
            <?php echo form_error('dob'); ?>
          </div>

          <!-- Mobile Number -->
          <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" name="mobile" placeholder="Enter 10 Digit Mobile Number"
              value="<?php echo set_value('mobile', $user['mobile']); ?>" class="form-control" maxlength="10">
            <?php echo form_error('mobile'); ?>
          </div>

          <!-- State -->
          <div class="form-group">
            <label for="state">State</label>
            <select name="state" id="state" class="form-control">
              <option value="">Select State</option>
              <?php foreach ($states as $state): ?>
                <option value="<?php echo $state['id']; ?>" <?php echo set_select('state', $state['id'], $state['id'] == $user['state_id']); ?>>
                  <?php echo $state['name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php echo form_error('state'); ?>
          </div>

          <!-- City-->
          <div class="form-group" style="padding-bottom:10px">
            <label for="city">City</label>
            <select name="city" id="city" class="form-control">
              <option value="">Select City</option>
              <?php foreach ($cities as $city): ?>
                <option value="<?php echo $city['id']; ?>" <?php echo set_select('city', $city['id'], $city['id'] == $user['city_id']); ?>>
                  <?php echo $city['name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php echo form_error('city'); ?>
          </div>

          <!-- File Upload -->
          <div class="form-group" style="margin-bottom:10px">
            <label for="file">Upload File</label>
            <input type="file" name="file" value="<?php echo set_value('file', $user['profile_picture']); ?>"
              class="form-control">
            <?php echo form_error('file'); ?>
          </div>

          <div class="form-group">
            <button class="btn btn-primary">Update</button>
            <a href="<?php echo base_url() . 'index.php/user/index' ?>" class="btn-secondary btn">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {
    // Fetch cities
    $('#state').change(function () {
      const stateId = $(this).val();

      if (stateId) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/user/getCitiesByState/' + stateId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('#city').empty(); // Clear
            $('#city').append('<option value="">Select City</option>');

            // Populate the city dropdown
            $.each(data, function (key, city) {
              $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
            });
          },
          error: function () {
            alert('Error fetching cities. Please try again.');
          }
        });
      } else {
        $('#city').empty();
        $('#city').append('<option value="">Select City</option>');
      }
    });
  });
</script>


</body>

</html>