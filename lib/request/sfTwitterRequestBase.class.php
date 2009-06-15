<?php

abstract class sfTwitterRequestBase
{
  const FORMAT_XML  = 'xml';
  const FORMAT_JSON = 'json';
  const FORMAT_RSS  = 'rss';
  const FORMAT_ATOM = 'atom';

  const METHOD_POST   = 'post';
  const METHOD_GET    = 'get';
  const METHOD_DELETE = 'delete';

  protected $formats = array(
    self::FORMAT_XML  => self::FORMAT_XML,
    self::FORMAT_JSON => self::FORMAT_JSON,
    self::FORMAT_RSS  => self::FORMAT_RSS,
    self::FORMAT_ATOM => self::FORMAT_ATOM
  );

  protected $methods = array(
    self::METHOD_GET    => self::METHOD_GET,
    self::METHOD_POST   => self::METHOD_POST,
    self::METHOD_DELETE => self::METHOD_DELETE 
  );

  protected $domain = '';
  protected $method = 'get';
  protected $responseFormat = 'xml';
  protected $username = '';
  protected $password = '';
  protected $uri = '';

  public function setUsername($username)
  {
    $this->username = $username;
  }
  
  public function setPassword($password)
  {
    $this->password = $password;
  }
  
  public function setUri($uri)
  {
    $this->uri = $uri;
  }
  
  public function getUri()
  {
    return $this->uri;
  }

  public function send()
  {
    try
    {
      $adapter = new sfTwitterCurlAdapter();
      $adapter->setUsername($this->username);
      $adapter->setPassword($this->password);
      return $adapter->send($this->getUri(), $this->getMethod());
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }

  /**
   * Set the http method
   *
   * @param string $method
   */
  public function setMethod($method)
  {
    if (!array_key_exists($method, $this->methods))
    {
      throw new InvalidArgumentException(sprintf(
        '%s::%s() method does not support the "%s" http method',
        __CLASS__,
        __METHOD__,
        $method
      ));
    }

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
   * Returns wether or not the http method is the same as the one given in parameter
   *
   * @param string $method The method to test
   */
  public function isMethod($method)
  {
    return ($method === $this->method);
  }

  /**
   * Sets the response format
   *
   * @param string $format
   */
  public function setResponseFormat($format)
  {
    if (!array_key_exists($format, $this->formats))
    {
      throw new InvalidArgumentException(sprintf(
        '%s::%s() method does not support the "%s" format',
        __CLASS__,
        __METHOD__,
        $format
      ));
    }

    $this->responseFormat = $format;
  }

  /**
   * Returns the response format
   *
   * @return string
   */
  public function getResponseFormat()
  {
    return $this->responseFormat;
  }
}