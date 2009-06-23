<?php

abstract class sfTwitterHttpAdapter
{
  protected $request = null;
	protected $username = '';
  protected $password = '';
  protected $statusCode = null;
  protected $connection = null;

  /**
   * Handles the request
   *
   * @param sfTwitterRequest $request The request
   *
   * @return string The response
   */
	abstract public function handle(sfTwitterRequest $request);

  /**
   * Returns the request
   *
   * @return sfTwitterRequest
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Sets the request
   *
   * @param sfTwitterRequest $request
   */
  public function setRequest(sfTwitterRequest $request)
  {
    $this->request = $request;
  }

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