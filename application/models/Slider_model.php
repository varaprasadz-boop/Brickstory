<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'slider_images';
    }

    // Insert a new slider image record
    public function insert_slider($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Get all slider images
    public function get_all_sliders()
    {
        return $this->db->get($this->table)->result_array();
    }

    // Get a slider image by ID
    public function get_slider_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    // Update a slider image
    public function update_slider($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Delete a slider image
    public function delete_slider($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
