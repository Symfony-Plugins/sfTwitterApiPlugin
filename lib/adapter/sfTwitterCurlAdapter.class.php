<?php

class sfTwitterCurlAdapter extends sfTwitterHttpAdapter 
{
  /**
   * Constructor
   *
   * @throws InvalidServerConfigurationException
   */
  public function __construct()
  {
    if (!extension_loaded('curl'))
    {
      throw new InvalidServerConfigurationException('The sfTwitterApiPlugin needs the curl extension to be loaded');
    }
  }

  /**
   * Returns the identifiants for authentification process
   *
   * @return string
   */
  protected function getIdentifiantsForAuthenfication()
  {
    return sprintf('%s:%s', $this->username, $this->password);
  }

  /**
   * Sets a CURL option
   *
   * @param string $name
   * @param mixed $value
   *
   * @throws Exception
   */
  public function setOption($name, $value)
  {
    if (!$this->connection)
    {
      throw new Exception('The CURL connection is not yet initialized');
    }

    curl_setopt($this->connection, $name, $value);
  }

  public function setUri($uri)
  {
    $this->setOption(CURLOPT_URL, $uri);
  }

  public function setHttpAuthStrategy()
  {
    $this->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  }

  public function setUserAndPassword()
  {
    $this->setOption(CURLOPT_USERPWD, $this->getIdentifiantsForAuthenfication());
  }

  public function setSslControl()
  {
    $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
  }

  public function setReturnedResponseFormat($format)
  {
    $this->setOption(CURLOPT_RETURNTRANSFER, $format);
  }

  public function setHttpMethod($method, $params = array())
  {
    switch ($method)
    {
      case 'get':
        break;
      
      case 'post':
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $params);
        break;
        
      case 'delete':
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->setOption(CURLOPT_POSTFIELDS, $params);
        break;
      
      default:
        throw new InvalidArgumentException(sprintf(
          'Unknown "%s" http method',
          $method
        ));
        break;
    }
  }

  /**
   * Sends the http request
   *
   * @param sfTwitterRequestBase $request     The request
   *
   * @return string The response
   */
  public function handle(sfTwitterRequest $request)
  {
    try
    {
      $this->connection = curl_init();
      $this->setOption(CURLOPT_HEADER, false);
      $this->setUri($request->getUri());
      $this->setHttpMethod($request->getMethod(), $request->getParameters());
      //$this->setHttpAuthStrategy();
      //$this->setUserAndPassword();
      //$this->setSslControl();
      $this->setReturnedResponseFormat(1);
    }
    catch (InvalidArgumentException $e)
    {
      throw $e;
    }

    return $this->exec();
  }

  /**
   * Executes the curl request
   *
   * @return string The response
   */
  protected function exec()
  {
    if (!$this->connection)
    {
      return;
    }

    $response = curl_exec($this->connection);

    $this->setStatusCode(curl_getinfo($this->connection, CURLINFO_HTTP_CODE));

    curl_close($this->connection);

    return $response;
  }
}