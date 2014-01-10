<?php
/*
 * WiND - Wireless Nodes Database
*
* Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as
* published by the Free Software Foundation, either version 3 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . "/DBDescriptors.inc.php";

/**
 * @brief Updater can apply any requested schema update
 */
class DBUpdater {
	
	/**
	 * The hostname of the MySQL server
	 * @var string
	 */
	private $db_host;
	
	/**
	 * The username to authenticate at MySQL server
	 * @var string
	 */
	private $db_username;
	
	/**
	 * The password to authenticate at MySQL server
	 * @var string
	 */
	private $db_password;
	
	/**
	 * The database to use after connection with server
	 * @var string
	 */
	private $db_database;
	
	/**
	 * The MySQLi connection object
	 * @var mysqli
	 */
	private $db_conn;
	
	/**
	 * Connect to database that will be updated.
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 * @throws RuntimeException
	 */
	public function __construct($host, $username, $password, $database) {
		
		$this->db_host = $host;
		$this->db_username = $username;
		$this->db_password = $password;
		$this->db_database = $database;
		
		$this->db_conn = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_database);
		if ($this->db_conn->connect_errno) {
			throw new RuntimeException("Failed to connect to MySQL: " . $this->db_conn->connect_error);
		}
		
		printf("Connected to server \"%s@%s\" on database \"%s\".\n",
				$this->db_host,
				$this->db_username,
				$this->db_database);
	}
	
	/**
	 * Check if a an SQL table exists in connected database
	 * @param string $table_name The name of the SQL table
	 */
	public function tableExists($table_name) {
		$result = $this->db_conn->query("SHOW TABLES LIKE '" . $this->db_conn->real_escape_string($table_name) . "';");
		$exists = $result->num_rows == 1;
		$result->close();
		return $exists;
	}
	
	/**
	 * @brief Get current database schema version
	 * @return SchemaVersion
	 */
	public function getCurrentSchemaVersion() {
		// If no update_log table exists we assume it is prior 1.1
		if (!$this->tableExists('update_log'))
			return new SchemaVersion(1,0);
		
		// Get the latest update and check version
		$result = $this->db_conn->query("SELECT version_major, version_minor FROM update_log ORDER BY version_major DESC, version_minor DESC LIMIT 1");
		if (!$result || !$result->num_rows)
			throw new RuntimeException("Unknown schema version of the database");
		$row = $result->fetch_assoc();
		return new SchemaVersion($row['version_major'], $row['version_minor']);
	}
	
	/**
	 * @brief Apply a specific update on the database
	 * @param DBUpdateDescriptor $update The update to apply
	 */
	public function applyUpdate($update) {
		printf("Upgrading DB Schema to %s...\n", $update->getTargetVersion());
		
		
		$sql_commands = array();
		
		// New tables
		foreach($update->getNewTables() as $table) {
			$sql_commands[] = $table->getSQL();
		}
		
		// New Column modifications
		foreach($update->getNewColumns() as $columns) {
			$sql_commands[] = $columns->getSQL();
		}
		
		// Modified Columns
		foreach($update->getModifiedColumns() as $modification) {
			$sql_commands[] = $modification->getSQL();
		}
		
		//Execute all SQL commands
		foreach($sql_commands as $sql) {
			$res = $this->db_conn->query($sql);
			if (!$res) {
				printf($sql);
				throw new RuntimeException("Error executing SQL query: ". $this->db_conn->error);
			}
		}
		
		// Mark update log for this change
		$res = $this->db_conn->query("INSERT INTO `update_log` (`version_major`, `version_minor`) VALUES("
				. "'" . $this->db_conn->real_escape_string($update->getTargetVersion()->getMajor()) . "',"
				. "'" . $this->db_conn->real_escape_string($update->getTargetVersion()->getMinor()) . "');");
		if (!$res) {
			throw new RuntimeException("Error executing SQL query: ". $this->db_conn->error);
		}

	}
	
	/**
	 * @brief Update database to a specific version
	 * @param array $target_version The desired target version
	 * @param array $available_updates A list with all available updates
	 */
	public function updateTo($target_version, $available_updates) {
		$current_version = $this->getCurrentSchemaVersion();
		printf("Schema is currently at %s version\n", $current_version);
		
		if ($current_version->isGreaterEqual($target_version)){
			print "Database is already updated to latest version.\n";
			return;
		}
		
		// Function to get the update for a specific target_version
		$get_update_for = function($target_version) use ($available_updates) {
			foreach($available_updates as $update) {
				if ($update->getTargetVersion()->isEqual($target_version))
					return $update;
			}
			return null;
		};
		
		// Calculate which updates must be performed to update schema from
		// $current_version to $target_version
		$updates_to_be_applied = array();
		$earlier_version = $target_version;
		while(!$earlier_version->isEqual($current_version)) {
			$update = $get_update_for($earlier_version);
			if (!$update)
				throw new RuntimeException(sprintf("Cannot find an update to %s.", $earlier_version));
			$updates_to_be_applied[] = $update;
			$earlier_version = $update->getSourceVersion();
		};
		$updates_to_be_applied = array_reverse($updates_to_be_applied);
		
		
		foreach($updates_to_be_applied as $update) {
			$this->applyUpdate($update);
		}
	}
};