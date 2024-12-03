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
      $config['upload_path'] = './uploads/';//path
      $config['file_name'] = time() . '_' . $_FILES['profile_picture']['name'];

      $this->load->library('upload', $config);


      if ($this->upload->do_upload('profile_picture')) {
        $fileData = $this->upload->data();
      } else {
        $data['upload_error'] = $this->upload->display_errors();
        $this->load->view('create', $data);
      }

      // Save user to database
      $formArray = array();
      $formArray['firstname'] = $this->input->post('firstname');
      $formArray['lastname'] = $this->input->post('lastname');
      $formArray['email'] = $this->input->post('email');
      $formArray['gender'] = $this->input->post('gender');
      $formArray['dob'] = $this->input->post('dob');
      $formArray['mobile'] = $this->input->post('mobile');
      $formArray['state_id'] = $this->input->post('state'); // Store state ID
      $formArray['city_id'] = $this->input->post('city');   // Store city ID
      $formArray['profile_picture'] = $fileData['file_name'];
      // $formArray['created_at'] = date('Y-m-d');

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
    $data['cities'] = $this->User_model->getCitiesByState($user['state_id']); // Fetch cities based on the user's state

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
