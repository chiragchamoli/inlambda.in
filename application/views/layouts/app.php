<?php 
$this->load->view('layouts/app_header');
$this->load->view('layouts/app_topbar');
echo $yield;
$this->load->view('layouts/app_footer');

