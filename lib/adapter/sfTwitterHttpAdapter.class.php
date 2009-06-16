<?php

abstract class sfTwitterHttpAdapter
{
	protected $username = '';
  protected $password = '';
  protected $statusCode = null;
  protected $connection = null;
	
	abstract public function send($uri, $method = 'get', $params = array());
	
  /**
   * Sets the status code
   *
   * @param int $code The http status code
   */
  public function setStatusCode($code)
  {
    $this->statusCode = (int) $code;
  }

  /**
   * Returns the http status code
   *
   * @return int
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**
   * Sets the username
   *
   * @param string $username
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }

  /**
   * Sets the password
   *
   * @param string $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }
}