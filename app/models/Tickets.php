<?php

/**
* Another hacky singleton (like User); this one grabs ticket records, marks things as scanned & writes scan logs, etc.
*
*/

class Tickets
{
	protected static $db;

	protected static function _getDb()
	{
		if (is_null(self::$db)) {
			self::$db = Zend_Registry::get('db');
		}
		return self::$db;
	}


	public static function get($reg_id)
	{
		$db = self::_getDb();
		return $db->fetchAll('SELECT * FROM registrations WHERE reg_id = :reg_id', Array('reg_id' => $reg_id));
	}


	public static function getByBarcode($barcode)
	{
		$db = self::_getDb();
		return $db->fetchAll('SELECT * FROM registrations WHERE barcode = :barcode', Array('barcode' => $barcode));
	}


	public static function getBySearch($query_args, $admin_search)
	{
		$db = self::_getDb();

		// ridiculously expensive, but the system is local and is being hit by three clients at maximum.
		$tickets = Array();
		foreach ($query_args as $arg) {
			// HACK: Look for the Zend equivalent
			$sql_arg = '%'.mysql_escape_string($arg).'%';

			if ($admin_search) {
				$sql = 'SELECT * FROM registrations
				WHERE
					barcode LIKE :barcode OR
					reg_id  LIKE :reg_id OR
					full_name LIKE :full_name OR
					phone LIKE :phone OR
					address LIKE :address OR
					email LIKE :email
				';
				$replacements = Array(
					'barcode'	=> $sql_arg,
					'reg_id'	=> $sql_arg,
					'full_name'	=> $sql_arg,
					'phone'		=> $sql_arg,
					'address'	=> $sql_arg,
					'email'		=> $sql_arg,
				);
			} else {
				$sql = 'SELECT * FROM registrations
				WHERE
					barcode LIKE :barcode OR
					reg_id  LIKE :reg_id OR
					full_name LIKE :full_name
				';
				$replacements = Array(
					'barcode'	=> $sql_arg,
					'reg_id'	=> $sql_arg,
					'full_name'	=> $sql_arg,
				);
			}

			$results = $db->fetchAll($sql, $replacements);

			// prevent double-up
			$tmp_tickets = Array();
			foreach ($results as $result) {
				$tmp_tickets[$result['reg_id']] = $result;
			}
			
			$tickets = array_merge($tickets, $tmp_tickets);
		}

		// renumber with the indexes we're expecting (ie. 0, 1, 2 instead of SM000112, SM000...)
		return array_values($tickets);
	}


	public static function getScans($barcode)
	{
		$db = self::_getDb();
		$sql = 'SELECT s.scan_id, s.scan_time, s.reg_id, s.barcode,	s.username
			FROM ticketbooth_scan_log s
			WHERE s.barcode = :barcode AND s.confirmed = 1
		';
		return $db->fetchAll($sql, Array('barcode' => $barcode));

	}//end getScans()


	public static function getStats()
	{
		$db = self::_getDb();
		$total     = reset($db->fetchCol('SELECT COUNT(*) "count"  FROM registrations'));
		$paid     = reset($db->fetchCol('SELECT COUNT(*) "count"  FROM registrations WHERE received_payment = 1'));

		$sql = 'SELECT COUNT(*) "total_scanned"
				FROM   registrations
				WHERE
					reg_id IN (
						SELECT r.reg_id
						FROM
							ticketbooth_scan_log s
								INNER JOIN
							registrations r
						ON
							r.reg_id = s.reg_id
						WHERE r.received_payment = 1
					)';
		$processed = reset($db->fetchCol($sql));

		return Array(
				'processed_ticket_count'	=> $processed,
				'total_ticket_count'		=> $total,
				'paid_ticket_count'			=> $paid,
		       );
	}


	public static function createScanLogRecord($reg_id, $barcode, $username)
	{
		$db = self::_getDb();
		$data = Array(
			'scan_time'	=> time(),
			'reg_id'	=> $reg_id,
			'barcode'	=> $barcode,
			'username'	=> $username,
			'confirmed'	=> 1,
		);
		$db->insert('ticketbooth_scan_log', $data);
	}


}//end class
