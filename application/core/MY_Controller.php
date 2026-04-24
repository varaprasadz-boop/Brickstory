<?php
class My_Controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();

        check_auth();
    }
}


class Admin_Controller extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        check_admin_auth();
        $this->load->library("pagination");

    }
}

