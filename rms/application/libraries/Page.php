<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library for CodeIgniter 3.0.6
 * 
 * Class to manage template page
 *
 * @package		MFS_Library
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Yenda Purbadian
 * @email		yenda.message@gmail.com
 */
class Page {

    private $_CI;
    protected $CI;

    public function __construct() {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '1024M');

        $this->_CI = & get_instance();

        //cek langueage
        $lang = $this->_CI->session->userdata('lang');
        $admin = $this->_CI->session->userdata('admin');

        if ($lang == "") {
            $this->_CI->session->set_userdata('lang', "eng");
        }

        $cek = $this->_CI->uri->segment(1);
        $cek2 = $this->_CI->uri->segment(2);

        if ($cek2 != "") {
            if ($cek == 'admin') {
                if ($cek2 != 'login' AND $cek2 !='login_process') {
                    if ($admin == '') {
                        redirect('/admin/login/');
                    }
                }
            } else {
                
            }
        }
    }

}

// END MFS_Page class

/* End of file Page.php */
/* Location: ./application/libraries/Page.php */