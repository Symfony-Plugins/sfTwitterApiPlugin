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

  //protected $mandatoryParameters = array();
  protected $supportedParameters = array();
  protected $parameters = array();
  protected $method = 'get';
  protected $responseFormat = 'xml';
  protected $username = '';
  protected $password = '';
  protected $apiUri = null;

  /**
   * Constructor
   *
   */
  public function __construct()
  {
    $this->configure();
  }

  /**
   * Configures the request
   *
   */
  public function configure()
  {
    
  }

  /**
   * Adds a supported parameter
   *
   * @param string $name
   */
  protected function addSupportedParameter($name)
  {
    $this->supportedParameters[] = $name;
  }

  /**
   * Sets a request parameter
   *
   * @param string $name  The parameter's name
   * @param string $value The parameter's value
   */
  public function setParameter($name, $value)
  {
    $this->parameters[$name] = $value;
  }

  /**
   * Returns the associative post and get parameters
   *
   * @return array
   */
  public function getParameters()
  {
    return $this->parameters;
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }
  
  public function setPassword($password)
  {
    $this->password = $password;
  }
  
  public function setApiUri($uri)
  {
    $this->apiUri = $uri;
  }

  public function getApiUri()
  {
    return $this->apiUri;
  }
  
  public function getUri()
  {
    return sprintf('%s.%s', $this->getApiUri(), $this->getResponseFormat());
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
      throw new InvalidArgumentException(sprintf('%s::%s() method does not support the "%s" http method', __CLASS__, __METHOD__, $method));
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
      throw new InvalidArgumentException(sprintf('%s::%s() method does not support the "%s" format', __CLASS__, __METHOD__, $format));
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