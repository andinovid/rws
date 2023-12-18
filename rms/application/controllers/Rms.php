<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rms_model');
        $this->sess = $this->session->userdata('admin');

        if (!$this->sess) {
            redirect(base_url() . 'auth/login/', 'refresh');
            exit();
        }
    }

    public function index()
    {
        if (!$this->sess) {
            header('Location: ' . base_url() . 'rms/login/');
            exit();
        } else {
            header('Location: ' . base_url() . 'rms/dashboard/');
            exit();
        }
    }

    function login()
    {
        $this->load->view('rms/auth/index');
    }

    function login_process()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('pwd');
        $pass = md5($password);
        if ($username != null and $password != null) {

            $src = $this->admin_model->Get_Auth($username, $pass);
            if ($src->num_rows() == 0) {
                $this->session->set_flashdata('status', 'failed');
                echo "users not exist wherever OR wrong password!";
            } else {
                $users = $src->row();
                $this->session->set_userdata('admin', $users);
                /*
                  $last_log = array(
                  'last_login' => date("Y-m-d H:i:s"),
                  );
                  $lastlog = $this->m_model->update('tbl_users', $last_log, $users->id_user);
                 */
                echo "1";
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'rms/login');
    }

    function dashboard()
    {
        if ($this->sess->role == '5') {
            $id_supir = $this->sess->id_supir;
            $data['truck'] = $this->rms_model->get("v_truck", "WHERE id_supir = '$id_supir'")->row();
        } else {
            $data['all_project'] = $this->rms_model->get("v_project")->num_rows();
            $data['project_on_progress'] = $this->rms_model->get("v_project", "WHERE status = '0' OR status = '1'")->num_rows();
            $data['project_complete'] = $this->rms_model->get("v_project", "WHERE status = '2'")->num_rows();
            $data['saldo'] = $this->rms_model->get_by_query("SELECT SUM(CASE WHEN jenis = '1' THEN jumlah ELSE 0 END) -  SUM(CASE WHEN jenis = '2' THEN jumlah ELSE 0 END) as total FROM tbl_keuangan")->row();
            $data['project_on_progress_list'] = $this->rms_model->get("v_project", "WHERE (status = '0' OR status = '1') AND total_terkirim > 0 LIMIT 8")->result();
            $data['truck'] = $this->rms_model->get("v_truck", "WHERE kategori = '1' LIMIT 8")->result();
        }

        $data['content'] = 'rms/dashboard/dashboard';
        $this->load->view('rms/includes/template', $data);
    }

    function project()
    {
        $data['project'] = $this->rms_model->get("v_project", "ORDER BY tanggal_input DESC")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['penagih'] = $this->rms_model->get("tbl_penagih")->result();
        $data['content'] = 'rms/project/index';
        $this->load->view('rms/includes/template', $data);
    }

    function rekapitulasi()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE kategori_truck = '1'")->result();
        $data['project'] = $this->rms_model->get_by_query("SELECT id, no_do FROM tbl_project")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/rekap/index';
        $this->load->view('rms/includes/template', $data);
    }

    function replas()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_vendor !='1'")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/project/replas';
        $this->load->view('rms/includes/template', $data);
    }

    function non_do()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE non_do = '1'")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/project/non_do';
        $this->load->view('rms/includes/template', $data);
    }

    function view_project($id_project)
    {
        $data['project'] = $this->rms_model->get("v_project", "WHERE id_project = $id_project")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project ORDER BY tanggal_input DESC")->result();
        $data['total'] = $this->rms_model->get_by_query("SELECT SUM(bruto_awal) as total_bruto_awal, SUM(bruto_akhir) as total_bruto_akhir, SUM(tarra_awal) as total_tarra_awal, SUM(tarra_akhir) as total_tarra_akhir, SUM(timbang_kebun_bag) as total_qty_awal_bag, SUM(timbang_kebun_kg) as total_qty_awal_kg, SUM(qty_kirim_bag) as total_qty_akhir_bag, SUM(qty_kirim_kg) as total_qty_akhir_kg, SUM(m_susut) as total_susut  FROM v_rekap WHERE id_project = $id_project")->row();
        $data['pembayaran_replas'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project AND status ='1'")->result();
        $data['pembayaran_bongkar_muat'] = $this->rms_model->get("tbl_pembayaran_bongkar_muat", "WHERE id_project = $id_project")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
        $data['content'] = 'rms/project/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function edit()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $data = $this->rms_model->get($tbl, "WHERE id = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function cek_project($id)
    {
        $data = $this->rms_model->get_by_query("SELECT id, id_komoditas, id_klien FROM tbl_project WHERE id = $id");
        $detail = $data->row();
        echo json_encode($detail);
    }
    

    public function get_rekap()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_rekap", "WHERE id_rekap = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function get_kwitansi()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_kwitansi", "WHERE id_kwitansi = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }



    public function save_replas()
    {
        $id = $this->input->POST('id');
        $id_project = $this->input->POST('id_project');
        $no_replas = $this->input->POST('no_replas');
        $tanggal_muat = $this->input->POST('tanggal_muat');
        $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
        if ($tanggal_muat) {
            $tanggal_muat = $this->input->POST('tanggal_muat');
        } else {
            $tanggal_muat = NULL;
        }
        if ($tanggal_bongkar) {
            $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
        } else {
            $tanggal_bongkar = NULL;
        }
        if ($id_project) {
            $id_project = $this->input->POST('id_project');
        } else {
            $id_project = NULL;
        }

        if ($this->input->POST('bruto_awal')) {
            $bruto_awal = $this->input->POST('bruto_awal');
        } else {
            $bruto_awal = NULL;
        }
        if ($this->input->POST('tarra_awal')) {
            $tarra_awal = $this->input->POST('tarra_awal');
        } else {
            $tarra_awal = NULL;
        }
        if ($this->input->POST('bruto_akhir')) {
            $bruto_akhir = $this->input->POST('bruto_akhir');
        } else {
            $bruto_akhir = NULL;
        }
        if ($this->input->POST('tarra_akhir')) {
            $tarra_akhir = $this->input->POST('tarra_akhir');
        } else {
            $tarra_akhir = NULL;
        }
        if ($this->input->POST('no_tiket')) {
            $no_tiket = $this->input->POST('no_tiket');
        } else {
            $no_tiket = NULL;
        }

        $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
        $supir = $this->input->POST('supir');
        $truck = $this->input->POST('truck');
        $vendor_pajak = $this->input->POST('vendor_pajak');
        $vendor_pencairan = $this->input->POST('vendor_pencairan');
        $tujuan = $this->input->POST('tujuan');
        $qty_kirim_bag = $this->input->POST('qty_kirim_bag');
        $qty_kirim_kg = $this->input->POST('qty_kirim_kg');
        $timbang_kebun_bag = $this->input->POST('timbang_kebun_bag');
        $timbang_kebun_kg = $this->input->POST('timbang_kebun_kg');
        $uang_sangu = $this->input->POST('uang_sangu');
        $toleransi_susut = $this->input->POST('toleransi_susut');
        $tanggal_input = date('Y-m-d H:i:s');

        $data = array(
            'no_replas' => $no_replas,
            'no_tiket' => $no_tiket,
            'id_project' => $id_project,
            'tanggal_muat' => $tanggal_muat,
            'tanggal_bongkar' => $tanggal_bongkar,
            'id_supir' => $supir,
            'id_truck' => $truck,
            'id_vendor_pencairan' => $vendor_pencairan,
            'id_vendor_pajak' => $vendor_pajak,
            'id_tujuan' => $tujuan,
            'bruto_awal' => str_replace('.', '', $bruto_awal),
            'tarra_awal' => str_replace('.', '', $tarra_awal),
            'bruto_akhir' => str_replace('.', '', $bruto_akhir),
            'tarra_akhir' => str_replace('.', '', $tarra_akhir),
            'qty_kirim_bag' => $qty_kirim_bag,
            'qty_kirim_kg' => str_replace('.', '', $qty_kirim_kg),
            'timbang_kebun_bag' => $timbang_kebun_bag,
            'timbang_kebun_kg' => str_replace('.', '', $timbang_kebun_kg),
            'toleransi_susut' => $toleransi_susut,
            'uang_sangu' => str_replace('.', '', $uang_sangu),
            'non_do' => '0',
            'status' => '0',
        );

        $data2 = array(
            'status' => '1',
        );

        if ($id == "") {
            $data += array(
                'tanggal_input' => $tanggal_input
            );
            $save = $this->rms_model->insert("tbl_rekap", $data);
            $this->rms_model->update("tbl_project", $data2, $id_project);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_rekap", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_replas_non_do()
    {
        $id = $this->input->POST('id');
        $supir = $this->input->POST('supir');
        $truck = $this->input->POST('truck');
        $komoditas = $this->input->POST('komoditas');
        $tujuan = $this->input->POST('tujuan');
        $timbang_kebun = $this->input->POST('timbang_kebun_kg');
        $qty_kirim_kg = $this->input->POST('qty_kirim_kg');
        $harga = $this->input->POST('harga');
        $harga_supir = $this->input->POST('harga_supir');
        $uang_sangu = $this->input->POST('uang_sangu');
        $tanggal_input = date('Y-m-d H:i:s');
        $vendor_pencairan = $this->input->POST('vendor_pencairan');
        $biaya_admin = $this->input->POST('biaya_admin');
        $data = array(
            'id_supir' => $supir,
            'id_truck' => $truck,
            'non_do_id_komoditas' => $komoditas,
            'id_tujuan' => $tujuan,
            'id_vendor_pencairan' => $vendor_pencairan,
            'timbang_kebun_kg' => str_replace('.', '', $timbang_kebun),
            'qty_kirim_kg' => str_replace('.', '', $qty_kirim_kg),
            'non_do_harga' => $harga,
            'non_do_harga_vendor' => $harga_supir,
            'uang_sangu' => str_replace('.', '', $uang_sangu),
            'non_do_biaya_admin' => str_replace('.', '', $biaya_admin),
            'non_do' => '1',
            'status' => '0',
            'tanggal_input' => $tanggal_input,
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_rekap", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_rekap", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function delete()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $delete = $this->rms_model->delete_data($tbl, $id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete_project()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_project($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete_invoice()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_invoice($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }
    public function delete_kwitansi()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_kwitansi($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete_kwitansi_transporter()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_kwitansi_transporter($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }


    public function delete_perbaikan()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_perbaikan($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function save_project()
    {
        $id = $this->input->POST('id');
        $no_kontrak = $this->input->POST('no_kontrak');
        $no_sto = $this->input->POST('no_sto');
        $no_do = $this->input->POST('no_do');
        $klien = $this->input->POST('klien');
        $tanggal_angkut = $this->input->POST('tanggal_angkut');
        $tanggal_selesai = $this->input->POST('tanggal_selesai');
        $komoditas = $this->input->POST('komoditas');
        $qty = $this->input->POST('qty');
        $toleransi_susut = $this->input->POST('toleransi_susut');
        $harga_unit = $this->input->POST('harga_unit');
        $claim = $this->input->POST('claim');
        $claim_replas = $this->input->POST('claim_replas');
        $deskripsi = $this->input->POST('deskripsi');
        $penagih = $this->input->POST('penagih');
        $tanggal_input = date('Y-m-d H:i:s');

        $file_spk = $_FILES['file_spk']['name'];
        $file_do = $_FILES['file_do']['name'];

        $data_array = array(
            'no_kontrak' => $no_kontrak,
            'no_sto' => $no_sto,
            'no_do' => $no_do,
            'id_klien' => $klien,
            'tanggal_angkut' => $tanggal_angkut,
            'tanggal_selesai' => $tanggal_selesai,
            'id_komoditas' => $komoditas,
            'qty' => str_replace('.', '', $qty),
            'toleransi_susut' => $toleransi_susut,
            'harga_unit' => str_replace('.', '', $harga_unit),
            'claim' => str_replace('.', '', $claim),
            'claim_replas' => str_replace('.', '', $claim_replas),
            'deskripsi' => $deskripsi,
            'id_penagih' => $penagih,
            'status' => '0',
        );

        if (!empty($file_spk)) {
            $this->load->library('upload');
            $file_spk = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_spk);
            $filename_spk = str_replace(' ', '_', time() . $file_spk);
            $config['upload_path'] = 'assets/rms/documents/spk/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_spk')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_spk' => $filename_spk
            );
        }
        if (!empty($file_do)) {
            $this->load->library('upload');
            $file_do = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_do);
            $filename_do = str_replace(' ', '_', time() . $file_do);
            $config['upload_path'] = 'assets/rms/documents/do/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_do;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_do')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_do' => $filename_do
            );
        }

        if ($id == "") {
            $data_array += array(
                'tanggal_input' => $tanggal_input
            );
            $save = $this->rms_model->insert("tbl_project", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_project", $data_array, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pilih_truck()
    {
        $post = $this->input->post();
        for ($i = 0; $i < count($post['truck']); $i++) {
            $data = array(
                'id_project' => $post['id_project'],
                'id_truck' => $post['truck'][$i],
                'id_supir' => $post['supir'][$i],
                'id_tujuan' => $post['tujuan'][$i],
                'tanggal_muat' => $post['tanggal_muat'][$i],
                'uang_sangu' => $post['uang_sangu'][$i],
                'status' => '1',
            );
            $save = $this->db->insert('tbl_rekap', $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function truck()
    {
        $data['truck_rws'] = $this->rms_model->get("v_truck", "WHERE kategori = '1'")->result();
        $data['truck_vendor'] = $this->rms_model->get("v_truck", "WHERE kategori = '2'")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['content'] = 'rms/truck/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_truck($id_truck)
    {
        $data['truck'] = $this->rms_model->get("v_truck", "WHERE id_truck = $id_truck")->row();
        $id_supir = $data['truck']->id_supir;
        $data['profil_supir'] = $this->rms_model->get("tbl_supir", "WHERE id = $id_supir")->row();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_truck = $id_truck")->result();
        $data['perbaikan_reguler'] = $this->rms_model->get("v_perbaikan", "WHERE id_truck = $id_truck")->result();
        $data['total_perbaikan'] = $this->rms_model->get_by_query("SELECT SUM(jumlah) as total_perbaikan from v_perbaikan WHERE id_truck = $id_truck")->row();
        $data['bbm'] = $this->rms_model->get("v_bbm", "WHERE id_truck = $id_truck ORDER BY tanggal DESC")->result();
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart")->result();
        $data['content'] = 'rms/truck/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_pengisian_bbm()
    {
        $id = $this->input->POST('id');
        $truck = $this->input->POST('id_truck');
        $supir = $this->input->POST('supir');
        $tanggal = $this->input->POST('tanggal');
        $jumlah_liter = $this->input->POST('jumlah_liter');
        $jumlah_harga = $this->input->POST('jumlah_harga');
        $nama_supir = $this->input->POST('nama_supir');
        $data = array(
            'id_truck' => $truck,
            'id_supir' => $supir,
            'tanggal' => $tanggal,
            'jumlah_liter' => $jumlah_liter,
            'jumlah_harga' => str_replace('.', '', $jumlah_harga),
        );

        $data_update_truck = array(
            'bbm_terakhir' => shortdate_indo($tanggal) . ' | ' . $jumlah_liter . 'L ' . ' | ' . $jumlah_harga . ' | ' . $nama_supir,
        );

        $save = $this->rms_model->update("tbl_truck", $data_update_truck, $truck);

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_pengisian_bbm", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_pengisian_bbm", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_truk()
    {
        $id = $this->input->POST('id');
        $nopol = $this->input->POST('nopol');
        $kategori = $this->input->POST('kategori');

        if (isset($_POST['vendor'])) {
            $vendor = $this->input->POST('vendor');
        } else {
            $vendor = "";
        }
        if (isset($_POST['jenis_truck'])) {
            $jenis_truck = $this->input->POST('jenis_truck');
        } else {
            $jenis_truck = "";
        }
        if (isset($_POST['supir'])) {
            $supir = $this->input->POST('supir');
        } else {
            $supir = "";
        }
        if (isset($_POST['nomor_rangka'])) {
            $nomor_rangka = $this->input->POST('nomor_rangka');
        } else {
            $nomor_rangka = "";
        }
        if (isset($_POST['nomor_mesin'])) {
            $nomor_mesin = $this->input->POST('nomor_mesin');
        } else {
            $nomor_mesin = "";
        }
        if (isset($_POST['pajak_tahunan'])) {
            $pajak_tahunan = $this->input->POST('pajak_tahunan');
        } else {
            $pajak_tahunan = "";
        }
        if (isset($_POST['pajak_5_tahunan'])) {
            $pajak_5_tahunan = $this->input->POST('pajak_5_tahunan');
        } else {
            $pajak_5_tahunan = "";
        }
        if (isset($_POST['kir_terakhir'])) {
            $kir_terakhir = $this->input->POST('kir_terakhir');
        } else {
            $kir_terakhir = "";
        }
        if (isset($_POST['oddo_terakhir'])) {
            $oddo_terakhir = $this->input->POST('oddo_terakhir');
        } else {
            $oddo_terakhir = "";
        }
        if (isset($_POST['oddo_terakhir_oli_mesin'])) {
            $oddo_terakhir_oli_mesin = $this->input->POST('oddo_terakhir_oli_mesin');
        } else {
            $oddo_terakhir_oli_mesin = "";
        }
        if (isset($_POST['oddo_terakhir_oli_gardan'])) {
            $oddo_terakhir_oli_gardan = $this->input->POST('oddo_terakhir_oli_gardan');
        } else {
            $oddo_terakhir_oli_gardan = "";
        }
        if (isset($_POST['oddo_terakhir_oli_transmisi'])) {
            $oddo_terakhir_oli_transmisi = $this->input->POST('oddo_terakhir_oli_transmisi');
        } else {
            $oddo_terakhir_oli_transmisi = "";
        }
        if (isset($_POST['cicilan'])) {
            $cicilan = $this->input->POST('cicilan');
        } else {
            $cicilan = "";
        }
        if (isset($_POST['premi_supir'])) {
            $premi_supir = $this->input->POST('premi_supir');
        } else {
            $premi_supir = "";
        }

        if (isset($_POST['air_radiator'])) {
            $air_radiator = $this->input->POST('air_radiator');
        } else {
            $air_radiator = "";
        }

        $data = array(
            'nopol' => $nopol,
            'kategori' => $kategori,
            'id_vendor' => $vendor,
            'cicilan' => str_replace('.', '', $cicilan),
            'jenis_truck' => $jenis_truck,
            'id_supir' => $supir,
            'nomor_rangka' => $nomor_rangka,
            'nomor_mesin' => $nomor_mesin,
            'kir_terakhir' => $kir_terakhir,
            'pajak_tahunan' => $pajak_tahunan,
            'pajak_5_tahunan' => $pajak_5_tahunan,
            'oddo_terakhir' => str_replace('.', '', $oddo_terakhir),
            'oddo_terakhir_oli_mesin' => str_replace('.', '', $oddo_terakhir_oli_mesin),
            'oddo_terakhir_oli_gardan' => str_replace('.', '', $oddo_terakhir_oli_gardan),
            'oddo_terakhir_oli_transmisi' => str_replace('.', '', $oddo_terakhir_oli_transmisi),
            'air_radiator_terakhir' => $air_radiator,
            'premi_supir' => $premi_supir
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_truck", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_truck", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function delete_truck()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_truck($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    function perbaikan()
    {
        $data['perbaikan'] = $this->rms_model->get("v_perbaikan")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart")->result();
        $data['content'] = 'rms/perbaikan/index';
        $this->load->view('rms/includes/template', $data);
    }

    function insert_sparepart_perbaikan()
    {
        $id_sparepart = $this->input->post('id_sparepart');
        $data = array(
            'id_perbaikan'  => $this->input->post('id_perbaikan'),
            'id_sparepart' => $this->input->post('id_sparepart'),
            'jumlah'   => $this->input->post('jumlah')
        );
        $sparepart = $this->rms_model->get("tbl_sparepart", "WHERE id = $id_sparepart")->row();

        $qty = $sparepart - $this->input->post('jumlah');
        $data_update = array(
            'qty'   => $qty,
        );
        $this->rms_model->update("tbl_sparepart", $data_update, $id_sparepart);
        $this->rms_model->insert("tbl_perbaikan_sparepart", $data);
    }

    function delete_perbaikan_sparepart()
    {
        $id = $this->input->POST('id');
        $id_sparepart = $this->input->POST('id_sparepart');
        $jumlah = $this->input->POST('jumlah');

        $sparepart = $this->rms_model->get("tbl_sparepart", "WHERE id = '$id_sparepart'")->row();
        $qty = $sparepart + $jumlah;

        $data_update = array(
            'qty'   => $qty,
        );
        $this->rms_model->update("tbl_sparepart", $data_update, $id_sparepart);

        $delete = $this->rms_model->delete_data("tbl_perbaikan_sparepart", $id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function save_perbaikan()
    {
        $id = $this->input->POST('id');
        $truck = $this->input->POST('truck');
        $supir = $this->input->POST('supir');
        $tanggal = $this->input->POST('tanggal');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $status = $this->input->POST('status');
        $nopol = $this->input->POST('nopol');
        $nama_supir = $this->input->POST('nama_supir');
        $kategori = $this->input->POST('kategori');
        $payer = $this->input->POST('payer');

        $nota = $_FILES['nota']['name'];

        $data_array = array(
            'kategori' => $kategori,
            'id_truck' => $truck,
            'nopol' => $nopol,
            'id_supir' => $supir,
            'nama_supir' => $nama_supir,
            'tanggal' => $tanggal,
            'jumlah' => str_replace('.', '', $jumlah),
            'jenis' => $jenis,
            'status' => $status,
            'payer' => $payer,
        );

        if (!empty($nota)) {
            $this->load->library('upload');
            $nota = preg_replace("/[^a-zA-Z0-9.]/", "_", $nota);
            $filename_spk = str_replace(' ', '_', time() . $nota);
            $config['upload_path'] = './assets/rms/documents/nota_perbaikan/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('nota')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'nota' => $filename_spk,
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert_id("tbl_perbaikan", $data_array);
            if ($status == '1' and $payer == '1') {
                $data_keuangan = array(
                    'jenis' => '2',
                    'kategori' => '4',
                    'keterangan' => $jenis . '-' . $nama_supir . ' - ' . $nopol,
                    'jumlah' => str_replace('.', '', $jumlah),
                    'tanggal' => $tanggal,
                    'id_perbaikan' => $save,
                );
                $this->rms_model->insert("tbl_keuangan", $data_keuangan);
            }
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_perbaikan", $data_array, $id);
            $data_keuangan = array(
                'keterangan' => $jenis . '-' . $nama_supir . ' - ' . $nopol,
                'jumlah' => str_replace('.', '', $jumlah),
                'tanggal' => $tanggal,
            );
            $this->rms_model->update_keuangan_perbaikan($data_keuangan, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function vendor()
    {
        $data['vendor'] = $this->rms_model->get("v_vendor")->result();
        $data['content'] = 'rms/vendor/index';
        $this->load->view('rms/includes/template', $data);
    }

    function klien()
    {
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['content'] = 'rms/klien/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_klien()
    {
        $id = $this->input->POST('id');
        $nama_perusahaan = $this->input->POST('nama_perusahaan');
        $alamat = $this->input->POST('alamat');
        $email = $this->input->POST('email');
        $no_tlp = $this->input->POST('no_tlp');
        $data = array(
            'nama_perusahaan' => $nama_perusahaan,
            'alamat' => $alamat,
            'email' => $email,
            'no_tlp' => $no_tlp,
            'status' => '1',
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_klien", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_klien", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_vendor()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $no_hp = $this->input->POST('no_hp');
        $no_rekening = $this->input->POST('nomor_rekening');
        $nama_rekening = $this->input->POST('nama_rekening');
        $bank = $this->input->POST('bank');
        $jenis_pajak = $this->input->POST('jenis_pajak');
        $no_pajak = $this->input->POST('no_pajak');
        $nama_pajak = $this->input->POST('nama_pajak');
        $data = array(
            'nama' => $nama,
            'no_hp' => $no_hp,
            'no_rekening' => $no_rekening,
            'nama_rekening' => $nama_rekening,
            'bank' => $bank,
            'jenis_pajak' => $jenis_pajak,
            'no_pajak' => $no_pajak,
            'nama_pajak' => $nama_pajak,
            'status' => '1',
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_vendor_truck", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_vendor_truck", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function view_vendor($id)
    {
        $data['vendor'] = $this->rms_model->get("v_vendor", "WHERE id = $id")->row();
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE id_vendor = $id")->result();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_vendor = $id")->result();
        $data['content'] = 'rms/vendor/view';
        $this->load->view('rms/includes/template', $data);
    }

    function load_data_sparepart_perbaikan($id)
    {
        $data = $this->rms_model->get("v_perbaikan_sparepart", "WHERE id_perbaikan = $id")->result();
        echo json_encode($data);
    }

    function sparepart()
    {
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart")->result();
        $data['content'] = 'rms/sparepart/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_sparepart($id)
    {
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart", "WHERE id = $id")->row();
        $data['riwayat_sparepart'] = $this->rms_model->get("v_perbaikan_sparepart", "WHERE id_sparepart = $id")->result();
        $data['content'] = 'rms/sparepart/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_sparepart()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $qty = $this->input->POST('qty');
        $harga = $this->input->POST('harga');

        $foto = $_FILES['foto']['name'];
        $data_array = array(
            'nama' => $nama,
            'qty' => str_replace('.', '', $qty),
            'harga' => str_replace('.', '', $harga),
        );

        if (!empty($foto)) {
            $this->load->library('upload');
            $foto = preg_replace("/[^a-zA-Z0-9.]/", "_", $foto);
            $filename_spk = str_replace(' ', '_', time() . $foto);
            $config['upload_path'] = 'assets/rms/documents/sparepart/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'foto' => $filename_spk
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_sparepart", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_sparepart", $data_array, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function supir()
    {
        $data['supir_rws'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '1'")->result();
        $data['supir_vendor'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '2'")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE kategori = '1'")->result();
        $data['content'] = 'rms/supir/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_supir()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $no_wa = $this->input->POST('no_wa');
        $no_ktp = $this->input->POST('no_ktp');
        $no_sim = $this->input->POST('no_sim');
        $kategori = $this->input->POST('kategori');

        $file_ktp = $_FILES['file_ktp']['name'];
        $file_sim = $_FILES['file_sim']['name'];

        $data_array = array(
            'nama' => $nama,
            'no_wa' => $no_wa,
            'no_ktp' => $no_ktp,
            'no_sim' => $no_sim,
            'kategori' => $kategori,
            'status' => '1',
        );

        if (!empty($file_ktp)) {
            $this->load->library('upload');
            $file_ktp = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_ktp);
            $filename_ktp = str_replace(' ', '_', time() . $file_ktp);
            $config['upload_path'] = 'assets/rms/documents/supir/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_ktp;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_ktp')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_ktp' => $filename_ktp
            );
        }
        if (!empty($file_sim)) {
            $this->load->library('upload');
            $file_sim = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_sim);
            $filename_sim = str_replace(' ', '_', time() . $file_sim);
            $config['upload_path'] = 'assets/rms/documents/supir/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_sim;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_sim')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_sim' => $filename_sim
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_supir", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_supir", $data_array, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }


    function view_supir($id)
    {
        $data['supir'] = $this->rms_model->get("tbl_supir", "WHERE id = $id")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_supir = $id")->result();
        $data['content'] = 'rms/supir/view';
        $this->load->view('rms/includes/template', $data);
    }


    function tujuan()
    {
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['content'] = 'rms/tujuan/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_tujuan()
    {
        $id = $this->input->POST('id');
        $kode_tujuan = $this->input->POST('kode_tujuan');
        $nama_tujuan = $this->input->POST('nama_tujuan');
        $harga = $this->input->POST('harga');
        $data = array(
            'kode_tujuan' => $kode_tujuan,
            'nama_tujuan' => $nama_tujuan,
            'harga' => str_replace('.', '', $harga),
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_tujuan", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_tujuan", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pembayaran_bongkar_muat()
    {
        $id_project = $this->input->POST('id_project');
        $id = $this->input->POST('id');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $nama_kebun = $this->input->POST('nama_kebun');
        $penagih = $this->input->POST('penagih');
        $tonase = $this->input->POST('tonase');
        $tanggal_pembayaran = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'id_project' => $id_project,
            'jenis' => $jenis,
            'nama_kebun' => $nama_kebun,
            'penagih' => $penagih,
            'tonase' => str_replace('.', '', $tonase),
            'jumlah_pembayaran' => str_replace('.', '', $jumlah),
            'tanggal_pembayaran' => $tanggal_pembayaran
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_pembayaran_bongkar_muat", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_pembayaran_bongkar_muat", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pembayaran_invoice()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');
        $status = $this->input->POST('status');

        $data = array(
            'id_invoice' => $id,
            'tanggal' => $tanggal_bayar,
            'status' => $status,
        );
        $this->rms_model->insert("tbl_pembayaran_invoice", $data);
        $data_update = array(
            'status' => $status,
        );

        $save = $this->rms_model->update("tbl_invoice", $data_update, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    public function save_pembayaran_replas()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'tanggal_pembayaran_replas' => $tanggal_bayar,
            'status' => '1',
        );

        $save = $this->rms_model->update("tbl_rekap", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    public function save_pembayaran_kwitansi()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'tanggal_pembayaran' => $tanggal_bayar,
            'status' => '1',
        );

        $data_rekap = array(
            'tanggal_pembayaran_replas' => $tanggal_bayar,
            'status' => '1',
        );

        $save = $this->rms_model->update("tbl_kwitansi", $data, $id);
        if ($save) {
            $this->rms_model->update("tbl_rekap", $data_rekap, $id);
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function keuangan()
    {
        $data['keuangan'] = $this->rms_model->get("tbl_keuangan", "ORDER BY tanggal_input DESC")->result();
        $data['saldo'] = $this->rms_model->get_by_query("SELECT SUM(CASE WHEN jenis = '1' THEN jumlah ELSE 0 END) -  SUM(CASE WHEN jenis = '2' THEN jumlah ELSE 0 END) as total FROM tbl_keuangan")->row();
        $data['laporan'] = $this->rms_model->get_by_query("SELECT tahun, bulan, total_dana_masuk, total_dana_keluar from v_laporan_keuangan")->result();
        // $list = array();
        // foreach($data_lap as $row):
        //     $tahun[]= $row->tahun;
        //     $bulan[]= bulan($row->bulan);
        //     $total_dana_masuk[]= $row->total_dana_masuk;
        //     $total_dana_keluar[]= $row->total_dana_keluar;
        // endforeach;
        // $data['json_tahun'] = json_encode($tahun);
        // $data['json_bulan'] = json_encode($bulan);
        // $data['json_total_dana_masuk'] = json_encode($total_dana_masuk);
        // $data['json_total_dana_keluar'] = json_encode($total_dana_keluar);
        $data['content'] = 'rms/keuangan/index';
        $this->load->view('rms/includes/template', $data);
    }

    function pinjaman()
    {
        $data['pinjaman'] = $this->rms_model->get("v_pinjaman", "ORDER BY tanggal DESC")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['content'] = 'rms/pinjaman/index';
        $this->load->view('rms/includes/template', $data);
    }

    function download_laporan($bulan, $tahun)
    {
        $data['bulan'] = bulan($bulan);
        $data['tahun'] = $tahun;
        $data['komoditas'] = $this->rms_model->get_by_query("SELECT SUM(total_pemasukan_invoice) AS total_pemasukan,SUM(total_pph) AS total_potongan_pph, SUM(total_biaya_claim_invoice) AS total_biaya_claim, SUM(total_pph_replas) AS total_potongan_pph_replas, SUM(pengeluaran_lapangan) AS total_pengeluaran_lapangan, SUM(pengeluaran_replas) AS total_pengeluaran_replas, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_komoditas WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
        $data['transporter'] = $this->rms_model->get_by_query("SELECT SUM(grand_total) AS total_pemasukan, SUM(operasional) AS total_operasional,SUM(total_perbaikan) AS total_biaya_perbaikan, SUM(premi_supir) AS total_premi_supir, SUM(cicilan) AS total_cicilan, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_transporter WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
        $data['keuangan'] = $this->rms_model->get_by_query("SELECT * from v_laporan_keuangan WHERE bulan = '$bulan' AND tahun = '$tahun'")->row();
        $data['total_net_profit'] = $data['komoditas']->total_bersih + $data['transporter']->total_bersih - $data['keuangan']->operasional_kantor - $data['keuangan']->gaji_karyawan - $data['keuangan']->asuransi_karyawan;
        
        $this->load->library('pdf');
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $html = $this->load->view('rms/laporan/laporan_pdf', $data, true);
        $filename = "LAPORAN LABA RUGI (" . $data['bulan'] . " " . $data['tahun'] .").pdf";
        $this->pdf->createPDF($html, $filename, true);
    }


    function laporan()
    {
        if (!empty($_GET)) {
            $bulan = $_GET["bulan"];
            $tahun = $_GET["tahun"];
            $data['bulan'] = $_GET["bulan"];
            $data['tahun'] = $_GET["tahun"];
            $data['komoditas'] = $this->rms_model->get_by_query("SELECT SUM(total_pemasukan_invoice) AS total_pemasukan,SUM(total_pph) AS total_potongan_pph, SUM(total_biaya_claim_invoice) AS total_biaya_claim, SUM(total_pph_replas) AS total_potongan_pph_replas, SUM(pengeluaran_lapangan) AS total_pengeluaran_lapangan, SUM(pengeluaran_replas) AS total_pengeluaran_replas, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_komoditas WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
            $data['transporter'] = $this->rms_model->get_by_query("SELECT SUM(grand_total) AS total_pemasukan, SUM(operasional) AS total_operasional,SUM(total_perbaikan) AS total_biaya_perbaikan, SUM(premi_supir) AS total_premi_supir, SUM(cicilan) AS total_cicilan, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_transporter WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
            $data['keuangan'] = $this->rms_model->get_by_query("SELECT * from v_laporan_keuangan WHERE bulan = '$bulan' AND tahun = '$tahun'")->row();
            $data['total_net_profit'] = $data['komoditas']->total_bersih + $data['transporter']->total_bersih - $data['keuangan']->operasional_kantor - $data['keuangan']->gaji_karyawan - $data['keuangan']->asuransi_karyawan;
        }
        $data['content'] = 'rms/laporan/index';
        $this->load->view('rms/includes/template', $data);
    }

    function laporan_komoditas()
    {
        if (!empty($_GET)) {
            $bulan = $_GET["bulan"];
            $tahun = $_GET["tahun"];
            $data['laporan'] = $this->rms_model->get("v_laporan_komoditas", "WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->result();
            $data['total'] = $this->rms_model->get_by_query("SELECT SUM(total_pemasukan_invoice) AS total_pemasukan,SUM(total_pph) AS total_potongan_pph, SUM(total_biaya_claim_invoice) AS total_biaya_claim, SUM(total_pph_replas) AS total_potongan_pph_replas, SUM(pengeluaran_lapangan) AS total_pengeluaran_lapangan, SUM(pengeluaran_replas) AS total_pengeluaran_replas, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_komoditas WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
        }
        $data['content'] = 'rms/laporan/komoditas';
        $this->load->view('rms/includes/template', $data);
    }

    function laporan_transporter()
    {
        if (!empty($_GET)) {
            $bulan = $_GET["bulan"];
            $tahun = $_GET["tahun"];
            $data['laporan'] = $this->rms_model->get("v_laporan_transporter", "WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->result();
            $data['total'] = $this->rms_model->get_by_query("SELECT SUM(grand_total) AS total_pemasukan, SUM(operasional) AS total_operasional,SUM(total_perbaikan) AS total_biaya_perbaikan, SUM(premi_supir) AS total_premi_supir, SUM(cicilan) AS total_cicilan, SUM(total_keuntungan) AS total_bersih  FROM v_laporan_transporter WHERE periode_bulan = '$bulan' AND periode_tahun = '$tahun'")->row();
        }
        $data['content'] = 'rms/laporan/transporter';
        $this->load->view('rms/includes/template', $data);
    }




    public function save_keuangan()
    {
        $id = $this->input->POST('id');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $keterangan = $this->input->POST('keterangan');
        $kategori = $this->input->POST('kategori');
        $tanggal = $this->input->POST('tanggal');


        $data = array(
            'tanggal' => $tanggal,
            'jumlah' => str_replace('.', '', $jumlah),
            'jenis' => $jenis,
            'kategori' => $kategori,
            'keterangan' => $keterangan,
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_keuangan", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_keuangan", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pinjaman()
    {
        $id = $this->input->POST('id');
        $jumlah = $this->input->POST('jumlah');
        $id_truck = $this->input->POST('truck');
        $id_supir = $this->input->POST('supir');
        $tanggal = $this->input->POST('tanggal');
        $bulan = $this->input->POST('bulan');
        $tahun = $this->input->POST('tahun');
        $keterangan = $this->input->POST('keterangan');
        $status = $this->input->POST('status');


        $data = array(
            'id_truck' => $id_truck,
            'id_supir' => $id_supir,
            'jumlah_pinjaman' => str_replace('.', '', $jumlah),
            'tanggal' => $tanggal,
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'keterangan' => $keterangan,
            'status' => $status,
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_pinjaman", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_pinjaman", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }


    public function setting()
    {
        $data['content'] = 'rms/setting/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function get_setting()
    {
        $data = $this->rms_model->get("tbl_adm_setting", "");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function update_setting()
    {
        $id = '5';
        $biaya_admin = $_POST["biaya_admin"];
        $pph_skb = $_POST["pph_skb"];
        $pph_npwp = $_POST["pph_npwp"];
        $max_oli_mesin_euro3 = $_POST["max_oli_mesin_euro3"];
        $max_oli_mesin_euro4 = $_POST["max_oli_mesin_euro4"];
        $max_oli_mesin_isuzu = $_POST["max_oli_mesin_isuzu"];
        $max_oli_gardan_euro3 = $_POST["max_oli_gardan_euro3"];
        $max_oli_gardan_euro4 = $_POST["max_oli_gardan_euro4"];
        $max_oli_gardan_isuzu = $_POST["max_oli_gardan_isuzu"];
        $max_oli_transmisi_euro3 = $_POST["max_oli_transmisi_euro3"];
        $max_oli_transmisi_euro4 = $_POST["max_oli_transmisi_euro4"];
        $max_oli_transmisi_isuzu = $_POST["max_oli_transmisi_isuzu"];


        $data = array(
            'biaya_admin' => str_replace('.', '', $biaya_admin),
            'pph_skb' => $pph_skb,
            'pph_npwp' => $pph_npwp,
            'max_oli_mesin_euro3' => str_replace('.', '', $max_oli_mesin_euro3),
            'max_oli_mesin_euro4' => str_replace('.', '', $max_oli_mesin_euro4),
            'max_oli_mesin_isuzu' => str_replace('.', '', $max_oli_mesin_isuzu),
            'max_oli_gardan_euro3' => str_replace('.', '', $max_oli_gardan_euro3),
            'max_oli_gardan_euro4' => str_replace('.', '', $max_oli_gardan_euro4),
            'max_oli_gardan_isuzu' => str_replace('.', '', $max_oli_gardan_isuzu),
            'max_oli_transmisi_euro3' => str_replace('.', '', $max_oli_transmisi_euro3),
            'max_oli_transmisi_euro4' => str_replace('.', '', $max_oli_transmisi_euro4),
            'max_oli_transmisi_isuzu' => str_replace('.', '', $max_oli_transmisi_isuzu),
        );

        $save = $this->rms_model->update("tbl_adm_setting", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function kwitansi()
    {
        $data['kwitansi'] = $this->rms_model->get("v_kwitansi")->result();
        $data['content'] = 'rms/kwitansi/kwitansi';
        $this->load->view('rms/includes/template', $data);
    }

    function kwitansi_non_do()
    {
        $data['kwitansi'] = $this->rms_model->get_by_query("SELECT *, COUNT(id) AS total_replas FROM v_rekap_non_do WHERE status = '0' GROUP BY id_vendor")->result();
        $data['content'] = 'rms/project/kwitansi_non_do';
        $this->load->view('rms/includes/template', $data);
    }




    public function print_kwitansi($id_kwitansi)
    {

        $detail_kwitansi = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi WHERE id_kwitansi = '$id_kwitansi'")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );

        $excel->getActiveSheet()->getStyle('O3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffe100')
                )
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "KWITANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "CV RAJA WALI SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "Untuk Pembayaran");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "GROUP");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', $detail_kwitansi->vendor);
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "NO HP");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', $detail_kwitansi->no_hp);
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "NO REK");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', $detail_kwitansi->bank . ' ' . $detail_kwitansi->no_rekening . ' a/n ' . $detail_kwitansi->nama_rekening);
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "NOMOR KWITANSI : $detail_kwitansi->no_kwitansi");
        $excel->setActiveSheetIndex(0)->setCellValue('Q4', "Lembar 1");

        $excel->getActiveSheet()->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A4:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('O3:Q3'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G6:K6'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G5:K5'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G4:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A2:Q2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('O3:Q3')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('O3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); 
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('O3:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "TGL");
        $excel->setActiveSheetIndex(0)->setCellValue('C8', "QTY AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "QTY AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('F8', "NOPOL");
        $excel->setActiveSheetIndex(0)->setCellValue('G8', "ANGKUT");
        $excel->setActiveSheetIndex(0)->setCellValue('H8', "TUJUAN");
        $excel->setActiveSheetIndex(0)->setCellValue('I8', "M");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "C");
        $excel->setActiveSheetIndex(0)->setCellValue('K8', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('L8', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M8', "CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('N8', "TTL CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('O8', "Pph %");
        $excel->setActiveSheetIndex(0)->setCellValue('P8', "ADM");
        $excel->setActiveSheetIndex(0)->setCellValue('Q8', "GRAND TOTAL");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);

        $kwitansi = $this->rms_model->get("v_generate_kwitansi", "WHERE id_kwitansi = '$id_kwitansi'")->result();


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 9;
        $numrow2 = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($kwitansi as $data) { // Lakukan looping pada variabel siswa

            if ($data->jenis_pajak == 'skb') {
                $pph = '0.5%';
                $jenis_pajak = "SKB";
            } elseif ($data->jenis_pajak == 'ktp') {
                $pph = '4%';
                $jenis_pajak = "KTP";
            } elseif ($data->jenis_pajak == 'npwp') {
                $pph = '2%';
                $jenis_pajak = "NPWP";
            }

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo(date('Y-m-d')));
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo($data->tanggal_bongkar));
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->timbang_kebun_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->qty_kirim_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->komoditas);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->kode_tujuan);
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '0');
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->m_susut);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->c_claim);
            }
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Rp ' . number_format($data->harga, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($data->total, 0, "", "."));
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '0');
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, 'Rp ' . number_format($data->claim, 0, "", "."));
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($data->total_claim, 0, "", "."));
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($data->pph, 0, "", "."));
            }
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($data->biaya_admin, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Rp ' . number_format($data->grand_total, 0, "", "."));
            //$excel->setActiveSheetIndex(0)->insertNewRowBefore(2,1); 
            if ($data->non_do != '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow2, $jenis_pajak . ' ' . $data->no_pajak . ' - ' . $data->nama_pajak);
                $excel->getActiveSheet()->mergeCells('M' . $numrow2 . ':' . 'Q' . $numrow2); // Set Merge Cell pada kolom A1 sampai E1
                $excel->getActiveSheet()->getStyle('A' . $numrow2 . ':' . 'Q' . $numrow2)->applyFromArray($style_row);
            }
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow = $numrow + 2; // Tambah 1 setiap kali looping
            $numrow2 = $numrow2 + 2;
        }

        $total = $numrow + 1;
        $sebesar = $numrow + 3;
        $terbilang = $numrow + 4;
        $ttd = $numrow + 4;
        $ttd_bottom = $ttd + 3;
        $ttd_periksa = $ttd_bottom + 1;


        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->qty_awal);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->qty_akhir);
        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_kotor_replas, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_claim, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_pph, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_biaya_admin, 0, "", "."));
        $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);





        $excel->setActiveSheetIndex(0)->setCellValue('P' . $total, 'Total');
        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total, 'Rp ' . number_format($detail_kwitansi->grand_total, 0, "", "."));
        $excel->getActiveSheet()->getStyle('P' . $total)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q' . $total)->applyFromArray($style_row);

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $terbilang, '(' . ucwords(terbilang($detail_kwitansi->grand_total)) . ' Rupiah)');
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setItalic(TRUE);
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setSize(10); 


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $terbilang . ':' . 'E' . $terbilang); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setSize(16); 
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setItalic(TRUE);


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'SAURINA');
        $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Diterima oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, $detail_kwitansi->vendor);
        $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $detail_kwitansi->vendor . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function print_kwitansi_transporter($id_kwitansi)
    {

        $detail_kwitansi = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi_transporter WHERE id_kwitansi = '$id_kwitansi'")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '83ddff')
            )
        );

        $bg_yellow = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fff883')
            )
        );

        $excel->getActiveSheet()->getStyle('Q4')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ff6372')
                )
            )
        );
        $excel->getActiveSheet()->getStyle('Q5')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ff6372')
                )
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "KWITANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "CV RAJA WALI SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "UNTUK PEMBAYARAN");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', $detail_kwitansi->nama_supir);
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "NO HP");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', "");
        $excel->setActiveSheetIndex(0)->setCellValue('Q4', "Lembar 1");
        $excel->setActiveSheetIndex(0)->setCellValue('Q5', "Supir");

        $excel->getActiveSheet()->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A4:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G6:K6'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G5:K5'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G4:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A2:Q2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q5')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q5')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); 
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "TGL");
        $excel->setActiveSheetIndex(0)->setCellValue('C8', "QTY AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "QTY AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('F8', "NOPOL");
        $excel->setActiveSheetIndex(0)->setCellValue('G8', "ANGKUT");
        $excel->setActiveSheetIndex(0)->setCellValue('H8', "TUJUAN");
        $excel->setActiveSheetIndex(0)->setCellValue('I8', "M");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "C");
        $excel->setActiveSheetIndex(0)->setCellValue('K8', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('L8', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M8', "CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('N8', "TTL CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('O8', "Pph %");
        $excel->setActiveSheetIndex(0)->setCellValue('P8', "ADM");
        $excel->setActiveSheetIndex(0)->setCellValue('Q8', "GRAND TOTAL");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);

        $kwitansi = $this->rms_model->get("v_generate_kwitansi_transporter", "WHERE id_kwitansi = '$id_kwitansi' ORDER BY tanggal_bongkar ASC")->result();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 9;
        $numrow2 = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($kwitansi as $data) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo($data->tanggal_bongkar));
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->timbang_kebun_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->qty_kirim_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->komoditas);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->kode_tujuan);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->m_susut);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->c_claim);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Rp ' . number_format($data->harga, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($data->total, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, 'Rp ' . number_format($data->claim, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($data->total_claim, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($data->pph, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Rp ' . number_format($data->grand_total, 0, "", "."));
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow = $numrow + 1; // Tambah 1 setiap kali looping
            $numrow2 = $numrow2 + 2;
        }

        $total = $numrow + 1;
        $total2 = $numrow + 2;
        $sebesar = $numrow + 3;
        $terbilang = $numrow + 4;
        $ttd = $numrow + 4;
        $ttd_bottom = $ttd + 3;
        $ttd_periksa = $ttd_bottom + 1;


        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->qty_awal);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->qty_akhir);
        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_kotor_replas, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_claim, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_pph, 0, "", "."));
        $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);




        $excel->setActiveSheetIndex(0)->setCellValue('O' . $total, 'Sangu Jalan');
        $excel->getActiveSheet()->mergeCells('O' . $total . ':P' . $total); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('O' . $total2 . ':P' . $total2); // Set Merge Cell pada kolom A1 sampai E1
        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total, 'Rp ' . number_format($detail_kwitansi->uang_sangu, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('O' . $total2, 'Total');
        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total2, 'Rp ' . number_format($detail_kwitansi->grand_total_transporter, 0, "", "."));
        $excel->getActiveSheet()->getStyle('P' . $total)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('O' . $total)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q' . $total)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('P' . $total)->applyFromArray($bg_yellow);
        $excel->getActiveSheet()->getStyle('Q' . $total)->applyFromArray($bg_yellow);
        $excel->getActiveSheet()->getStyle('O' . $total)->applyFromArray($bg_yellow);

        $excel->getActiveSheet()->getStyle('P' . $total2)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('O' . $total2)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q' . $total2)->applyFromArray($style_row);

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total_transporter, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $terbilang, '(' . ucwords(terbilang($detail_kwitansi->grand_total_transporter)) . ' Rupiah)');
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setItalic(TRUE);
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setSize(10); 


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $terbilang . ':' . 'E' . $terbilang); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setSize(16); 
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setItalic(TRUE);


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'HANAFI');
        $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Disetujui oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, 'ABDULLAH');
        $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $detail_kwitansi->nama_supir . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function cek_kwitansi_supir()
    {
        $bulan = $this->input->POST('bulan');
        $tahun = $this->input->POST('tahun');
        $truck = $this->input->POST('truck');
        $kwitansi = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi_transporter_periode WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$truck'")->row();

        if (!$kwitansi) {
            echo json_encode(array(
                "status" => 'FALSE'
            ));
        } else {
            echo json_encode(array(
                "status" => 'TRUE'
            ));
        }
    }

    public function print_rekap_transporter_periode($bulan, $tahun, $id_truck, $id_supir)
    {
        $data = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi_transporter_periode WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$id_truck' and id_supir = '$id_supir'")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $color_red = array('font' => array('bold' => true, 'color' => array('rgb' => 'ff0015')));
        $style_col = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_header = array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '44777b')
            )
        );

        // $excel->getActiveSheet()->getStyle('Q5')->applyFromArray(
        //     array(
        //         'fill' => array(
        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
        //             'color' => array('rgb' => 'ff6372')
        //         )
        //     )
        // );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('B1', "CV. RAJA WALI SAMPIT");
        $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(18); 

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "JL. WENGGA JAYA AGUNG JALUR IV NO.378 SAMPIT");
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); 

        $excel->setActiveSheetIndex(0)->setCellValue('B3', "REKAPITULASI RETASI SOPIR");
        $excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(16); 

        $excel->setActiveSheetIndex(0)->setCellValue('Q2', "NAMA SUPIR");
        $excel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q2')->getFont()->setSize(14); 
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Set width kolom B

        $excel->setActiveSheetIndex(0)->setCellValue('R2', $data->nama_supir);
        $excel->getActiveSheet()->getStyle('R2')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('R2')->getFont()->setSize(14); 
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom B

        $excel->setActiveSheetIndex(0)->setCellValue('Q3', "NO. POLISI");
        $excel->getActiveSheet()->getStyle('Q3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q3')->getFont()->setSize(14); 

        $excel->setActiveSheetIndex(0)->setCellValue('R3', "$data->nopol");
        $excel->getActiveSheet()->getStyle('R3')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('R3')->getFont()->setSize(14); 

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);

        $excel->setActiveSheetIndex(0)->setCellValue('B4', "TGL");
        $excel->getActiveSheet()->mergeCells('B4:B5');
        $excel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('C4', "KEGIATAN");
        $excel->getActiveSheet()->mergeCells('C4:C5');
        $excel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getStyle('C4')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('D4', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "SATUAN");
        $excel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('E4', "TONASE");
        $excel->getActiveSheet()->mergeCells('E4:F4');
        $excel->getActiveSheet()->getStyle('E4:F4')->applyFromArray($style_header);
        $excel->getActiveSheet()->getStyle('E4')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('E5', "AWAL");
        $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(8); // Set width kolom B
        $excel->getActiveSheet()->getStyle('E5')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('F5', "AKHIR");
        $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(8); // Set width kolom B
        $excel->getActiveSheet()->getStyle('F5')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('G4', "SUSUT");
        $excel->getActiveSheet()->mergeCells('G4:G5');
        $excel->getActiveSheet()->getStyle('G4:G5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $excel->getActiveSheet()->getStyle('G4')->getFont()->setSize(10);

        $excel->setActiveSheetIndex(0)->setCellValue('H4', "HASIL RETASI");
        $excel->setActiveSheetIndex(0)->setCellValue('H5', "Rp.");
        $excel->getActiveSheet()->getStyle('H4:H5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $excel->getActiveSheet()->getStyle('H4')->getFont()->setSize(10);

        $excel->setActiveSheetIndex(0)->setCellValue('I4', "DANA OPRS");
        $excel->setActiveSheetIndex(0)->setCellValue('I5', "Rp.");
        $excel->getActiveSheet()->getStyle('I4:I5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $excel->getActiveSheet()->getStyle('I4')->getFont()->setSize(10);

        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);

        $excel->setActiveSheetIndex(0)->setCellValue('K4', "TGL");
        $excel->getActiveSheet()->mergeCells('K4:K5');
        $excel->getActiveSheet()->getStyle('K4:K5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $excel->getActiveSheet()->getStyle('K4')->getFont()->setSize(10);

        $excel->setActiveSheetIndex(0)->setCellValue('L4', "PINJAMAN");
        $excel->getActiveSheet()->mergeCells('L4:L5');
        $excel->getActiveSheet()->getStyle('L4:L5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $excel->getActiveSheet()->getStyle('L4')->getFont()->setSize(10);

        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(3);

        $excel->setActiveSheetIndex(0)->setCellValue('N4', "TANGGAL");
        $excel->getActiveSheet()->mergeCells('N4:N5');
        $excel->getActiveSheet()->getStyle('N4:N5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $excel->getActiveSheet()->getStyle('N4')->getFont()->setSize(10);

        $excel->setActiveSheetIndex(0)->setCellValue('O4', "JENIS PEMELIHARAAN / PERBAIKAN");
        $excel->getActiveSheet()->mergeCells('O4:R5');
        $excel->getActiveSheet()->getStyle('O4:R5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getStyle('O4')->getFont()->setSize(10);

        $excel->setActiveSheetIndex(0)->setCellValue('S4', "JUMLAH");
        $excel->getActiveSheet()->mergeCells('S4:S5');
        $excel->getActiveSheet()->getStyle('S4:S5')->applyFromArray($style_header);
        $excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $excel->getActiveSheet()->getStyle('S4')->getFont()->setSize(10);

        $kwitansi = $this->rms_model->get("v_kwitansi_transporter", "WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$id_truck' and id_supir = '$id_supir' ORDER BY tanggal_input ASC")->result();
        $numrow = 6;
        $numrow2 = 7;
        foreach ($kwitansi as $data2) {
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, 'DANA OPERASIONAL');
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($color_red);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, 'Rp ' . number_format($data2->uang_sangu, 0, "", "."));
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($color_red);

            $item_kwitansi = $this->rms_model->get("v_generate_kwitansi_transporter", "WHERE id_kwitansi = '$data2->id_kwitansi' ORDER BY tanggal_bongkar ASC")->result();
            foreach ($item_kwitansi as $data3) {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow2, mediumdate_indo($data3->tanggal_bongkar));
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow2, 'ANGKUT ' . $data3->komoditas . ' ' . $data3->kode_tujuan);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow2, 'Rp ' . number_format($data3->harga, 0, "", "."));
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow2, $data3->timbang_kebun_kg);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow2, $data3->qty_kirim_kg);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow2, $data3->m_susut);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow2, 'Rp ' . number_format($data3->grand_total, 0, "", "."));
                $numrow2 = $numrow2 + 1;
            }
            $numrow = $numrow + 2;
        }


        $pinjaman = $this->rms_model->get("v_pinjaman", "WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$id_truck' and id_supir = '$id_supir'")->result();
        $numrow3 = 6;
        foreach ($pinjaman as $pinjaman) {
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow3, mediumdate_indo($pinjaman->tanggal));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow3, 'Rp ' . number_format($pinjaman->jumlah_pinjaman, 0, "", "."));
            $numrow3 = $numrow3 + 1;
        }

        $perbaikan = $this->rms_model->get("v_perbaikan", "WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$id_truck' and id_supir = '$id_supir'")->result();
        $numrow4 = 6;
        foreach ($perbaikan as $perbaikan) {
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow4, mediumdate_indo($perbaikan->tanggal_perbaikan));
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow4, $perbaikan->jenis_perbaikan);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow4, 'Rp ' . number_format($perbaikan->jumlah, 0, "", "."));
            $numrow4 = $numrow4 + 1;
        }

        $excel->setActiveSheetIndex(0)->setCellValue('B45', "RETASI TOTAL");
        $excel->getActiveSheet()->getStyle('B45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->setActiveSheetIndex(0)->setCellValue('H45', 'Rp ' . number_format($data->total_pendapatan, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('I45', 'Rp ' . number_format($data->total_operasional, 0, "", "."));
        $excel->getActiveSheet()->mergeCells('B45:G45');
        $excel->getActiveSheet()->getStyle('B45:G45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B6:I45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('H45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('H45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('I45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('I45')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('K45', "TOTAL");
        $excel->getActiveSheet()->getStyle('B45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->setActiveSheetIndex(0)->setCellValue('L45', 'Rp ' . number_format($data->total_pinjaman_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('K45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('L45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('L45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K6:L45')->applyFromArray($style_col);

        $excel->setActiveSheetIndex(0)->setCellValue('N45', "TOTAL");
        $excel->getActiveSheet()->mergeCells('N45:R45');
        $excel->getActiveSheet()->getStyle('N45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->setActiveSheetIndex(0)->setCellValue('S45', 'Rp ' . number_format($data->total_perbaikan, 0, "", "."));
        $excel->getActiveSheet()->getStyle('N45:S45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('N45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('S45')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('S45')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('N6:S45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N45:R45')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('S45')->applyFromArray($style_col);




        $excel->setActiveSheetIndex(0)->setCellValue('B48', "TOTAL PENDAPATAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D48', 'Rp ' . number_format($data->total_pendapatan, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B48')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D48')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('B49', "TOTAL OPERASIONAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D49', 'Rp ' . number_format($data->total_operasional, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B49')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B49')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D49')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D49')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('B50', "TOTAL PENDAPATAN BERSIH");
        $excel->setActiveSheetIndex(0)->setCellValue('D50', 'Rp ' . number_format($data->total_pendapatan_bersih, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B50')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B50')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D50')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D50')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('B51', "TOTAL PREMI" . $data->premi_supir . "%");
        $excel->setActiveSheetIndex(0)->setCellValue('D51', 'Rp ' . number_format($data->total_premi_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B51')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B51')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D51')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D51')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('B52', "TOTAL PINJAMAN");
        $excel->setActiveSheetIndex(0)->setCellValue('D52', 'Rp ' . number_format($data->total_pinjaman_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B52')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D52')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('B53', "TOTAL PREMI BERSIH");
        $excel->setActiveSheetIndex(0)->setCellValue('D53', 'Rp ' . number_format($data->total_premi_bersih, 0, "", "."));
        $excel->getActiveSheet()->getStyle('B53')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('B53')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D53')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('D53')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G48', "TOTAL PENDAPATAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K48', 'Rp ' . number_format($data->total_pendapatan, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G48')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K48')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G49', "TOTAL OPERASIONAL");
        $excel->setActiveSheetIndex(0)->setCellValue('K49', 'Rp ' . number_format($data->total_operasional, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G49')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G49')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K49')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K49')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G50', "TOTAL PERBAIKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K50', 'Rp ' . number_format($data->total_perbaikan, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G50')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G50')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K50')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K50')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G51', "CICILAN DT");
        $excel->setActiveSheetIndex(0)->setCellValue('K51', 'Rp ' . number_format($data->cicilan_truck, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G51')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G51')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K51')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K51')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G52', "TOTAL PREMI SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('K52', 'Rp ' . number_format($data->total_premi_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G52')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K52')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('G53', "TOTAL PENDAPATAN DT");
        $excel->setActiveSheetIndex(0)->setCellValue('K53', 'Rp ' . number_format($data->total_pendapatan_bersih, 0, "", "."));
        $excel->getActiveSheet()->getStyle('G53')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('G53')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('K53')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('K53')->getFont()->setBold(TRUE);


        $excel->setActiveSheetIndex(0)->setCellValue('O47', 'Sampit,');
        $excel->getActiveSheet()->mergeCells('O47:R47');
        $excel->getActiveSheet()->getStyle('O47')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('O47')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('O47')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('O48', 'Direkap Oleh');
        $excel->getActiveSheet()->getStyle('O48')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('O48:P48');
        $excel->setActiveSheetIndex(0)->setCellValue('O52', 'HANAFI');
        $excel->getActiveSheet()->mergeCells('O52:P52');
        $excel->getActiveSheet()->getStyle('O48:P48')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O48:P53')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O52')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('O48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('O48')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('O52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('O52')->getFont()->setBold(TRUE);

        $excel->setActiveSheetIndex(0)->setCellValue('Q48', 'Supir');
        $excel->getActiveSheet()->getStyle('Q48')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('Q48:R48');
        $excel->setActiveSheetIndex(0)->setCellValue('Q52', $data->nama_supir);
        $excel->getActiveSheet()->mergeCells('Q52:R52');
        $excel->getActiveSheet()->getStyle('Q48:R48')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q48:R53')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q52')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('Q48')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('Q48')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('Q52')->getFont()->setSize(10);
        $excel->getActiveSheet()->getStyle('Q52')->getFont()->setBold(TRUE);


        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);




        // $total = $numrow + 1;
        // $total2 = $numrow + 2;
        // $sebesar = $numrow + 3;
        // $terbilang = $numrow + 4;
        // $ttd = $numrow + 4;
        // $ttd_bottom = $ttd + 3;
        // $ttd_periksa = $ttd_bottom + 1;


        // $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        // $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->qty_awal);
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->qty_akhir);
        // $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_kotor_replas, 0, "", "."));
        // $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_claim, 0, "", "."));
        // $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_pph, 0, "", "."));
        // $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);




        // $excel->setActiveSheetIndex(0)->setCellValue('P' . $total, 'Sangu Jalan');
        // $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total, 'Rp ' . number_format($detail_kwitansi->uang_sangu, 0, "", "."));
        // $excel->setActiveSheetIndex(0)->setCellValue('P' . $total2, 'Total');
        // $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total2, 'Rp ' . number_format($detail_kwitansi->grand_total_transporter, 0, "", "."));
        // $excel->getActiveSheet()->getStyle('P' . $total)->applyFromArray($style_row);
        // $excel->getActiveSheet()->getStyle('Q' . $total)->applyFromArray($style_row);

        // $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        // $excel->setActiveSheetIndex(0)->setCellValue('C' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total_transporter, 0, "", "."));
        // $excel->setActiveSheetIndex(0)->setCellValue('C' . $terbilang, '(' . ucwords(terbilang($detail_kwitansi->grand_total_transporter)) . ' Rupiah)');
        // $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setItalic(TRUE);
        // $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setSize(10); 


        // $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        // $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        // $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->mergeCells('C' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->mergeCells('C' . $terbilang . ':' . 'E' . $terbilang); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setBold(TRUE);
        // $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setSize(16); 
        // $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setItalic(TRUE);


        // $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        // $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'HANAFI');
        // $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        // $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        // $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        // $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        // $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Disetujui oleh');
        // $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, 'ABDULLAH');
        // $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        // $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        // $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $data->nama_supir . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function print_kwitansi_transporter_periode($bulan, $tahun, $id_truck, $id_supir)
    {
        $data = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi_transporter_periode WHERE periode_bulan = '$bulan' and periode_tahun = '$tahun' and id_truck = '$id_truck' and id_supir = '$id_supir'")->row();
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $excel->setActiveSheetIndex(0)->setCellValue('K2', "Lembar 1");
        $excel->getActiveSheet()->getStyle('K2')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('K3', "RWS");
        $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KWITANSI");
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('B4:K4'); // Set Merge Cell pada kolom A1 sampai E1

        
        $excel->setActiveSheetIndex(0)->setCellValue('B6', "Sudah terima dari");
        $excel->setActiveSheetIndex(0)->setCellValue('C6', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('B7', "Untuk Pembayaran");
        $excel->setActiveSheetIndex(0)->setCellValue('D6', "CV. RAJA WALI  SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('D7', "RETASI SOPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', $data->nopol);
        $excel->setActiveSheetIndex(0)->setCellValue('E8', $data->nama_supir);

        $excel->setActiveSheetIndex(0)->setCellValue('D9', "TOTAL PENDAPATAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K9', 'Rp ' . number_format($data->total_pendapatan, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('D10', "TOTAL OPERASIONAL");
        $excel->setActiveSheetIndex(0)->setCellValue('K10', 'Rp ' . number_format($data->total_operasional, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('D11', "TOTAL PENDAPATAN BERSIH");
        $excel->setActiveSheetIndex(0)->setCellValue('K11', 'Rp ' . number_format($data->total_pendapatan_bersih, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('D12', "TOTAL PREMI " . $data->premi_supir . "%");
        $excel->setActiveSheetIndex(0)->setCellValue('K12', 'Rp ' . number_format($data->total_premi_supir, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('D13', "TOTAL PINJAMAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K13', 'Rp ' . number_format($data->total_pinjaman_supir, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('D14', "TOTAL PREMI BERSIH");
        $excel->setActiveSheetIndex(0)->setCellValue('K14', 'Rp ' . number_format($data->total_premi_bersih, 0, "", "."));

        $excel->setActiveSheetIndex(0)->setCellValue('J16', "JUMLAH");
        $excel->setActiveSheetIndex(0)->setCellValue('K16', 'Rp ' . number_format($data->total_premi_bersih, 0, "", "."));


        $excel->setActiveSheetIndex(0)->setCellValue('B17', "SEBESAR");
        $excel->setActiveSheetIndex(0)->setCellValue('C17', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('D17', 'Rp ' . number_format($data->total_premi_bersih, 0, "", "."));
        $excel->getActiveSheet()->getStyle('D17')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D17')->getFont()->setSize(16); 

        $excel->setActiveSheetIndex(0)->setCellValue('B18', "TERBILANG");
        $excel->setActiveSheetIndex(0)->setCellValue('C18', ":");
        $excel->setActiveSheetIndex(0)->setCellValue('D18', '(' . ucwords(terbilang(number_format($data->total_premi_bersih, 0, "", ""))) . ' Rupiah)');
        $excel->getActiveSheet()->getStyle('D18')->getFont()->setItalic(TRUE);
        $excel->getActiveSheet()->getStyle('D18')->getFont()->setSize(10); 

        $excel->setActiveSheetIndex(0)->setCellValue('F20', 'Sampit,');
        $excel->setActiveSheetIndex(0)->setCellValue('F21', 'Diajukan Oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('F27', 'HANAFI');
        $excel->getActiveSheet()->mergeCells('F21:H21'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('F27:H27'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('F21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('F27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('F21')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('F21:H27')->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('F21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('F21')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('I21', 'Yang menerima');
        $excel->setActiveSheetIndex(0)->setCellValue('I27', $data->nama_supir);
        $excel->getActiveSheet()->mergeCells('I21:K21'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('I27:K27'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('I21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('I27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('I21')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('I21:K27')->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('I21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('I21')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1



        // $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(2);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Kwitansi Periode " . bulan($bulan) . " " . $tahun);
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Kwitansi Periode ' . $data->nama_supir . ' ' . bulan($bulan) . ' ' . $tahun . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function print_kwitansi_non_do($id_vendor)
    {

        $detail_kwitansi = $this->rms_model->get_by_query("SELECT *, SUM(total_supir) AS grand_total_supir, SUM(qty) AS total_qty FROM v_rekap_non_do WHERE id_vendor = '$id_vendor' GROUP BY id_vendor")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );

        $excel->getActiveSheet()->getStyle('O3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffe100')
                )
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "KWITANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "CV RAJA WALI SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "Untuk Pembayaran");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "GROUP");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', $detail_kwitansi->vendor);
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "NO HP");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', $detail_kwitansi->no_hp);
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "NO REK");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', $detail_kwitansi->bank . ' ' . $detail_kwitansi->no_rekening . ' a/n ' . $detail_kwitansi->nama_rekening);
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "NOMOR KWITANSI : ");

        $excel->getActiveSheet()->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A4:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('O3:Q3'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G6:K6'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G5:K5'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G4:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A2:Q2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); 
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); 
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
        
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "TGL");
        $excel->setActiveSheetIndex(0)->setCellValue('C8', "QTY AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "QTY AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('F8', "NOPOL");
        $excel->setActiveSheetIndex(0)->setCellValue('G8', "ANGKUT");
        $excel->setActiveSheetIndex(0)->setCellValue('H8', "TUJUAN");
        $excel->setActiveSheetIndex(0)->setCellValue('I8', "M");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "C");
        $excel->setActiveSheetIndex(0)->setCellValue('K8', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('L8', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M8', "CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('N8', "TTL CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('O8', "Pph %");
        $excel->setActiveSheetIndex(0)->setCellValue('P8', "ADM");
        $excel->setActiveSheetIndex(0)->setCellValue('Q8', "SANGO");
        $excel->setActiveSheetIndex(0)->setCellValue('R8', "GRAND TOTAL");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('R8')->applyFromArray($style_col);

        $kwitansi = $this->rms_model->get("v_rekap_non_do", "WHERE id_vendor = '$id_vendor'")->result();


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 9;
        $numrow2 = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($kwitansi as $data) { // Lakukan looping pada variabel siswa

            if ($data->jenis_pajak == 'skb') {
                $pph = '0.5%';
                $jenis_pajak = "SKB";
            } elseif ($data->jenis_pajak == 'ktp') {
                $pph = '4%';
                $jenis_pajak = "KTP";
            } elseif ($data->jenis_pajak == 'npwp') {
                $pph = '2%';
                $jenis_pajak = "NPWP";
            }

            $old_date = $data->tanggal_input;
            $old_date_timestamp = strtotime($old_date);

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo(date('Y-m-d', $old_date_timestamp)));
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->qty);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->qty);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->komoditas);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->kode_tujuan);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Rp ' . number_format($data->harga_supir, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($data->total_harga_supir, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($data->uang_sangu, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Rp ' . number_format($data->potongan, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, 'Rp ' . number_format($data->total_supir, 0, "", "."));
            //$excel->setActiveSheetIndex(0)->insertNewRowBefore(2,1); 

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
            $numrow2 = $numrow2 + 2;
        }

        $sebesar = $numrow + 3;
        $ttd = $numrow + 4;
        $ttd_bottom = $ttd + 3;
        $ttd_periksa = $ttd_bottom + 1;


        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->total_qty);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->total_qty);
        $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);





        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Total');
        $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, 'Rp ' . number_format($detail_kwitansi->grand_total_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total_supir, 0, "", "."));


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('D' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setSize(16); 
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setItalic(TRUE);


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'SAURINA');
        $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Diterima oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, $detail_kwitansi->vendor);
        $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $detail_kwitansi->vendor . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }



    public function get_invoice()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_invoice", "WHERE id_invoice = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    function generate_kwitansi()
    {
        $data['kwitansi'] = $this->rms_model->get("v_rekap", "WHERE status = '0'")->result();
        $data['content'] = 'rms/kwitansi/generate';
        $this->load->view('rms/includes/template', $data);
    }

    function save_generate_kwitansi()
    {
        $id_rekap = $this->input->POST('id_rekap_invoice');
        $no_kwitansi = $this->input->POST('no_invoice');
        $projectArray = explode(',', $id_rekap);
        $data = array(
            'no_kwitansi' => $no_kwitansi,
            'status' => '0',
        );

        $save_invoice = $this->rms_model->insert_id("tbl_kwitansi", $data);
        for ($i = 0; $i < count($projectArray); $i++) {

            $item = array('no_kwitansi' => $no_kwitansi, 'id_rekap' => $projectArray[$i], 'id_kwitansi' => $save_invoice);
            $this->rms_model->insert("tbl_generate_kwitansi", $item);
        }
        if ($save_invoice) {

            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    function save_generate_kwitansi_transporter()
    {
        $id_rekap = $this->input->POST('id_rekap_invoice');
        $uang_sangu = $this->input->POST('uang_sangu');
        $bulan = $this->input->POST('bulan');
        $tahun = $this->input->POST('tahun');
        $projectArray = explode(',', $id_rekap);
        $data = array(
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'uang_sangu' => str_replace('.', '', $uang_sangu),
            'status' => '0',
        );

        $save_invoice = $this->rms_model->insert_id("tbl_kwitansi_transporter", $data);
        for ($i = 0; $i < count($projectArray); $i++) {

            $item = array('id_rekap' => $projectArray[$i], 'id_kwitansi' => $save_invoice);
            $this->rms_model->insert("tbl_generate_kwitansi_transporter", $item);
        }
        if ($save_invoice) {

            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function generate_invoice()
    {
        $data['invoice'] = $this->rms_model->get("v_project")->result();
        $data['content'] = 'rms/invoice/generate';
        $this->load->view('rms/includes/template', $data);
    }

    function save_generate_invoice()
    {
        $id_project = $this->input->POST('id_project_invoice');
        $no_invoice = $this->input->POST('no_invoice');
        $remark = $this->input->POST('remark');
        $tanggal_invoice = $this->input->POST('tanggal_invoice');
        $pph = $this->input->POST('pph');
        $ppn = $this->input->POST('ppn');

        $projectArray = explode(',', $id_project);
        $data_project = array(
            'status' => '2',
            'pph' => $pph,
            'ppn' => $ppn,
        );

        $data = array(
            'no_invoice' => $no_invoice,
            'remark' => $remark,
            'tanggal_invoice' => $tanggal_invoice,
            'ppn' => $ppn,
            'pph' => $pph,
            'status' => '0',
        );

        $save_invoice = $this->rms_model->insert_id("tbl_invoice", $data);
        for ($i = 0; $i < count($projectArray); $i++) {

            $item = array('no_invoice' => $no_invoice, 'id_project' => $projectArray[$i], 'id_invoice' => $save_invoice);
            $this->rms_model->insert("tbl_generate_invoice", $item);
            $this->rms_model->update("tbl_project", $data_project, $projectArray[$i]);
        }
        if ($save_invoice) {

            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    function invoice()
    {
        $data['invoice'] = $this->rms_model->get("v_invoice")->result();
        $data['content'] = 'rms/invoice/index';
        $this->load->view('rms/includes/template', $data);
    }


    function cetak_invoice($id)
    {

        $data['invoice'] = $this->rms_model->get("v_invoice", "WHERE id_invoice = '$id'")->row();
        $no_invoice = $data['invoice']->no_invoice;
        $data['project'] = $this->rms_model->get("v_generate_invoice", "WHERE no_invoice = '$no_invoice'")->result();

        $this->load->library('pdf');
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $cetak_no = str_replace('/', '-', $no_invoice);
        $html = $this->load->view('rms/invoice/pdf', $data, true);
        $filename = "INVOICE(" . $cetak_no . ").pdf";
        $this->pdf->createPDF($html, $filename, true);
    }

    function view_invoice($id)
    {
        $data['pembayaran_invoice'] = $this->rms_model->get("tbl_pembayaran_invoice a", "LEFT JOIN tbl_invoice b ON a.id_invoice = b.id WHERE a.id_invoice = '$id'")->result();
        $data['invoice'] = $this->rms_model->get("v_invoice", "WHERE id_invoice = '$id'")->row();
        $data['content'] = 'rms/invoice/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function download_replas($id_project)
    {
        $data_replas = $this->rms_model->get_by_query("SELECT * FROM v_rekap WHERE id_project = '$id_project'")->result();
        $data_project = $this->rms_model->get_by_query("SELECT * FROM v_project WHERE id_project = '$id_project'")->row();
        //var_dump($data_project); exit;
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col_yellow = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffe100')
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_col_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP $data_project->komoditas $data_project->nama_perusahaan");
        $excel->getActiveSheet()->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); 
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->getActiveSheet()->mergeCells('A3:A4');
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        $excel->setActiveSheetIndex(0)->setCellValue('B3', "TGL MUAT");
        $excel->getActiveSheet()->mergeCells('B3:B4');
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);

        if ($data_project->id_klien == '8' || $data_project->id_klien == '9' || $data_project->id_klien == '16') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO KONTRAK");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO TIKET");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        } elseif ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO DO");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO STO");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        }

        if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {

            $excel->setActiveSheetIndex(0)->setCellValue('C3', "SUPIR");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NOPOL");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('E3', "QTY AWAL");
            if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                $excel->setActiveSheetIndex(0)->setCellValue('H3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('E3:G3');
                $excel->getActiveSheet()->mergeCells('H3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('E4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('F4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "NETTO");
                $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('H4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "NETTO");
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);

                if ($data_project->id_komoditas == '3') {
                    $excel->setActiveSheetIndex(0)->setCellValue('L3', "NILAI TERENDAH");
                    $excel->getActiveSheet()->mergeCells('L3:L4');
                    $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('M3', "OA/KG");
                    $excel->getActiveSheet()->mergeCells('M3:M4');
                    $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('N3', "BIAYA ANGKUT");
                    $excel->getActiveSheet()->mergeCells('N3:N4');
                    $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('O3', "CLAIM");
                    $excel->getActiveSheet()->mergeCells('O3:O4');
                    $excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('O4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('P3', "TOTAL CLAIM");
                    $excel->getActiveSheet()->mergeCells('P3:P4');
                    $excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('P4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('Q3', "TOTAL");
                    $excel->getActiveSheet()->mergeCells('Q3:Q4');
                    $excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_col);
                }
            } else {
                $excel->getActiveSheet()->mergeCells('G3:H3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "KG");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->setActiveSheetIndex(0)->setCellValue('I3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('I3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "KG");
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "SUPIR");
            $excel->getActiveSheet()->mergeCells('E3:E4');
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('F3', "NOPOL");
            $excel->getActiveSheet()->mergeCells('F3:F4');
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('G3', "QTY AWAL");
            if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                $excel->setActiveSheetIndex(0)->setCellValue('J3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('G3:I3');
                $excel->getActiveSheet()->mergeCells('J3:L3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "NETTO");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('J4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('K4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('L4', "NETTO");
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('M3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('M3:M4');
                $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
            } else {
                $excel->getActiveSheet()->mergeCells('G3:H3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "KG");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->setActiveSheetIndex(0)->setCellValue('I3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('I3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "KG");
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
            }
        }


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data_replas as $data) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo($data->tanggal_muat));
            if ($data_project->id_klien == '8' || $data_project->id_klien == '9' || $data_project->id_klien == '16') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->no_kontrak);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->no_tiket);
            } elseif ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->no_do);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->no_sto);
            }

            if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_supir);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->nopol);
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->bruto_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->tarra_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->bruto_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->tarra_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->m_susut);
                    if ($data_project->id_komoditas == '3') {
                        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->qty_terendah);
                        $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->harga_unit);
                        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->harga_qty_terendah);
                        if ($data->total_claim_invoice == NULL || $data->total_claim_invoice == "" ||  $data->total_claim_invoice == '0') {
                            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '0');
                        } else {
                            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->claim_invoice);
                        }
                        $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->total_claim_invoice);
                        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->total_invoice);
                    }
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->timbang_kebun_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->qty_kirim_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->m_susut);
                }
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->bruto_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->tarra_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->bruto_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->tarra_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->m_susut);
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->timbang_kebun_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->qty_kirim_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->m_susut);
                }
            }

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);

            if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
                $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            }

            if ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
                }
            }

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }




        if ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
            if ($data_project->id_komoditas == '2') {

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, 'Total');
                $excel->getActiveSheet()->getStyle('A' . $numrow . ':M' . $numrow)->applyFromArray($style_col_yellow);
                $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_bruto_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_tarra_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_bruto_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_project->total_tarra_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_project->total_qty_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data_project->total_susut);
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, 'Total');
                $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
                $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
            }
        }

        // if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
        //     $excel->getActiveSheet()->mergeCells('A' . $numrow . ':D' . $numrow);

        //     if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {

        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data_project->total_bruto_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data_project->total_tarra_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_bruto_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_tarra_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     } else {
        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     }
        // } else {
        //     $excel->getActiveSheet()->mergeCells('A' . $numrow . ':F' . $numrow);

        //     if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {

        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':M' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_bruto_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_tarra_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_bruto_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_project->total_tarra_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_project->total_qty_akhir);
        //     } else {
        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     }
        // }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("REKAP $data_project->komoditas");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="REKAP ' . $data_project->komoditas . ' ' . $data_project->nama_perusahaan . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function pajak_replas()
    {

        $data['content'] = 'rms/laporan/pajak_replas';
        $this->load->view('rms/includes/template', $data);
    }

    public function laporan_replas()
    {
        $data['content'] = 'rms/laporan/replas';
        $this->load->view('rms/includes/template', $data);
    }


    public function cek_laporan_replas($start_date, $end_date)
    {
        $replas = $this->rms_model->get("v_kwitansi", "WHERE tanggal_input BETWEEN '$start_date' AND '$end_date' ORDER BY tanggal_input ASC")->result();
        if (!$replas) {
            echo json_encode(array(
                "status" => 'FALSE'
            ));
        } else {
            echo json_encode(array(
                "status" => 'TRUE'
            ));
        }
    }

    function generate_laporan_replas($start_date, $end_date)
    {
        if ($start_date == $end_date) {
            $data['periode'] = shortdate_indo($start_date);
        } else {
            $data['periode'] = shortdate_indo($start_date) . ' - ' . shortdate_indo($end_date);
        }
        $data['replas'] = $this->rms_model->get("v_kwitansi", "WHERE tanggal_input between '$start_date' and '$end_date' ORDER BY no_kwitansi ASC")->result();
        $data['total'] = $this->rms_model->get_by_query("SELECT SUM(grand_total) as total_biaya_replas FROM v_kwitansi WHERE tanggal_input between '$start_date' and '$end_date'")->row();
        $this->load->library('pdf');
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $cetak_no = str_replace('/', '-', $no_invoice);
        $html = $this->load->view('rms/laporan/replas_pdf', $data, true);
        $filename = "LAPORAN REPLAS (" . $data['periode'] . ").pdf";
        $this->pdf->createPDF($html, $filename, true);
    }



    public function cek_laporan_pajak_replas()
    {
        $bulan = $this->input->POST('bulan');
        $tahun = $this->input->POST('tahun');
        $jenis = $this->input->POST('jenis');
        $no_pajak = $this->rms_model->get_by_query("SELECT *, SUM(total) as total_biaya_replas, SUM(pph) as total_pot_pph FROM v_laporan_pajak_replas WHERE Year(tanggal_input) = '$tahun' and Month(tanggal_input) = '$bulan' and jenis_pajak = '$jenis' GROUP BY no_pajak ORDER BY jenis_pajak ASC")->result();

        if (!$no_pajak) {
            echo json_encode(array(
                "status" => 'FALSE'
            ));
        } else {
            echo json_encode(array(
                "status" => 'TRUE'
            ));
        }
    }

    public function generate_laporan_pajak_replas($bulan, $tahun, $jenis)
    {

        $no_pajak = $this->rms_model->get_by_query("SELECT *, SUM(total) as total_biaya_replas, SUM(pph) as total_pot_pph FROM v_laporan_pajak_replas WHERE Year(tanggal_input) = '$tahun' and Month(tanggal_input) = '$bulan' and jenis_pajak = '$jenis' GROUP BY no_pajak ORDER BY jenis_pajak ASC")->result();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan pajak");
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO NPWP");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA PAJAK");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "JENIS PAJAK");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "POT PPH");


        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($no_pajak as $data) { // Lakukan looping pada variabel siswa

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data->no_pajak);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->nama_pajak);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->jenis_pajak);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, 'Rp ' . number_format($data->total_biaya_replas, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 'Rp ' . number_format($data->total_pot_pph, 0, "", "."));

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

            // if ($data->total_jum_replas > '1') {

            //     $cellmerge = 'A' . $numrow . ':A' . $merge;
            //     $excel->getActiveSheet()->mergeCells($cellmerge); // Set Merge Cell pada kolom A1 sampai E1
            // }

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Pajak " . bulan($bulan) . " " . $tahun);
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Rekap Pajak ' . $jenis . ' ' . bulan($bulan) . ' ' . $tahun . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }



    function kwitansi_transporter_periode()
    {
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE kategori = '1'")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '1'")->result();
        $data['content'] = 'rms/kwitansi_supir/index';
        $this->load->view('rms/includes/template', $data);
    }

    function rekap_transporter_periode()
    {
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE kategori = '1'")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '1'")->result();
        $data['content'] = 'rms/rekap/rekap_periode';
        $this->load->view('rms/includes/template', $data);
    }

    function kwitansi_transporter_data()
    {
        $data['kwitansi'] = $this->rms_model->get("v_kwitansi_transporter")->result();
        $data['content'] = 'rms/kwitansi_supir/kwitansi';
        $this->load->view('rms/includes/template', $data);
    }





















    public function menu()
    {
        $data['product'] = $this->admin_model->get("tbl_menu", "ORDER BY position ASC")->result();
        $tree = $this->prepareList($data['product']);

        $data['li'] = $this->nav($tree);
        $data['content'] = 'rms/menu/index';
        $this->load->view('rms/includes/template', $data);
    }

    function prepareList(array $items, $pid = 0)
    {
        $output = array();
        foreach ($items as $item) {
            if ((int) $item->parent == $pid) {
                if ($children = $this->prepareList($items, $item->id)) {
                    $item->children = $children;
                }
                $output[] = $item;
            }
        }

        return $output;
    }

    function nav($menu_items, $child = false)
    {
        $output = '';
        if (count($menu_items) > 0) {
            $output .= ($child === false) ? '<ol class="dd-list">' : '<ol>';

            foreach ($menu_items as $item) {
                $output .= '<li class="dd-item" id="' . $item->id . '"  data-id="' . $item->id . '">';
                $output .= '<div class="dd-handle  box menu-box">' . $item->menu . '</div>';

                if (isset($item->children) && count($item->children)) {
                    $output .= '<div class="action-btn-box"><a href="javascript:void(0)" onclick="edit_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable mr-1"><i class="fa fa-edit"></i></a></div>';
                } else {
                    $output .= '<div class="action-btn-box"><a href="javascript:void(0)" onclick="edit_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable mr-1"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" onclick="delete_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable"><i class="fa fa-trash-o"></i></a></div>';
                }
                //check if there are any children
                if (isset($item->children) && count($item->children)) {
                    $output .= $this->nav($item->children, true);
                }
                $output .= '</li>';
            }
            $output .= '</ol>';
        }
        return $output;
    }

    public function update_menu_priority()
    {
        $data = $this->input->post("product_data");

        if (count($data)) {
            $update = $this->admin_model->update_priority_data($data);

            if ($update) {
                $result['status'] = "success";
            } else {
                $result['status'] = "error";
            }
        } else {
            $result['status'] = "error";
        }
        echo json_encode($result);
    }





    public function approve_petugas()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $data = array(
            'status' => '1'
        );
        $get_petugas = $this->admin_model->get("tbl_petugas", "WHERE id = '$id'")->row();
        $email = $get_petugas->email;
        $delete = $this->admin_model->update($tbl, $data, $id);
        if ($delete) {
            $send = $this->email_approve_petugas($email);
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    function email_approve_petugas($email)
    {
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'system.ditjalsus@gmail.com',  // Email gmail
            'smtp_pass'   => 'andinovid',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n",
        ];
        $message = '
                        <html><body>
						<p>Permohonan anda sebagai petugas daerah telah diapprove, silahkan login melalui link berikut <a href="' . base_url() . 'login/">' . base_url() . 'login/</a></p>
                        ';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('system.ditjalsus@gmail.com', 'Ditjalsus');
        $this->email->to($email, 'Petugas');
        $this->email->cc('andi.novid@gmail.com');
        $this->email->subject('Approval Petugas');
        $this->email->message($message);
        $this->email->send();
        echo $this->email->print_debugger();
    }


    public function pages()
    {
        $data['pages'] = $this->admin_model->get("tbl_content", "WHERE category = '1'")->result();
        $data['content'] = 'rms/pages/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function petugas()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.nama as kabupaten, c.nama as provinsi FROM tbl_petugas a LEFT JOIN wilayah_kabupaten b ON a.id_kabupaten = b.id LEFT JOIN wilayah_provinsi c ON a.id_provinsi = c.id ORDER BY a.status DESC")->result();
        $data['content'] = 'rms/petugas/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function survey1()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey1';
        $this->load->view('rms/includes/template', $data);
    }
    public function survey2()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey2 a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey2';
        $this->load->view('rms/includes/template', $data);
    }
    public function survey3()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey3 a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey3';
        $this->load->view('rms/includes/template', $data);
    }

    public function news()
    {
        $data['news'] = $this->admin_model->get_by_query("SELECT * FROM tbl_content WHERE category = '2'")->result();
        $data['content'] = 'rms/news/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function gallery()
    {
        $data['gallery'] = $this->admin_model->get_by_query("SELECT * FROM tbl_gallery")->result();
        $data['content'] = 'rms/gallery/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function users()
    {
        $data['users'] = $this->admin_model->get_by_query("SELECT * FROM tbl_users")->result();
        $data['content'] = 'rms/user/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_news()
    {
        $id = $_POST["id"];
        $category = $_POST["category"];
        $title = $_POST["title"];
        $slug = $_POST["slug"];
        $content = $_POST["content"];
        $image = $_FILES['image']['name'];
        $status = $_POST["status"];
        $time = date("Y-m-d H:i:s");

        if (empty($image)) {
            $data = array(
                'title' => $title,
                'content' => $content,
                'image' => '',
                'slug' => $slug,
                'created_date' => $time,
                'category' => $category,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'last_update' => $time,
                'category' => $category,
                'status' => $status,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $image);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'content' => $content,
                'image' => $filename,
                'slug' => $slug,
                'created_date' => $time,
                'category' => $category,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'content' => $content,
                'image' => $filename,
                'slug' => $slug,
                'last_update' => $time,
                'category' => $category,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_content", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_content", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_gallery()
    {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $image = $_FILES['image']['name'];
        $status = $_POST["status"];

        if (empty($image)) {
            $data = array(
                'title' => $title,
                'image' => '',
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'status' => $status,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $image);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'image' => $filename,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'image' => $filename,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_gallery", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_gallery", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_user()
    {
        $id = $_POST["id"];
        $title = $_POST["name"];
        $username = $_POST["username"];
        $password = md5($_POST["password_user"]);
        $status = $_POST["status"];

        $data = array(
            'name' => $title,
            'username' => $username,
            'password' => $password,
            'status' => $status,
        );

        if (empty($password)) {
            $data2 = array(
                'name' => $title,
                'username' => $username,
                'status' => $status,
            );
        } else {
            $data2 = array(
                'name' => $title,
                'username' => $username,
                'password' => $password,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_users", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_users", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }


    public function banner()
    {
        $data['content'] = 'rms/banner/index';
        $this->load->view('rms/includes/template', $data);
    }
    public function get_banner()
    {
        $data = $this->admin_model->get("tbl_banner", "WHERE id = 1");
        $detail = $data->result();
        echo json_encode($detail);
    }





    public function update_banner()
    {
        $id = '1';
        $title = $_POST["judul"];
        $description = $_POST["deskripsi"];
        $label_button = $_POST["label_button"];
        $file_pedoman = $_FILES['file_video']['name'];

        if (empty($file_pedoman)) {
            $data = array(
                'title' => $title,
                'description' => $description,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_pedoman);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $config['allowed_types'] = 'mp4';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_video')) {
                $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'description' => $description,
                'image' => $filename,
                'btn_text' => $label_button,
                'url' => base_url() . "assets/main/uploads/" . $filename,
            );
        }

        $save = $this->admin_model->update("tbl_banner", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }
}
