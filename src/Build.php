<?php

$aData = csv_to_array(__DIR__.'/Languages.csv');

$directionalities = csv_to_array(__DIR__.'/LanguagesDirectionality.csv');

foreach ($directionalities as $code=>$directionality)
{
	if (isset($aData[$code])) {
		$aData[$code]['Directionality'] = $directionality['Directionality'];
	}
}

$scripts = csv_to_array(__DIR__.'/LanguagesScripts.csv');

foreach ($scripts as $code=>$script)
{
	if (isset($aData[$code])) {
		$aData[$code]['Script'] = $script['Script'];
	}
}

file_put_contents(__DIR__.'/../languages.php', "<?php\n\nreturn ".var_export($aData, true).";\n");


/**
 * Convert a comma separated file into an associated array.
 * The first row should contain the array keys.
 *
 * Example:
 *
 * @param string $sFilename Path to the CSV file
 * @param string $sDelimiter The separator used in the file
 * @return array
 * @link http://gist.github.com/385876
 * @author Jay Williams <http://myd3.com/>
 * @copyright Copyright (c) 2010, Jay Williams
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
function csv_to_array($sFilename = null, $sDelimiter = ',')
{
	if (!file_exists($sFilename) || !is_readable($sFilename)) {
		return false;
	}

	$aHeader = null;
	$aData = array();

	if (($handle = fopen($sFilename, 'r')) !== false)
	{
		while (($aRow = fgetcsv($handle, 0, $sDelimiter)) !== false)
		{
			if (!$aHeader) {
				$aHeader = array_map('trim', $aRow);
			}
			else {
				$aData[trim($aRow[0])] = array_combine($aHeader, array_map('trim', $aRow));
			}
		}

		fclose($handle);
	}

	return $aData;
}
