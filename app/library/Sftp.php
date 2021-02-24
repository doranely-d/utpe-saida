<?php

/*
 * COPYRIGHT © 2019. PODER EJECUTIVO DEL ESTADO DE QUERÉTARO. PATENT PENDING. ALL RIGHTS RESERVED.
 * SAIDA IS REGISTERED TRADEMARKS OF PODER EJECUTIVO DEL ESTADO DE QUERÉTARO.
 *
 * This software is confidential and proprietary information of PODER EJECUTIVO DEL ESTADO DE
 * QUERÉTARO. You shall not disclose such Confidential Information and shall use it only in
 * accordance with the company policy.
 */

class Sftp extends \Phalcon\Mvc\User\Component
{
	private $sftp_error =  null;
	private $ssh_connection = null;
	private $sftp_connection = null;
	private $sftp_base = null;

	public function __construct()
	{
		if (!isset($this->persistent->ftpServer))
		{
			$user = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ftp_usuario\'');
			$password = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ftp_password\'');
			$server = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ftp_servidor\'');
			$port = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ftp_puerto\'');
			$path = $this->modelsManager->executeQuery('SELECT valor AS VALOR FROM SdParametros WHERE estatus = \'AC\' AND nombre = \'ftp_ruta\'');

			$ftpServer = [
				'ftpHost' => trim($server[0]->VALOR),
				'ftpPort' => trim($port[0]->VALOR),
				'ftpUser' => trim($user[0]->VALOR),
				'ftpPass' => trim($password[0]->VALOR),
				'ftpBase' => trim($path[0]->VALOR)
			];

			$this->sftp_base = $ftpServer['ftpBase'];

			$this->persistent->ftpServer = $ftpServer;
		} else {
			$this->sftp_base = $this->persistent->ftpServer['ftpBase'];
		}

	}

	public function __destruct()
	{
	}
	
	/**
	 * Opens ssh2 connection and sets sftp handle.
	 *
	 * param array $server_data Sould contain ftphost, ftpport, ftpuser and ftppass for destination server.
	 * return bool True if connection could be established False if not.
	 */
	public function connect()
	{
		$server_data = $this->persistent->ftpServer;
		$server_data['ftpPort'] = (!isset($server_data['ftpPort'])) ? 22 : (int)trim($server_data['ftpPort']);
		
		if(!isset($server_data['ftpHost']) || !isset($server_data['ftpPort']) || !isset($server_data['ftpUser']) || !isset($server_data['ftpPass']))
		{
			$this->setError(1);
			return false;
		}
		
		$this->ssh_connection = ssh2_connect(trim($server_data['ftpHost']), trim($server_data['ftpPort']));
		
		if($this->ssh_connection === false)
		{
			$this->setError(2);
			return false;
		}
		
		if(ssh2_auth_password($this->ssh_connection, trim($server_data['ftpUser']), trim($server_data['ftpPass'])) === false)
		{
			$this->setError(3);
			return false;
		}
		
		if(($this->sftp_connection = ssh2_sftp($this->ssh_connection)) === false)
		{
			$this->setError(6);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Close ssh connection by unsetting connection handle.
	 *
	 *	return bool true if connection is closed false on error.
	 */
	public function disconnect()
	{
		if($this->ssh_connection == null || $this->ssh_connection === false)
		{
			$this->setError(4);
			return false;
		}
		
		unset($this->ssh_connection);
		
		return true;
	}
	
	/**
	 * Create a folder on destination server.
	 *
	 *	param string $path The path to create.
	 *	param int $mode The chmod value the folder should have.
	 *	param bool $recursive On true all parent foldes are created too.
	 *	return bool True on success false on error.
	 */
	public function mkdir($path, $mode = 0755, $recursive = false)
	{
		$path = (substr(trim($path), 0, 1) != '/') ? '/' . trim($path) : trim($path);

		if(ssh2_sftp_mkdir($this->sftp_connection, $this->sftp_base . $path, $mode, $recursive) === false)
		{
			$this->setError(5);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Remove directory on FTP server
	 *
	 * param string $path
	 * return bool True on success false on error.
	 */
	public function rmdir($path) {
		if(ssh2_sftp_rmdir($this->sftp_connection, $this->sftp_base . trim($path)) === false)
		{
			$this->setError(11);
			return false;
		}
		
		return true;
	}
	
	/** function putfile
	 *
	 *	Uploads a file to destination server using scp.
	 *
	 *	param string $local_file Path to local file.
	 *	param string $remote_file Path to destination file.
	 *	param string $mode Chmod destination file to this value.
	 *	return bool True on success false on error.
	 */
	public function putfile($local_file, $remote_file, $mode = 0664)
	{
		$remote_file = (substr($remote_file, 0, 1) != '/') ? '/' . $remote_file : $remote_file;
		$sftp_stream = fopen('ssh2.sftp://' . $this->sftp_connection . $this->sftp_base . trim($remote_file), 'w');
		
		if(!$sftp_stream)
		{
			$this->setError(7);
			return false;
			
		}
		
		$data_to_send = file_get_contents(trim($local_file));
		
		if ($data_to_send === false)
		{
			$this->setError(7);
			return false;
		}
		
		if(fwrite($sftp_stream, $data_to_send) === false)
		{
			$this->setError(7);
			return false;
		}
		
		fclose($sftp_stream);
		
		return true;
	}
	
	/**
	 * Download file from server
	 *
	 * param string $remote_file
	 * return stream
	 */
	public function getFile($remote_file) {
	    $file = array();
		$buffer = null;
		$remote_file = (substr($remote_file, 0, 1) != '/') ? '/' . $remote_file : $remote_file;
		
		// Remote stream
		if (!$remoteStream = fopen('ssh2.sftp://' . $this->sftp_connection . $this->sftp_base . trim($remote_file), 'r'))
		{
			$this->setError(12);
		}
		
		// Get our file from the remote stream
		$contents = '';
		$read = 0;
		$fileSize = filesize('ssh2.sftp://' . $this->sftp_connection . $this->sftp_base . trim($remote_file));

		while ($read < $fileSize && ($buffer = fread($remoteStream, $fileSize - $read)))
		{
			// Increase our bytes read
			$read += strlen($buffer);
			$contents .= $buffer;
		}

		// Close our stream
		fclose($remoteStream);
        $file  = array($fileSize, $contents);

		return $contents;
	}

	/**
	 * Deletes a file on sftp server.
	 *
	 * param string $file File to delete.
	 * return bool False on error true if file was deleted.
	 */
	public function unlink($file)
	{
		if(!ssh2_sftp_unlink($this->sftp_connection, $this->sftp_base . trim($file)) === false)
		{
			$this->setError(8);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Rename a file on sftp server.
	 *
	 * param string $filename_from The current filename.
	 * param string $filename_to The new filename.
	 * return bool True on success false on error.
	 */
	public function rename($filename_from, $filename_to)
	{
		if(ssh2_sftp_rename($this->sftp_connection, $this->sftp_base . trim($filename_from), $this->sftp_base . ($filename_to)) === false)
		{
			$this->setError(10);
			return false;
		}
		
		return true;
	}
	
	/**
	 * List directory content.
	 *
	 * param string $path Path to directory which should be listed.
	 * return array $filelist List of directory content.
	 */
	public function listdir($path = '/')
	{
		$dir = 'ssh2.sftp://' . $this->sftp_connection . $this->sftp_base . trim($path);
		$filelist = array();
		if(($handle = opendir($dir)) !== false)
		{
			while(false !== ($file = readdir($handle)))
			{
				if(substr($file, 0, 1) != ".")
				{
					$filelist[] = $file;
					
				}
			}
			closedir($handle);
			return $filelist;
		}
		else
		{
			$this->setError(9);
			return false;
		}
	}
    /**
     * List url content.
     *
     * param string $path Path to directory which should be listed.
     * return array $filelist List of directory content.
     */
    public function listPath($path = '/')
    {
        $dir = 'ssh2.sftp://' . $this->sftp_connection . $this->sftp_base . trim($path);
        return $dir;
    }


    /**
	 * Sets an error message by passing an error code.
	 *
	 *	param int $error_code Numeric value representing an error message.
	 *	return bool True if massage was set false on error.
	 */
	protected function setError($error_code)
	{
		switch($error_code)
		{
			case 1:
				$this->sftp_error = 'Server data not complete.';
				break;
			
			case 2:
				$this->sftp_error = 'Connection to Server could not be established.';
				break;
			
			case 3:
				$this->sftp_error = 'Could not authenticate at server.';
				break;
			
			case 4:
				$this->sftp_error = 'No active connection to close.';
				break;
			
			case 5:
				$this->sftp_error = 'Could not create dir.';
				break;
			
			case 6:
				$this->sftp_error = 'Could not initialize sftp subsystem.';
				break;
			
			case 7:
				$this->sftp_error = 'Could not upload file to target server.';
				break;
			
			case 8:
				$this->sftp_error = 'Could not delete remote file.';
				break;
			
			case 9:
				$this->sftp_error = 'Could not open remote directoty.';
				break;
			
			case 10:
				$this->sftp_error = 'Could not rename file.';
				break;
			case 11:
				$this->sftp_error = 'Could not delete dir.';
				break;
			case 12:
				$this->sftp_error = 'Unable to open remote file.';
				break;
		}
	}
	
	/**
	 * Return the current error message.
	 *
	 *	return string The error message.
	 */
	public function getError()
	{
		return $this->sftp_error;
	}
}