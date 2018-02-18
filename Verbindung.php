<?php
/*
 * Verbindung.php
 * 
 * Copyright 2018 Henning Ainoedhofer <henning@ainoedhofer>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */
class Verbindung
{
	private $servername = "db720990685.db.1and1.com";
	private $username = "dbo720990685";
	private $password = "D6.snh84imG!";
	private $dbname = "db720990685";
	private $conn = null;

	public function __construct()
	{
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
	}

	public function getVerbindung()
	{
		return $this->conn;
	}
}
?>
