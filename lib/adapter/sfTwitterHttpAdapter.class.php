<?php

abstract class sfTwitterHttpAdapter
{
	protected $username = '';
  protected $password = '';
  protected $uri = '';
  protected $method = '';
  protected $parameters = array();
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
   * Sets the uri
   *
   * @param string $uri The uri
   */
  public function setUri($uri)
  {
    $this->uri = $uri;
  }

  /**
   * Returns the uri
   *
   * @return string
   */
  public function getUri()
  {
    return $this->uri;
  }

  /**
   * Sets the http method
   *
   * @param string $method
   */
  public function setMethod($method)
  {
    $this->method = $method;
  }

  /**
   * Returns the http method
   *
   * @return string
   */
  public function getMethod()
  {
    return $this->method;
  }

  /**
   * Sets the request parameters
   *
   * @param array $parameters An associative array of key => value pair
   */
  public function setParameters(array $parameters)
  {
    $this->parameters = $parameters;
  }

  /**
   * Returns the request parameters
   *
   * @param array The request parameters
   */
  public function getParameters()
  {
    return $this->parameters;
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