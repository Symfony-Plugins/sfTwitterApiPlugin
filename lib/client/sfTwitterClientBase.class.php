<?php

abstract class sfTwitterClientBase
{
  const DOMAIN = 'http://www.twitter.com';

  protected $request = null;
  protected $response = null;
  protected $username = null;
  protected $password = null;
  protected $responseFormat = 'xml';

  public function __construct($username, $password, array $options = array())
  {
    $this->username = $username;
    $this->password = $password;
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

  /**
   * Returns the sfTwitterRequest object
   *
   * @return sfTwitterRequest
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Returns the sfTwitterResponse object
   *
   * @return sfTwitterResponse
   */
  public function getResponse()
  {
    return $this->response;
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
      $this->request = new sfTwitterRequest();
      $this->request->setResponseFormat($this->getResponseFormat());
      $this->request->setUsername($this->username);
      $this->request->setPassword($this->password);
      $this->request->setUri('http://twitter.com/statuses/public_timeline.xml');
      $this->request->setMethod(sfTwitterRequestBase::METHOD_GET);
      $response = $this->request->send();

      $this->response = new sfTwitterResponseXml();
      $this->response->setContent($response);
      
      return $this->response;
    }
    catch (Exception $e)
    {
      
    }
  }
  
  protected function handle(sfTwitterRequest $request)
  {
    $response = $request->send();
    
    $format = $request->getResponseFormat();

    $className = sprintf('sfTwitterResponse%s', ucfirst($format));

    if (!class_exists($className))
    {
      throw new Exception(sprintf('Class %s does not exist'));
    }

    $output = $request->send();

    $response = new $className();

    if (!($response instanceOf sfTwitterResponse))
    {
      throw new Exception(sprintf('%s is not an instance of sfTwitterResponse class', $className));
    }

    $response->setContent($output);

    return $response;
  }
}