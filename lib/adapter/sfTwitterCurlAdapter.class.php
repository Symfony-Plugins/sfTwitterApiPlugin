<?php

class sfTwitterCurlAdapter
{
  protected $username = '';
  protected $password = '';
  protected $connection = null;

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

  /**
   * Returns the identifiants for authentification process
   *
   * @return string
   */
  protected function getIdentifiantsForAuthenfication()
  {
    return sprintf('%s:%s', $this->username, $this->password);
  }

  public function setOption($name, $value)
  {
    if (!$this->connection)
    {
      throw new Exception('The CURL connection is not initialized yet');
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
   * @param string $uri     The uri to call
   * @param string $method  The http method to use (get, post or delete)
   * @param array $params   An array of post / delete fields
   *
   * @return string The response
   */
  public function send($uri, $method = 'get', $params = array())
  {
    try
    {
      $this->connection = curl_init();
      $this->setOption(CURLOPT_HEADER, true);
      $this->setUri($uri);
      $this->setHttpMethod($method, $params);
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

    $statusCode = curl_getinfo($this->connection, CURLINFO_HTTP_CODE);

    curl_close($this->connection);

    return $response;
  }
}