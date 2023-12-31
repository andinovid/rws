<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rms_model extends CI_Model
{

    function Get_Auth($username, $pass)
    {
        $data = $this->db->query("SELECT a.*, b.role as role_name, b.role_desc FROM tbl_users a LEFT JOIN tbl_role b ON a.role = b.id WHERE a.username = '$username' AND a.password ='$pass' AND status = '1'");
        return $data;
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data, $param)
    {
        $return = FALSE;
        if ($this->db->update($table, $data, "id = $param")) {
            $return = TRUE;
        }
        return $return;
    }

    public function update_in($table, $data, $param)
    {
        $return = FALSE;
        $this->db->update_batch($table, $data, $param);
        return $return;
    }

    function delete($tbl, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tbl);
        return TRUE;
    }

    public function get($table, $where = NULL, $limit = NULL)
    {

        if ($where != "") {
            $where = "$where";
        } else {
            $status = "";
        }

        if ($limit != "") {
            $limit = "LIMIT $limit";
        } else {
            $limit = "";
        }
        $data = $this->db->query("SELECT * FROM $table $where $limit");
        return $data;
    }

    public function get_by_query($query)
    {
        $data = $this->db->query($query);
        return $data;
    }

    function update_priority_data($data, $parent = NULL)
    {
        $i = 1;
        foreach ($data as $d) {
            if (array_key_exists("children", $d)) {
                $this->update_priority_data($d['children'], $d['id']);
            }
            $update_array = array("position" => $i, "parent" => $parent);
            $update = $this->db->where("id", $d['id'])->update("tbl_menu", $update_array);
            $i++;
        }
        return $update;
    }

    public function insert_data($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function insert_id($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_data($table, $data, $param)
    {
        $return = FALSE;
        if ($this->db->update($table, $data, "id = $param")) {
            $return = TRUE;
        }
        return $return;
    }

    public function update_keuangan_perbaikan($data, $param)
    {
        $return = FALSE;
        if ($this->db->update("tbl_keuangan", $data, "id_perbaikan = $param")) {
            $return = TRUE;
        }
        return $return;
    }

    function delete_data($tbl, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tbl);
        return TRUE;
    }
    function delete_perbaikan($id)
    {
        $this->db->delete('tbl_perbaikan', array('id' => $id));
        $this->db->delete('tbl_keuangan', array('id_perbaikan' => $id));
        return TRUE;
    }


    
    function delete_project($id)
    {
        $this->db->delete('tbl_perbaikan', array('id' => $id));
        $this->db->delete('tbl_rekap', array('id_project' => $id));
        $this->db->delete('tbl_project', array('id' => $id));
        return TRUE;
    }
    
    function delete_invoice($id)
    {
        $this->db->delete('tbl_invoice', array('id' => $id));
        $this->db->delete('tbl_generate_invoice', array('id_invoice' => $id));
        return TRUE;
    }
    
    function delete_kwitansi($id)
    {
        $this->db->delete('tbl_kwitansi', array('id' => $id));
        $this->db->delete('tbl_generate_kwitansi', array('id_kwitansi' => $id));
        return TRUE;
    }
    
    function delete_kwitansi_transporter($id)
    {
        $this->db->delete('tbl_kwitansi_transporter', array('id' => $id));
        $this->db->delete('tbl_generate_kwitansi_transporter', array('id_kwitansi' => $id));
        return TRUE;
    }

    function delete_truck($id)
    {
        $this->db->delete('tbl_truck', array('id' => $id));
        $this->db->delete('tbl_pengisian_bbm', array('id_truck' => $id));
        return TRUE;
    }
}
