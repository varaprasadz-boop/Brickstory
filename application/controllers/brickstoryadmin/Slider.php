<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Slider_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'upload']);
    }

    // Display all sliders
    public function index()
    {
        $data['sliders'] = $this->Slider_model->get_all_sliders();
        $this->load->view('admin/slider/index', $data);
    }

    // Create a new slider
    public function create()
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('slider/create');
        } else {
            // Handle file upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/sliders/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $data = [
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description'),
                        'image' => $uploadData['file_name']
                    ];
                    $this->Slider_model->insert_slider($data);
                    redirect('slider');
                } else {
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('slider/create', $data);
                }
            } else {
                $data['error'] = 'Image is required';
                $this->load->view('slider/create', $data);
            }
        }
    }

    // Edit a slider
    public function edit($id)
    {
        $data['slider'] = $this->Slider_model->get_slider_by_id($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('slider/edit', $data);
        } else {
            $updateData = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description')
            ];

            // Handle file upload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/sliders/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $updateData['image'] = $uploadData['file_name'];
                } else {
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('slider/edit', $data);
                    return;
                }
            }

            $this->Slider_model->update_slider($id, $updateData);
            redirect('slider');
        }
    }

    // Delete a slider
    public function delete($id)
    {
        $this->Slider_model->delete_slider($id);
        redirect('slider');
    }
}
