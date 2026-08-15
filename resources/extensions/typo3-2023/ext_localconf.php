<?php

if ( ! defined( 'TYPO3' ) ) {
	die ( 'Access denied.' );
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['aimeos']['extDirs']['1_<extname>'] =
  'EXT:<extname>/Resources/Private/Extensions/';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['aimeos']['confDirs']['1_<extname>'] =
  'EXT:<extname>/Resources/Private/Config/';

?>