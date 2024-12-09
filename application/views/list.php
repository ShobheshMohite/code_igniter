<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Information Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<div class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="<?php echo base_url() . 'index.php/user/' ?>" class="navbar-brand">Customer Information
      App</a>
  </div>
</div>
<div class="container" style="padding-top: 10px;">
  <div class="row">
    <div class="col-md-12">
      <?php
      $fileError = $this->session->flashdata('fileError');
      if ($fileError) {
        ?>
            <div class="alert alert-danger"><?php echo $fileError; ?></div>
          <?php
      }
      ?>
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
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createdata">Create</button>

        </div>
      </div>
    </div>
  </div>
  <hr class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped">
        <thead>
          <tr style="font-size: 15px;">
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
            $cnt = (int) $page + 1;
            foreach ($users as $user) { ?>
              <tr>
                <td class="user_id"><?php echo $cnt++; ?></td>
                <td><?php echo $user['firstname']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['gender']; ?></td>
                <td><?php echo $user['dob']; ?></td>
                <td><?php echo $user['mobile']; ?></td>
                <td><?php echo $user['state_name']; ?></td>
                <td><?php echo $user['city_name']; ?></td>
                <td><img src="<?php echo base_url('uploads/' . $user['profile_picture']); ?>" alt="Profile Picture"
                    style="width: 50px; height: 50px;" class="rounded">
                </td>
                <td>
                  <div class="d-flex">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editdata" class="btn btn-primary me-1"
                      onclick="getUserData(<?php echo $user['user_id']; ?>)">Edit</button>


                    <button type="button" data-bs-toggle="modal" data-bs-target="#deletedata" class="btn btn-danger me-1"
                      onclick="getUserData(<?php echo $user['user_id']; ?>)">Delete</button>

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
      <?php echo $pagination_links; ?>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deletedata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="deletedataLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletedataLabel">Are You Sure ? Click Delete Button To
          Confirm.</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <form method="post"  name="deleteUser"
          action="<?php echo base_url() . 'index.php/user/delete/' . $user['user_id']; ?>"
          enctype="multipart/form-data">
          <div class="row">

            <div class="form-group text-end">
              <button type="submit" class="btn btn-danger">Delete</button>
              <button type="button" data-bs-dismiss="modal" class="btn-secondary btn">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editdata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="editdataLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="editdataLabel">Update User Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="formId" name="createUser" action="<?php echo base_url() . 'index.php/user/' ?>"
          enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!--     -->
              <div class="form-group">
                <label for="firstname">First Name*</label>
                <input type="text" name="firstname" id="firstnameEdit" placeholder="Enter First Name" value=""
                  class="form-control" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label for="lastname">Last Name*</label>
                <input type="text" name="lastname" id="lastnameEdit" placeholder="Enter Last Name" value=""
                  class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-group" style="padding-bottom: 10px">
                <label for="email">Email*</label>
                <input type="email" name="email" id="emailEdit" placeholder="Enter Email" value="" class="form-control"
                  required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- Gender -->
              <div class="form-group">
                <label for="gender">Gender*</label><br>

                <input type="radio" name="gender" id="maleEdit" value="Male" required>
                Male

                <input type="radio" name="gender" id="femalEdit" value="Female" required>
                Female<br>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- DOB-->
              <div class="form-group">
                <label for="dob">Date of Birth*</label>
                <input type="date" name="dob" id="dobEdit" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- Mobile Number -->
              <div class="form-group">
                <label for="mobile">Mobile Number*</label>
                <input type="text" name="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                  id="mobileEdit" placeholder="Enter 10 Digit Mobile Number" value="" class="form-control"
                  maxlength="10" required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- State -->
              <div class="form-group">
                <label for="state">State*</label>
                <select name="state" id="stateEdit" class="form-select" onchange="getCitiesEdit()">
                  <option value="">Select State</option>
                  <?php foreach ($states as $state): ?>
                        <option value="<?php echo $state['id']; ?>" <?php echo $state['id'] == $user['state_id'] ? 'selected' : ''; ?>>
                      <?php echo $state['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- City-->
              <div class="form-group" style="padding-bottom:10px">
                <label for="city">City*</label>
                <select name="city" id="cityEdit" class="form-select">
                  <option value="">Select City</option>
                  <?php foreach ($cities as $city): ?>
                        <!-- <?php if ($city['state_id'] == $user['state_id']): ?> -->
                      <option value="<?php echo $city['id']; ?>" <?php echo $city['id'] == $user['city_id'] ? 'selected' : ''; ?>>
                        <?php echo $city['name']; ?>
                      </option>
                      <!-- <?php endif; ?> -->
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <!-- File Upload -->
              <div class="form-group" style="margin-bottom:10px">
                <label for="file">Upload File*</label>
                <input type="file" name="file" id="file" value="" class="form-control">
                <img src="" id="showImageEdit" style="width:150px">
              </div>
            </div>
            <div class="form-group text-end">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" data-bs-dismiss="modal" class="btn-danger btn">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Create Modal -->
<div class="modal fade" id="createdata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="createdataLabel" aria-hidden="true">
  <div class="modal-dialog  modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createdataLabel">Create New Entry</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url() . 'index.php/user/create'; ?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6 mb-3">
              <!--     -->
              <div class="form-group">
                <label for="firstname">First Name*</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" value=""
                  class="form-control" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label for="lastname">Last Name*</label>
                <input type="text" name="lastname" placeholder="Enter Last Name" value="" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-group" style="padding-bottom: 10px">
                <label for="email">Email*</label>
                <input type="email" name="email" placeholder="Enter Email" value="" class="form-control" required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- Gender -->
              <div class="form-group">
                <label for="gender">Gender*</label><br>

                <input type="radio" name="gender" id="male" value="Male" required>
                Male

                <input type="radio" name="gender" id="female" value="Female" required>
                Female<br>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- DOB-->
              <div class="form-group">
                <label for="dob">Date of Birth*</label>
                <input type="date" name="dob" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- Mobile Number -->
              <div class="form-group">
                <label for="mobile">Mobile Number*</label>
                <input type="text" name="mobile" pattern="[1-9]{1}[0-9]{9}"
                  oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter 10 Digit Mobile Number"
                  value="" class="form-control" maxlength="10" required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- State -->
              <div class="form-group-">
                <label for="state">State*</label>
                <select name="state" id="state" class="form-select" onchange="getCities()">
                  <option value="" selected>Select State</option>
                  <?php foreach ($states as $state): ?>

                    <option value="<?php echo $state['id']; ?>">
                      <?php echo $state['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select required>

              </div>
            </div>
            <div class="col-md-6 mb-3">
              <!-- City-->
              <div class="form-group" style="padding-bottom:10px">
                <label for="city">City*</label>
                <select name="city" id="city" class="form-select" disabled>
                  <option value="" selected>Select City</option>
                  <?php foreach ($cities as $city): ?>
                    <option value="<?php echo $city['id']; ?>">
                      <?php echo $city['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <!-- File Upload -->
              <div class="form-group" style="margin-bottom:10px">
                <label for="file">Upload File*</label>
                <input type="file" name="file" value="" class="form-control" required>

              </div>
            </div>
            <div class="form-group text-end">
              <button type="submit" class="btn btn-primary">Create</button>
              <button type="button" data-bs-dismiss="modal" class="btn-danger btn">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Dropdown Elements
    const stateDropDown = document.getElementById("state");
    const cityDropDown = document.getElementById("city");
    const stateEditDropDown = document.getElementById("stateEdit");
    const cityEditDropDown = document.getElementById("cityEdit");

    // Enable/Disable City Dropdown Based on State Selection
    const toggleCityDropdown = (stateElement, cityElement) => {
      if (stateElement.value) {
        cityElement.disabled = false;
      } else {
        cityElement.disabled = true;
        cityElement.innerHTML = '<option value="">Select City</option>'; // Clear cities
      }
    };

    // Event Listener for State Dropdown (Create User)
    if (stateDropDown && cityDropDown) {
      stateDropDown.addEventListener("change", function () {
        toggleCityDropdown(stateDropDown, cityDropDown);
        getCities();
      });
    }

    // Event Listener for State Dropdown (Edit User)
    if (stateEditDropDown && cityEditDropDown) {
      stateEditDropDown.addEventListener("change", function () {
        toggleCityDropdown(stateEditDropDown, cityEditDropDown);
        getCitiesEdit();
      });
    }

    // Fetch Cities Based on State Selection
    function getCities() {
      const stateId = stateDropDown.value;
      if (stateId) {
        $.ajax({
          url: "<?php echo base_url() ?>index.php/user/getCitiesByState/" + stateId,
          success: function (data) {
            const cities = JSON.parse(data);
            cityDropDown.innerHTML = '<option value="">Select City</option>'; // Clear old options
            cities.forEach((city) => {
              cityDropDown.innerHTML += `<option value="${city.id}">${city.name}</option>`;
            });
          },
          error: function () {
            alert("Unable to fetch cities. Please try again.");
          },
        });
      }
    }

    function getCitiesEdit() {
      const stateId = stateEditDropDown.value;
      if (stateId) {
        $.ajax({
          url: "<?php echo base_url() ?>index.php/user/getCitiesByState/" + stateId,
          success: function (data) {
            const cities = JSON.parse(data);
            cityEditDropDown.innerHTML = '<option value="">Select City</option>'; // Clear old options
            cities.forEach((city) => {
              cityEditDropDown.innerHTML += `<option value="${city.id}">${city.name}</option>`;
            });
          },
          error: function () {
            alert("Unable to fetch cities. Please try again.");
          },
        });
      }
    }

    // Populate Edit Modal with User Data
    window.getUserData = function (userId) {
      $.ajax({
        url: "<?php echo base_url() ?>index.php/user/getUserData/" + userId,
        success: function (data) {
          const user = JSON.parse(data);

          // Populate Form Fields
          $("#firstnameEdit").val(user.firstname);
          $("#lastnameEdit").val(user.lastname);
          $("#emailEdit").val(user.email);
          $("#dobEdit").val(user.dob);
          $("#mobileEdit").val(user.mobile);
          $("#stateEdit").val(user.state_id);

          let male = document.getElementById('maleEdit');
          let female = document.getElementById('femaleEdit');

          //gender
          if (user.gender == "Male") {
            male.checked = true;
          } else if (user.gender == "Female") {
            female.checked = true;
          }

          // Set Profile Picture
          let img = document.getElementById("showImageEdit");
          img.src = user.profile_picture
            ? "<?php echo base_url(); ?>uploads/" + user.profile_picture
            : "";

          // Update Form Action
          $("#formId").attr("action", "edit/" + userId);

          // Fetch Cities for the Selected State
          getCitiesEdit();

          // Preselect the User's City Once Loaded
          setTimeout(() => {
            $("#cityEdit").val(user.city_id);
          }, 100); // delay
        },
        error: function () {
          alert("Unable to fetch user data. Please try again.");
        },
      });
    };
  });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- <script>



  // create Dropdown

  document.addEventListener("DOMContentLoaded", function (params) {
    const stateDropDown = document.getElementById("state");
    const cityDropDown = document.getElementById("city");

    stateDropDown.addEventListener("change", function (params) {
      const selectedState = this.value;

      //enable states on cond.
      if (selectedState) {
        cityDropDown.disabled = false;
      } else {
        cityDropDown.disabled = true;
      }
    })
  })

  // Edit Dropdown
  document.addEventListener("DOMContentLoaded", function (params) {
    const stateDropDown = document.getElementById("stateEdit");
    const cityDropDown = document.getElementById("cityEdit");

    stateDropDown.addEventListener("change", function (params) {
      const selectedState = this.value;

      //enable states on cond.
      if (selectedState) {
        cityDropDown.disabled = false;
      } else {
        cityDropDown.disabled = true;
      }
    })
  })

  function getCities() {
    const stateId = document.getElementById('state').value; // Get the selected state ID
    console.log(stateId);

    $.ajax({
      url: "<?php echo base_url() ?>index.php/user/getCitiesByState/" + stateId,
      success: function (data) {
        let obj = jQuery.parseJSON(data);
        console.log(obj);

        let city = document.getElementById('city');
        city.innerHTML = '';

        obj.forEach(element => {
          city.innerHTML += '<option value="' + element.id + '">' + element.name + '</option>';
        });
      }
    })

  }

  // function getCitiesEdit() {
  //   const stateId = document.getElementById('stateEdit').value; // Get the selected state ID
  //   console.log(stateId);

  //   $.ajax({
  //     url: "<?php echo base_url() ?>index.php/user/getCitiesByState/" + stateId,
  // success: function (data) {
  // let obj = jQuery.parseJSON(data);
  // console.log(obj);
  
  // let city = document.getElementById('cityEdit');
  // city.innerHTML = '';
  
  // obj.forEach(element => {
  // city.innerHTML += '<option value="' + element.id + '">' + element.name + '</option>';
  // });
  // }
  // })
  
  // }

  function getCitiesEdit() {
    const stateId = document.getElementById("stateEdit").value; // Get selected state ID

    if (stateId) {
        // Make AJAX request to get cities for the selected state
        $.ajax({
            url: "<?php echo base_url('index.php/user/getCitiesByState'); ?>", // Adjust your URL as needed
            type: "POST",
            data: { state_id: stateId },
            dataType: "json",
            success: function (cities) {
            // Clear the city dropdown
            const citySelect = document.getElementById("cityEdit");
            citySelect.innerHTML = '<option value="">Select City</option>';

                // Populate the city dropdown with the new cities
                cities.forEach(function (city) {
                    const option = document.createElement("option");
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            },
            error: function () {
                alert("Unable to fetch cities. Please try again.");
            },
        });
    } else {
        // If no state is selected, clear the city dropdown
        document.getElementById("cityEdit").innerHTML = '<option value="">Select City</option>';
    }
}


  function getUserData(userId) {
    $.ajax({
      url: "<?php echo base_url() ?>index.php/user/getUserData/" + userId,
      success: function (data) {
        let obj = jQuery.parseJSON(data);

        console.log(obj);


        let male = document.getElementById('maleEdit');
        let female = document.getElementById('femaleEdit');

        //gender
        if (obj.gender == "Male") {
          male.checked = true;
        } else if (obj.gender == "Female") {
          female.checked = true;
        }


        $("#firstnameEdit").val(obj.firstname);
        $("#lastnameEdit").val(obj.lastname);
        $("#emailEdit").val(obj.email);
        $('#dobEdit').val(obj.dob);
        $('#mobileEdit').val(obj.mobile);
        $('#stateEdit').val(obj.state_id);
        $('#cityEdit').val(obj.city_id);

        $('#formId').attr('action', 'edit/' + userId);
        $('#deleteID').attr('action', 'delete/' + userId);

        let img = document.getElementById('showImageEdit');
        img.src = '';
        if (obj.profile_picture != null) {
          img.src = "<?php echo base_url(); ?>uploads/" + obj.profile_picture
        }
        // profile_picture

      }
    });
  }

</script> -->