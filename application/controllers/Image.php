<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {

    public function resize($width, $height, $image_name) {
        // Load the image library
        $this->load->library('image_lib');

        // Set the path to the original image
        $source_path = './assets/'.$this->input->get("p") . $image_name;
        // Set the path to save the resized image
        $target_path = './assets/'.$this->input->get("p") .'resized/' . $width . 'x' . $height . '_' . $image_name;

       
       // Check if the resized image already exists
       if (!file_exists($target_path)) {
        // Get the original image size
        list($orig_width, $orig_height) = getimagesize($source_path);

        // Calculate the resize dimensions
        $aspect_ratio = $orig_width / $orig_height;
        if ($width / $height > $aspect_ratio) {
            $new_width = $height * $aspect_ratio;
            $new_height = $height;
        } else {
            $new_width = $width;
            $new_height = $width / $aspect_ratio;
        }

        // First, resize the image
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_path;
        $config['new_image'] = $target_path;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $new_width;
        $config['height'] = $new_height;

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
            return;
        }

        $this->image_lib->clear();

        // Now, pad the image to fit within the box
        $config['image_library'] = 'gd2';
        $config['source_image'] = $target_path;
        $config['new_image'] = $target_path;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['x_axis'] = ($width - $new_width) / 2;
        $config['y_axis'] = ($height - $new_height) / 2;
        $config['background'] = 'FFFFFF'; // You can change the background color

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
            return;
        }

        $this->image_lib->clear();
    }

        // Load the resized image and send it to the browser
        header('Content-Type: image/jpeg');
        readfile($target_path);
    }
}
