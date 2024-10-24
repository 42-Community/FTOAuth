<?php

namespace MediaWiki\Extension\FTOAuth\Maintenance;

use Maintenance;

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = __DIR__ . '/../../..';
}
require_once "$IP/maintenance/Maintenance.php";

class FTOAuth extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->requireExtension( 'FTOAuth' );
	}

	public function execute() {
		$this->output( "FTOAuth was here.\n" );
	}
}

$maintClass = FTOAuth::class;
require_once RUN_MAINTENANCE_IF_MAIN;
