<?php
//class to connect to the database
class DB {
	protected $_link, $_result, $_numRows;
	//create connection to database
	public function __construct($server, $username, $password, $db) {
		$this->_link = mysql_connect($server, $username, $password);
		mysql_select_db($db, $this->_link);
	}
	//disconnect from database
	public function disconnect() {
		mysql_close($this->_link);
	}
	//query database
	public function query($sql) {
		$this->_result = mysql_query($sql, $this->_link);
		$this->_numRows = mysql_num_rows($this->_result);
		//return array
		return $this->rows();
	}
	//return number of rows
	public function numRows() {
		return $this->_numRows;
	}
	//return array
	public function rows() {
		/*$rows = array();
		for ($i=0; $i < $this->_numRows; $i++) { 
			$rows[] = mysql_fetch_assoc($this->_result);
		}
		return $rows;*/
		return mysql_fetch_array($this->_result);
	}
	//escape string
	public function escape($input) {
		return mysql_real_escape_string($input);
	}
	//strip html tags from string
	public function strip($input) {
		return strip_tags($input);
	}
	//escape and strip string
	public function escapeAndStrip($input) {
		return mysql_real_escape_string(strip_tags($input));
	}
}
?>