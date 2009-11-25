<?php

class sfTwitterCurlAdapter extends sfTwitterHttpAdapter 
{
  protected $options = array();

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
   * @param int $name
   * @param mixed $value
   *
   * @throws Exception
   */
  public function setOption($name, $value)
  {
    $this->options[$name] = $value;
  }

  /**
   * Returns an option value
   *
   * @param int $name The option value to get
   *
   * @return mixed
   */
  public function getOption($name)
  {
    if (!isset($this->options[$name]))
    {
      return;
    }

    return $this->options[$name];
  }

  /**
   * Returns the options array
   *
   * @return array
   */
  public function getOptions()
  {
    return $this->options;
  }

  /**
   * Sets the CURL URI to call
   *
   * @param string $uri The HTTP URI
   */
  public function setUri($uri)
  {
    $this->setOption(CURLOPT_URL, $uri);
  }

  /**
   * Sets the authentification strategy
   *
   */
  public function setHttpAuthStrategy()
  {
    $this->setOption(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  }

  /**
   * Sets user and password for HTTP authentification
   *
   */
  public function setUserAndPassword()
  {
    $this->setOption(CURLOPT_USERPWD, $this->getIdentifiantsForAuthenfication());
  }

  /**
   * Disables the SSL connection
   *
   */
  public function disableSslControl()
  {
    $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
  }

  /**
   * Enables the SSL connection
   *
   */
  public function enableSslControl()
  {
    $this->setOption(CURLOPT_SSL_VERIFYPEER, true);
  }

  /**
   * Disables the direct output on the default standard output
   *
   */
  public function disableOutput()
  {
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
  }

  /**
   * Builds the CURL request
   *
   */
  protected function buildRequest()
  {
    switch ($this->request->getMethod())
    {
      case 'post':
        $this->buildPostRequest();
        break;
        
      case 'delete':
        $this->buildDeleteRequest();
        break;

      default:
        $this->buildGetRequest();
        break;
    }
  }

  /**
   * Returns the escaped query string for a GET request
   *
   * @return string
   */
  protected function getQueryString()
  {
    $query = null;
    $params = $this->request->getParameters();

    if (count($params))
    {
      $query = http_build_query($params);
    }

    return $query;
  }

  /**
   * Prepares a GET request
   *
   */
  protected function buildGetRequest()
  {
    $query = $this->getQueryString();

    $uri = $this->request->getApiUri();

    if ($query)
    {
      $uri .= '?' . $query;
    }

    $this->setUri($uri);
  }

  /**
   * Prepares a POST request
   *
   */
  protected function buildPostRequest()
  {
    $this->setUri($this->request->getUri());
    $this->setOption(CURLOPT_POST, true);
    $this->setOption(CURLOPT_POSTFIELDS, $this->request->getParameters());
  }

  /**
   * Prepares a DELETE request
   *
   */
  protected function buildDeleteRequest()
  {
    $this->setUri($this->request->getUri());
    $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
    $this->setOption(CURLOPT_POSTFIELDS, $this->request->getParameters());
  }

  /**
   * Sends the http request
   *
   * @param sfTwitterRequest $request The request
   *
   * @return string The response
   */
  public function handle(sfTwitterRequest $request)
  {
    $this->request = $request;

    try
    {
      $this->prepare();

      return $this->exec();
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }

  /**
   * Prepare the CURL request
   *
   * @access protected
   */
  protected function prepare()
  {
    $this->buildRequest();
    $this->disableOutput();
    
    //$this->setHttpAuthStrategy();
    //$this->setUserAndPassword();
    //$this->disableSslControl();
  }

  /**
   * Returns a response information
   *
   * @param string $name The info to get
   *
   * @return string
   */
  public function getResponseInfo($name)
  {
    return curl_getinfo($this->connection, $name);
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
      $this->connection = curl_init();
    }

    foreach ($this->options as $key => $value)
    {
      curl_setopt($this->connection, $key, $value);
    }

    $response = curl_exec($this->connection);

    $this->setStatusCode($this->getResponseInfo(CURLINFO_HTTP_CODE));

    curl_close($this->connection);

    return $response;
  }
}