<?php

abstract class sfTwitterResponseBase
{
  protected $content = null;
  protected $statusCode = null;

  /**
   * String representation of the object
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getContent();
  }

  /**
   * Sets the response content
   *
   * @param string $content The response content
   */
  public function setContent($content)
  {
    $this->content = $content;
  }

  /**
   * Returns the response content
   *
   * @return
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Sets the http response status code
   *
   * @param int $code
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
}