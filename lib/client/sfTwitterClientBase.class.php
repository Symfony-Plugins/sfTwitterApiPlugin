<?php

abstract class sfTwitterClientBase
{
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
}