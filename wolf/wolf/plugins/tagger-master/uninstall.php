<?php
/**
 * Tagger Plugin for Wolf CMS <http://thehub.silentworks.co.uk/plugins/frog-cms/tagger.html>
 * Alternate Mirror site <http://www.tbeckett.net/articles/plugins/tagger.xhtml>
 * Copyright (C) 2008 - 2011 Andrew Smith <a.smith@silentworks.co.uk>
 * Copyright (C) 2008 - 2011 Tyler Beckett <tyler@tbeckett.net>
 * 
 * Dual licensed under the MIT (license/mit-license.txt)
 * and GPL (license/gpl-license.txt) licenses.
 */

/**
 * Tagger Utils
 */
$tagger_dir = dirname(__FILE__) . '/';
include_once $tagger_dir . "utils.php";

$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));
if ($driver == 'mysql')
{
	$query = $PDO->query("SELECT * FROM ".TABLE_PREFIX."page WHERE behavior_id = 'tagger'");
	
	if($query->rowCount())
	{
		$page = $query->fetch(PDO::FETCH_ASSOC);
		
		executioner(
			file($tagger_dir . 'sql/uninstall.sql'),
			array(
				'{prefix}' => TABLE_PREFIX,
				'{page_id}' => $page['id']
			)
		);
	}
}

if (Plugin::deleteAllSettings('tagger') === false) {
    Flash::set('error', __('Tagger: Unable to remove plugin settings.'));
    redirect(get_url('setting'));
}
else {
    Flash::set('success', __('Tagger: Successfully removed plugin settings.'));
    redirect(get_url('setting'));
}