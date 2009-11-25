<?php

abstract class sfTwitterClientBase
{
	const VERSION = '0.1';

  protected $username       = null;
  protected $password       = null;
  protected $httpAdapter    = null;
  protected $responseFormat = 'xml';

  /**
   * Constructor
   * 
   * @param sfTwitterHttpAdapter $httpAdapter A HTTP adapter to handle HTTP requests on the API
   */
  public function __construct(sfTwitterHttpAdapter $httpAdapter)
  {
    $this->httpAdapter = $httpAdapter;
  }

  /**
   * Returns the current client's version
   * 
   * @return string
   */
  public function getVersion()
  {
  	return self::VERSION;
  }

  /**
   * Sets the API username
   * 
   * @param string $username
   */
  public function setUsername($username)
  {
  	$this->username = $username;
  }

  /**
   * Sets the API password
   * 
   * @param string $password
   */
  public function setPassword($password)
  {
  	$this->password = $password;
  }

  /**
   * Sets the http adapter
   * 
   * @param sfTwitterHttpAdapter $httpAdapter
   */
  public function setHttpAdapter(sfTwitterHttpAdapter $httpAdapter)
  {
  	$this->httpAdapter = $httpAdapter;
  }

  /**
   * Returns the http adapter
   * 
   * @return sfTwitterHttpAdapter
   */
  public function getHttpAdapter()
  {
  	return $this->httpAdapter;
  }

  /**
   * Sets the response format
   *
   * @param string $format
   */
  public function setResponseFormat($format)
  {
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

  public function getTrends()
  {
    
  }

  public function getCurrentTrends()
  {
    try
    {
      $request  = new sfTwitterRequestTrendsCurrent();

      return $this->handle($request);
    }
    catch (Exception $e)
    {
      throw $e;
    }
  }

  public function getStatusesPublicTimeline()
  {
    try
    {
      $request = new sfTwitterRequest();
      $request->setResponseFormat($this->getResponseFormat());
      $request->setUsername($this->username);
      $request->setPassword($this->password);
      $request->setApiUri('http://twitter.com/statuses/public_timeline.xml');
      $request->setMethod(sfTwitterRequestBase::METHOD_GET);

      return $this->handle($request);
    }
    catch (Exception $e)
    {
      
    }
  }

  /**
   * Handles the twitter request
   * 
   * @param sfTwitterRequest $request A sfTwitterRequest object
   * 
   * @return sfTwitterResponse $response
   */
  public function handle(sfTwitterRequest $request)
  {
    $className = $this->getResponseClassName($request);
    
    if (!class_exists($className))
    {
      throw new Exception(sprintf('Class %s does not exist', $className));
    }

    $output = $this->httpAdapter->handle($request);

    $response = new $className();
    $response->setContent($output);

    return $response;
  }

  /**
   * Returns the response format based on the request
   * 
   * @param sfTwitterRequest $request
   * 
   * @return string $className
   */
  protected function getResponseClassName(sfTwitterRequest $request)
  {
  	$format = $request->getResponseFormat();

    $className = sprintf('sfTwitterResponse%s', ucfirst($format));

    return $className;
  }
}