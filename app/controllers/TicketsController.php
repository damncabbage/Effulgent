<?php

// TODO: Switch to autoloading
// TODO: Replace models with something better than the hacked-together static singletons these current versions are.
require_once APPLICATION_PATH.'/models/Tickets.php';
require_once APPLICATION_PATH.'/models/User.php';

class TicketsController extends Zend_Controller_Action 
{

	public function init()
	{
		$this->view->flagIsAdmin = User::isAdmin();
	}

    public function indexAction() 
    {
		// do nothing, just display The Box, and optionally a "search failed" warning via $this->view->flagFailedSearch
		if (!isset($this->view->flagFailedSearch)) {
			$this->view->flagFailedSearch = FALSE;
		}
    }


	/**
	* Takes a query and either:
	* a) Lists multiple results if found, with the option to select one, or
	* b) List the single result if found, with Yes / No buttons so the user can choose to confirm scanning the ticket or not.
	*/
	public function searchAction()
	{
		// search query
		if (empty($_GET['query'])) {
			$this->_forward('index');
		}

		$raw_query = urldecode($_GET['query']);

		// explicitly check to see if it's a barcode
		$tickets = Tickets::getByBarcode($raw_query);

		// that didn't work; now do a generic search
		if (empty($tickets)) {
			// split the query up into terms; these are ANDed together by the search function
			// TODO: fullstop too
			$terms = preg_split('/[\s\t-_()\[\]\/\\,"\']+/', $raw_query, PREG_SPLIT_NO_EMPTY);
			$tickets = Tickets::getBySearch($terms, User::isAdmin());
		}

		if (!empty($tickets)) {
			$this->view->tickets = $tickets;

			// if a single ticket, run a check to see if it has been scanned before, 
			// or is invalid
			if (count($tickets) == 1) {
				$ticket = reset($tickets);

				if (!$ticket['received_payment']) {
					$this->view->flagNoPayment = TRUE;
				}
				$day = date('l', time());

				// HACK TODO: Magic numbers.
				if (($ticket['ticket_type_id'] == 2 && $day == 'Sunday') ||
				    ($ticket['ticket_type_id'] == 3 && $day == 'Saturday'))
				{
					$this->view->flagWrongDay = TRUE;
				}

				// has this been scanned before?
				$scans = Tickets::getScans($ticket['barcode']);
				if (!empty($scans)) {
					$this->view->flagScannedBefore = TRUE;
					$this->view->scans = $scans;
				}
			}
			return;
		}

		// no tickets, bail out.
		$this->view->flagFailedSearch = TRUE;
		$this->_forward('index');
	}


	public function confirmAction()
	{
		if (!empty($_POST['confirm']) && empty($_POST['cancel']) && !empty($_POST['reg_id'])) {
			$tickets = Tickets::get($_POST['reg_id']);
			if (count($tickets) != 1) {
				$this->view->flagCouldNotScan = TRUE;
				$this->_forward('index');
				return;
			}
			$ticket = reset($tickets);

			// Scan
			Tickets::createScanLogRecord($ticket['reg_id'], $ticket['barcode'], User::getUsername());

			// HACK TODO: Magic numbers
			if ($ticket['ticket_type_id'] == 1 || $ticket['ticket_type_id'] == 3) {
				$this->view->flagGiveRed = TRUE;
			} else {
				$this->view->flagGiveYellow = TRUE;
			}
		}
		$this->_forward('index');
	}

}
