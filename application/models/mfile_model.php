<?php 
class Mfile_model extends CI_Model{


	function getall($data){
		$_offset = "";
		$_where  = "";
		if($data['offset']!=null){
			$_offset = " OFFSET ".$data['offset'];
		}
		if(@$data['cari']){
			$_where = " WHERE ".$data['cari'];
		}
		$SQL = "SELECT * FROM file ".$_where." lIMIT ".$data['limit'].$_offset;
		return $this->db->query($SQL)->result_array();
	}


	function getpublic($data){
		$_offset = "";
		$_where  = " WHERE status_file='y'";
		if($data['offset']!=null){
			$_offset = " OFFSET ".$data['offset'];
		}
		if(@$data['cari']){
			$_where = " AND ".$data['cari'];
		}
		$SQL = "SELECT * FROM file ".$_where." lIMIT ".$data['limit'].$_offset;
		return $this->db->query($SQL)->result_array();
	}



	function getcount(){
		$result = $this->db->get('file')->num_rows();
		return $result;
	}



	function save($data,$kunci=null){
		$id = ($kunci!=null)?$data[$kunci]:'';
		if($id!=''){
			$this->db->where($kunci,$id);
			$result = $this->db->update('file' ,$data);
		}else{
			$result = $this->db->insert('file' ,$data);
		}
		return $result;
	}


	function delete($data){
		$this->db->where('id_file',$data['id']);
		$result = $this->db->delete('file');
		return $result;
	}


	function getby($data){
		$this->db->where('id_file',$data['id']);
		$result = $this->db->get('file');
		return $result->row_array();
	}


}