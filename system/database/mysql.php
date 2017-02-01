<?php

final class MySQL {
	private $link;

	public function __construct($hostname, $username, $password, $database) {
		if (!$this->link = mysqli_connect($hostname, $username, $password)) {
			trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
		}

		if (!mysqli_select_db($this->link,$database)) {
			trigger_error('Error: Could not connect to database ' . $database);
		}

		mysqli_query($this->link,"SET NAMES 'utf8'");
		mysqli_query($this->link,"SET CHARACTER SET utf8");
		mysqli_query($this->link,"SET CHARACTER_SET_CONNECTION=utf8");
		mysqli_query($this->link,"SET SQL_MODE = ''");
	}

	public function query_old($sql) {
		if ($this->link) {
			$resource = mysql_query($sql, $this->link);

			if ($resource) {
				if (is_resource($resource)) {
					$i = 0;

					$data = [];

					while ($result = mysql_fetch_assoc($resource)) {
						$data[$i] = $result;

						$i++;
					}

					mysql_free_result($resource);

					$query = new stdClass();
					$query->row = isset($data[0]) ? $data[0] : [];
					$query->rows = $data;
					$query->num_rows = $i;

					unset($data);

					return $query;
				} else {
					return true;
				}
			} else {
				trigger_error('Error: ' . mysql_error($this->link) . '<br />Error No: ' . mysql_errno($this->link) . '<br />' . $sql);
				exit();
			}
		}
	}

	public function escape($value) {
		if ($this->link) {
			return mysqli_real_escape_string($this->link,$value);
		}
	}

	public function countAffected() {
		if ($this->link) {
			return mysqli_affected_rows($this->link);
		}
	}

	public function getLastId() {
		if ($this->link) {
			return mysqli_insert_id($this->link);
		}
	}

	public function __destruct() {
		if ($this->link) {
			mysqli_close($this->link);
		}
	}

	public function query($sql) {
		$query = $this->link->query($sql);

		if (!$this->link->errno) {
			if ($query instanceof \mysqli_result) {
				$data = [];

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new \stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : [];
				$result->rows = $data;

				$query->close();

				return $result;
			} else {
				return true;
			}
		} else {
			throw new \Exception('Error: ' . $this->link->error . '<br />Error No: ' . $this->link->errno . '<br />' . $sql);
		}
	}
}