<?php
class User extends CI_Controller
{
  public function login()
  {

    $this->load->view('login');
  }
  public function index()
  {
    $this->load->library('pagination');

    $this->load->model("User_model");

    $config = array();

    $config['base_url'] = base_url('index.php/user/index');
    $config['total_rows'] = $this->User_model->countAllUsers();
    $config['per_page'] = 5;
    $config['uri_segment'] = 3;


    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = 'First';
    $config['last_link'] = 'Last';
    $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['first_tag_close'] = '</span></li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close'] = '</span></li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['next_tag_close'] = '</span></li>';
    $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['last_tag_close'] = '</span></li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close'] = '</span></li>';



    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    // $users = $this->User_model->getPaginatedUsers($config['per_page'], $page);

    $users = $this->User_model->all($config['per_page'], $page);
    $data = array();
    $data['users'] = $users;
    $data['pagination_links'] = $this->pagination->create_links(); // Generate pagination links
    $data['states'] = $this->User_model->getStates(); // Fetch states for the dropdown
    $data['cities'] = $this->User_model->getCities(); // Fetch cities
    $data['page'] = $page;


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
      $this->load->view('list', $data);
    } else {
      if (!empty($_FILES['file']['name'])) {
        $name_array = '';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        // $config['max_size'] = '1000';
        // $config['max_width'] = '1280';
        // $config['max_height'] = '1280';
        $this->load->library('upload');
        $this->upload->initialize($config);
        // print_r($this->upload->do_upload('file'));
        // exit;
        if (!$this->upload->do_upload('file')) {
          $this->upload->display_errors();
          $this->session->set_flashdata('fileError', 'Unable to upload file due to unsupported file format..');
          redirect(base_url() . 'index.php/user/index');

        } else {
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
      $this->load->view('list', $data);
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
        // $config['max_size'] = '1000';
        // $config['max_width'] = '1280';
        // $config['max_height'] = '1280';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
          $error = $this->upload->display_errors();
          $this->session->set_flashdata('fileError', 'Unable to upload file due to unsupported file format..');
          redirect(base_url() . 'index.php/user/index');
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


  function getUserData($userId)
  {
    $this->load->model('User_model');
    $user = $this->User_model->getUser($userId);

    echo json_encode($user);
    // print_r($user);
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

  public function getStates()
  {
    $this->load->model('User_model');
    $states = $this->User_model->getStates();
    echo json_encode($states);

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