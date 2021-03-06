<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase($_EXTKEY);
$configuration = \TYPO3\GenericGallery\Utility\EmConfiguration::getSettings();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Generic Gallery'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY, 'Configuration/TypoScript', 'Generic Gallery: default'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY, 'Configuration/TypoScript/Examples/Bootstrap', 'Generic Gallery: Example - Boostrap'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'tx_generic_gallery_pictures',
	'EXT:generic_gallery/Resources/Private/Language/locallang_csh_tx_genericgallery_domain_model_galleryitem.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_generic_gallery_pictures');
$GLOBALS['TCA']['tx_generic_gallery_pictures'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xlf:tx_genericgallery_domain_model_galleryitem',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,link,image,text_items,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) .
			'Configuration/TCA/GalleryItem.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) .
			'Resources/Public/Icons/tx_genericgallery_domain_model_galleryitem.gif'
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'tx_generic_gallery_content',
	'EXT:generic_gallery/Resources/Private/Language/locallang_csh_tx_genericgallery_domain_model_textitem.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_generic_gallery_content');
$GLOBALS['TCA']['tx_generic_gallery_content'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xlf:tx_genericgallery_domain_model_textitem',
		'label' => 'bodytext',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'bodytext,position,width,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) .
			'Configuration/TCA/TextItem.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) .
			'Resources/Public/Icons/tx_genericgallery_domain_model_textitem.gif'
	),
);


$tempColumns = array(
	// gallery type
	'tx_generic_gallery_predefined' => Array(
		'exclude' => 1,
		'label' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xml:generic_gallery_predefined',
		'config' => Array(
			'type' => 'select',
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'TYPO3\GenericGallery\Backend\Hooks\TcaHook->addPredefinedFields',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),

	// single items
	'tx_generic_gallery_items' => Array(
		'exclude' => 1,
		'label' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xml:generic_gallery_items',
		'config' => Array(
			'type' => 'inline',
			'foreign_table' => 'tx_generic_gallery_pictures',
			'foreign_field' => 'tt_content_id',
			'appearance' => Array(
				'useSortable' => 1,
				'collapseAll' => 1,
				'expandSingle' => 1,
			),
			'maxitems' => 1000,
			'minitems' => 0,
		)
	),

	// file reference
	'tx_generic_gallery_images' => Array(
		'exclude' => 1,
		'label' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xml:generic_gallery_images',
		'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
			'tx_generic_gallery_picture_single',
			array(
				'size' => 20,
				'maxitems' => 2000,
				'minitems' => 0,
				'autoSizeMax' => 40,
			),
			'jpg,gif,jpeg,png'
		)
	),

	// collection reference
	'tx_generic_gallery_collection' => Array(
		'exclude' => 1,
		'label' => 'LLL:EXT:generic_gallery/Resources/Private/Language/locallang_db.xml:generic_gallery_collection',
		'config' => Array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'sys_file_collection',
			'size' => 1,
			'maxitems' => 1,
			'minitems' => 0,
			'wizards' => array(
				'edit' => array(
					'type' => 'popup',
					'title' => 'Edit',
					'script' => 'wizard_edit.php',
					'icon' => 'edit2.gif',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
				),
				'add' => Array(
					'type' => 'script',
					'title' => 'Create new',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'sys_file_collection',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
					),
					'script' => 'wizard_add.php',
				),
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		)
	),
);

if ($configuration->getUseInlineCollection()) {
	$tempColumns['tx_generic_gallery_collection']['config'] = array(
		'type' => 'inline',
		'foreign_table' => 'sys_file_collection',
		'appearance' => Array(
			'collapseAll' => 0,
			'expandSingle' => 1,
		),
		'maxitems' => 1,
		'minitems' => 0,
	);
}

// add field to tt_content
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);
$TCA['tt_content']['types']['list']['subtypes_addlist'][strtolower($extensionName) . '_pi1'] =
	'tx_generic_gallery_predefined,tx_generic_gallery_items,tx_generic_gallery_images,tx_generic_gallery_collection';
