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

/**
 * @brief Schema version
 */
class SchemaVersion {
	
	/**
	 * @brief The major part of the version
	 * @var integer
	 */
	private $major;

	/**
	 * @brief The minor part of the version
	 * @var integer
	 */
	private $minor;
		
	/**
	 * @brief Initialize a version object
	 * @param intger $major The major part of the version
	 * @param intger $minor The minor part of the version
	 */
	public function __construct($major, $minor) {
		$this->major = $major;
		$this->minor = $minor;
	}
	
	/**
	 * @brief Get major part of versioning
	 */
	public function getMajor(){
		return $this->major;
	}
	
	/**
	 * @brief Get minor part of versioning
	 */
	public function getMinor(){
		return $this->minor;
	}
	
	/**
	 * @brief Convert to string
	 */
	public function __toString() {
		return sprintf("v%d.%d", $this->major, $this->minor);
	}
	
	/**
	 * @brief Check if this version is equal to another object 
	 * @param SchemaVersion $other The other version to compare at.
	 */
	public function isEqual($other) {
		return ($this->getMajor() == $other->getMajor()
				&& $this->getMinor() == $other->getMinor());
	}
	
	/**
	 * @brief Check if this version is greater
	 * @param SchemaVersion $other The other version to compare at.
	 */
	public function isGreater($other) {
		if ($this->getMajor() > $other->getMajor()) {
			return true;
		}
		
		if ($this->getMajor() == $other->getMajor()
				&&	$this->getMinor() >= $other->getMinor()) {
			return true;
		} 
		return false;
	}
};

/**
 * @brief Descriptor of the an SQL Column
 */
class DBColumnDescriptor {
	
	/**
	 * Effective options of the column
	 * @var array
	 */
	private $options;
	
	/**
	 * SQL Type of the column
	 * @var string
	 */
	private $type;
	
	/**
	 * Name of the column
	 * @var string
	 */
	private $name;
	
	/**
	 * @brief Describe a table column
	 * @param string $name
	 * @param string $type
	 * @param array $options
	 * 	- pk : This field is primary key
	 *  - default : The default value of field
	 *  - not_null : Flag if this field can be null
	 *  - unique: Flag if values must be unique
	 *  - fk: Array(foreign_table_name, foreign_table_id)
	 */
	public function __construct($name, $type, $options = array()) {
		
		$this->name = $name;
		$this->type = $type;
		
		$default_options = array(
				'ai' => false,
				'pk' => false,
				'fk' => false,
				'default' => null,
				'not_null' => false,
				'unique' => false);
		
		$this->options = array_merge(
				$default_options,
				$options,
				array('name' => $name, 'type' => $type));
	}
	
	/**
	 * @brief Get name of the column
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @brief Get all the effective options of column
	 */
	public function getOptions() {
		return $this->options;
	}
	
	/**
	 * @brief Get the sql type of the column
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @brief Get SQL representation of the column
	 */
	public function getSQL() {

		$not_null = ($this->options['not_null']?'NOT NULL':'');
		$default = ($this->options['default'] !== null?'DEFAULT ' . $this->options['default']:'');
		if ($this->options['ai'])
			$default = 'AUTO_INCREMENT';
		
		return sprintf("`%s` %s %s %s",
			$this->name,
			$this->type,
			$not_null,
			$default
		);
	}
};

/**
 * @brief Descriptor of the an SQL Table
 */
class DBTableDescriptor {
	
	/**
	 * @brief The name of the SQL table
	 * @var string
	 */
	private $name;
	
	/**
	 * @brief Associative array with all columns of table
	 * @var unknown_type
	 */
	private $columns = array();
	
	/**
	 * Create an empty table
	 * @param string $name The name of the SQL table
	 */
	public function __construct($name) {
		$this->name = $name;
	}
	
	/**
	 * Add column in table
	 * @see DBColumnDescriptor()
	 */
	public function addColumn($name, $type, $options = array()) {
		$this->columns[$name] = new DBColumnDescriptor($name, $type, $options);
	}
	
	/**
	 * @brief Get an array with all columns of table
	 * @return array
	 */
	public function getColumns() {
		return $this->columns;
	}
	
	/**
	 * @brief Get the name of the table
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @brief Get all columns that are primary key
	 */
	public function getPrimaryKeys() {
		$pks = array();
		foreach($this->columns as $column) {
			$opt = $column->getOptions();
			if ($opt['pk']) {
				$pks[] = $column->getName();
			}
		}
		return $pks;
	}
	
	/**
	 * @brief Get SQL representation of the table
	 */
	public function getSQL() {
		$sql = sprintf("CREATE TABLE `%s` (\n", $this->name);
		
		// Table columns
		$properties_sql = array();
		foreach($this->columns as $column)
			$properties_sql[] = $column->getSQL();
		
		// Primary keys
		if(count($this->getPrimaryKeys())) {
			$pks = array_map(function($pk){
				return "`{$pk}`";
			}, $this->getPrimaryKeys());
			
			$properties_sql[] = 'PRIMARY KEY(' . implode(',', $pks) . ")";
		}
		
		// Unique keys
		foreach($this->columns as $column ) {
			$opt = $column->getOptions();
			if ($opt['unique']) {
				$properties_sql[] = "UNIQUE (`{$column->getName()}`)";
			}
		}
		
		$sql .= implode(",\n", $properties_sql) . "\n";
		$sql .= sprintf(") CHARSET=utf8;\n");
		
		return $sql;
	}
};

/**
 * @brief Describe a column modification
 */
class DBModifyColumnDescriptor {
	
	/**
	 * The name of the table that column belongs to
	 * @var string
	 */
	private $table_name;
	
	/**
	 * The current name of the column to be modified
	 * @var string
	 */
	private $current_column_name;
	
	/**
	 * The new column object
	 * @var DBColumnDescriptor
	 */
	private $new_column;
	
	/**
	 * @brief Create a new column modification descriptor
	 * @param string $table_name The name of the table that column belongs to
	 * @param string $current_column_name The current name of the column to be modified
	 * @param string $new_column_name The name of the column 
	 * @param string $new_column_type The new type of the column
	 * @param array $new_column_options The new options of the column
	 * @see DBColumnDescriptor
	 */
	public function __construct($table_name, $current_column_name, $new_column_name, $new_column_type, $new_column_options = array()) {
		$this->table_name = $table_name;
		$this->current_column_name = $current_column_name;
		$this->new_column = new DBColumnDescriptor($new_column_name, $new_column_type, $new_column_options);
	}
	
	/**
	 * @brief Get the name of the table that column belongs to.
	 * @return string
	 */
	public function getTableName() {
		return $this->table_name;
	}
	
	/**
	 * @brief Get the current name of the column
	 * @return string
	 */
	public function getCurrentColumnName() {
		return $this->current_column_name;
	}
	
	/**
	 * @brief Get the new column state
	 * @return DBColumnDescriptor
	 */
	public function getNewColumn() {
		return $this->new_column;
	}
	
	/**
	 * @brief Get the SQL can apply this modification
	 * @return string
	 */
	public function getSQL() {
		$sql = "ALTER TABLE `{$this->getTableName()}` ";
		$sql .= "CHANGE COLUMN `{$this->getCurrentColumnName()}` ";
		$sql .= $this->new_column->getSQL();
		
		return $sql;
	}
}

/**
 * @brief Add a new column in existing table
 */
class DBNewColumnDescriptor {

	/**
	 * The name of the table that column belongs to
	 * @var string
	 */
	private $table_name;

	/**
	 * The new column object
	 * @var DBColumnDescriptor
	 */
	private $new_column;

	/**
	 * @brief Create a new column modification descriptor
	 * @param string $table_name The name of the table that column belongs to
	 * @param string $new_column_name The name of the column
	 * @param string $new_column_type The new type of the column
	 * @param array $new_column_options The new options of the column
	 * @see DBColumnDescriptor
	 */
	public function __construct($table_name, $new_column_name, $new_column_type, $new_column_options = array()) {
		$this->table_name = $table_name;
		$this->new_column = new DBColumnDescriptor($new_column_name, $new_column_type, $new_column_options);
	}

	/**
	 * @brief Get the name of the table that column belongs to.
	 * @return string
	 */
	public function getTableName() {
		return $this->table_name;
	}

	/**
	 * @brief Get the new column state
	 * @return DBColumnDescriptor
	 */
	public function getNewColumn() {
		return $this->new_column;
	}

	/**
	 * @brief Get the SQL can apply this modification
	 * @return string
	 */
	public function getSQL() {
		$sql = "ALTER TABLE `{$this->getTableName()}` ";
		$sql .= "ADD COLUMN {$this->new_column->getSQL()}";

		return $sql;
	}
}

/**
 * @brief Descriptor of the an SQL schema update
 */
class DBUpdateDescriptor {
	
	/**
	 * @brief Array with all new tables
	 * @var array
	 */
	private $new_tables = array();
	
	/**
	 * @brief Array with all new columns
	 * @var array
	 */
	private $new_columns = array();
	
	/**
	 * @brief Array with all modified columns
	 * @var array
	 */
	private $modified_columns = array();
	
	/**
	 * @brief The schema version to update at
	 * @var SchemaVersion
	 */
	private $target_version;
	
	/**
	 * @brief The schema version to update from
	 * @var SchemaVersion
	 */
	private $source_version;
	
	
	/**
	 * @brief Construct a new descriptor
	 * @param SchemaVersion $source_version
	 * @param SchemaVersion $target_version
	 */
	public function __construct(SchemaVersion $source_version, SchemaVersion $target_version) {
		$this->source_version = $source_version;
		$this->target_version = $target_version;
	}
	
	/**
	 * @brief Add a new table in schema update
	 * @param string $name The name of the new table
	 * @return DBTableDescriptor
	 */
	public function newTable($name) {
		return $this->new_tables[$name] = new DBTableDescriptor($name);
	}
	
	/**
	 * Add a new column on existing table
	 * @param string $table_name The table to add column
	 * @param string $column_name The name of the new column
	 * @param string $column_type The type of the new column
	 * @param array $column_options Options of the new column
	 * @see DBColumnDescriptor()
	 * @return DBNewColumnDescriptor
	 */
	public function newColumn($table_name, $column_name, $column_type, $column_options = array()) {
		return $this->new_columns[] 
			= new DBNewColumnDescriptor(
					$table_name,
					$column_name,
					$column_type,
					$column_options);
	}
	
	/**
	 * Request to modify a column
	 * @param string $table_name The table to add column
	 * @param string $current_column_name The current name of the column
	 * @param string $column_name The new name of the column
	 * @param string $column_type The new type of the column
	 * @param array $column_options The new options of the column
	 * @see DBColumnDescriptor()
	 * @return DBModifyColumnDescriptor
	 */
	public function modifyColumn($table_name, $current_column_name, $new_column_name, $new_column_type, $new_column_options = array()) {
		return $this->modified_columns[] 
			= new DBModifyColumnDescriptor(
					$table_name,
					$current_column_name,
					$new_column_name,
					$new_column_type,
					$new_column_options);
	}
	
	/**
	 * @brief Get the array with new tables
	 * @return array
	 */
	public function getNewTables() {
		return $this->new_tables;
	}
	
	/**
	 * @brief Get an array with modified columns
	 * @return array
	 */
	public function getModifiedColumns() {
		return $this->modified_columns;
	}
	
	/**
	 * @brief Get an array with new columns
	 * @return array
	 */
	public function getNewColumns() {
		return $this->new_columns;
	}
	
	/**
	 * @brief Get the version of schema after update
	 * @return SchemaVersion
	 */
	public function getTargetVersion() {
		return $this->target_version;
	}
	
	/**
	 * @brief Get the version of schema before update
	 * @return SchemaVersion
	 */
	public function getSourceVersion() {
		return $this->source_version;
	}
};