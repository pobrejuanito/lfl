<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('Web.JSON.JSONHelper');

class AriResponse
{
	function redirect($url)
	{
		if (headers_sent()) 
		{
			echo "<script>document.location.href='$url';</script>\n";
		} 
		else 
		{
			while (@ob_end_clean());
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $url);
		}

		exit();
	}
	
	function getEncoding()
	{
		static $encoding = null;

		if (is_null($encoding))
		{
			if (defined('_ISO'))
			{
				$encoding = explode('=', _ISO);
				$encoding = (is_array($encoding) && count($encoding) > 1) ? strtoupper($encoding[1]) : null;
			}

			if (is_null($encoding)) $encoding = 'UTF-8';
		}
		
		return $encoding;
	}
	
	function sendJsonResponse($data, $charset = 'utf-8')
	{
		while (@ob_end_clean());
		
		header('Content-type: text/html; charset=' . $charset);
		
		echo AriJSONHelper::encode($data);
		exit();
	}
	
	function sendContentAsAttach($fileContent, $fileName, $type = 'application/octet-stream')
	{
		if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) $userBrowser = 'Opera';
		else if (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) $userBrowser = "IE";
		else $userBrowser = '';

		// important for download im most browser
		// $type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
		
		$fileName = rawurldecode($fileName);
		
		while (@ob_end_clean());
		header('Content-Type: ' . $type);
		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header('Accept-Ranges: bytes');
		header("Cache-control: private");
		header('Pragma: private');
		header('Content-Length: ' . (string)strlen($fileContent));

		echo $fileContent;
		exit();
	}
	
	function sendBinaryRespose($data, $type = 'application/octet-stream')
	{
		@ob_end_clean();
		
		if ($type) header('Content-Type: ' . $type);

		echo $data;
		exit();
	}
}
?>