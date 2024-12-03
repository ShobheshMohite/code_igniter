<?php
class User extends CI_Controller
{
  public function index()
  {
    $this->load->model("User_model");
    $users = $this->User_model->all();
    $data = array();
    $data['users'] = $users;
    $this->load->view('list', $data);
  }

  public function create()
  {
    $this->load->model("User_model");
    $data['states'] = $this->User_model->getStates(); // Fetch states for the dropdown

    $this->form_validation->set_rules("firstname", "First Name", "required");
    $this->form_validation->set_rules("lastname", "Last Name", "required");
    $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
    $this->form_validation->set_rules("gender", "Gender", "required");
    $this->form_validation->set_rules("dob", "Date of Birth", "required");
    $this->form_validation->set_rules("mobile", "Mobile Number", 'required|regex_match[/^[0-9]{10}$/]');
    $this->form_validation->set_rules("state", "State", "required");
    $this->form_validation->set_rules("city", "City", "required");

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('create', $data);
    } else {
      if (!empty($_FILES['file']['name'])) {
        $name_array = '';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['max_size'] = '1000';
        $config['max_width'] = '1280';
        $config['max_height'] = '1280';
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file'))
          $this->upload->display_errors();
        else {
          $fInfo = $this->upload->data(); //uploading
          $this->gallery_path = realpath(APPPATH . '../uploads');//fetching path
          $config1 = array(
            'source_image' => $fInfo['full_path'], //get original image
            'new_image' => $this->gallery_path . '/thumb', //save as new image //need to create thumbs first
            'maintain_ratio' => true,
            'width' => 250,
            'height' => 250

          );
          $this->load->library('image_lib', $config1); //load library
          $this->image_lib->resize(); //generating thumb
          $file_name = $fInfo['file_name'];// we will get image name here
        }
      }
      // Save user to database
      $formArray = array();
      $formArray['firstname'] = $this->input->post('firstname');
      $formArray['lastname'] = $this->input->post('lastname');
      $formArray['email'] = $this->input->post('email');
      $formArray['gender'] = $this->input->post('gender');
      $formArray['dob'] = $this->input->post('dob');
      $formArray['mobile'] = $this->input->post('mobile');
      $formArray['state_id'] = $this->input->post('state');
      $formArray['city_id'] = $this->input->post('city');
      $formArray['profile_picture'] = $file_name;

      // Save user data to database
      $this->User_model->create($formArray);

      $this->session->set_flashdata('success', 'Record Added Successfully');
      redirect(base_url() . 'index.php/user/index');
    }
  }



  public function edit($userId)
  {
    $this->load->model('User_model');
    $user = $this->User_model->getUser($userId);
    $data = array();
    $data['user'] = $user;
    $data['states'] = $this->User_model->getStates(); // Fetch states for the dropdown
    $data['cities'] = $this->User_model->getCitiesByState($user['state_id']); // Fetch cities

    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required');
    $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
    $this->form_validation->set_rules("gender", "Gender", "required");
    $this->form_validation->set_rules("dob", "Date of Birth", "required");
    $this->form_validation->set_rules("mobile", "Mobile Number", 'required|regex_match[/^[0-9]{10}$/]');
    $this->form_validation->set_rules("state", "State", "required");
    $this->form_validation->set_rules("city", "City", "required");

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('edit', $data);
    } else {
      // Update user in database
      $formArray = array();
      $formArray['firstname'] = $this->input->post('firstname');
      $formArray['lastname'] = $this->input->post('lastname');
      $formArray['email'] = $this->input->post('email');
      $formArray['gender'] = $this->input->post('gender');
      $formArray['dob'] = $this->input->post('dob');
      $formArray['mobile'] = $this->input->post('mobile');
      $formArray['state_id'] = $this->input->post('state'); // Update state ID
      $formArray['city_id'] = $this->input->post('city');   // Update city ID


      //check if new file 
      if (!empty($_FILES['file']['name'])) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['max_size'] = '1000';
        $config['max_width'] = '1280';
        $config['max_height'] = '1280';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
          $error = $this->upload->upload_errors();
          $this->session->set_flashdata('error', $error);
          redirect(base_url() . 'index.php/user.edit/' . $userId);
        } else {
          $fInfo = $this->upload->data(); // File uploaded successfully
          $this->gallery_path = realpath(APPPATH . '../uploads'); // Fetch path

          // Generate thumbnail
          $config1 = array(
            'source_image' => $fInfo['full_path'], // Original image
            'new_image' => $this->gallery_path . '/thumb', // Save as new image
            'maintain_ratio' => true,
            'width' => 250,
            'height' => 250
          );
          $this->load->library('image_lib', $config1); // Load image library
          $this->image_lib->resize(); // Generate thumbnail

          // Get file name
          $file_name = $fInfo['file_name'];

          // Add image to form data
          $formArray['profile_picture'] = $file_name;

          // Delete the old image if it exists
          if (!empty($user['profile_picture']) && file_exists('./uploads/' . $user['profile_picture'])) {
            unlink('./uploads/' . $user['profile_picture']);
          }
        } 
      }

      $this->User_model->updateUser($userId, $formArray);

      $this->session->set_flashdata('success', 'Record Updated Successfully');
      redirect(base_url() . 'index.php/user/index');
    }
  }

  public function delete($userId)
  {
    $this->load->model('User_model');
    $user = $this->User_model->getUser($userId);
    if (empty($user)) {
      $this->session->set_flashdata('failure', 'No matching record found');
      redirect(base_url() . 'index.php/user/index');
    }
    $this->User_model->deleteUser($userId);
    $this->session->set_flashdata('success_delete', 'Record Deleted Successfully');
    redirect(base_url() . 'index.php/user/index');
  }

  public function getCitiesByState($stateId)
  {
    // Fetch cities based on the state ID (for dynamic city dropdown)
    $this->load->model('User_model');
    $cities = $this->User_model->getCitiesByState($stateId);
    echo json_encode($cities); // Return cities in JSON
  }
}
?>
