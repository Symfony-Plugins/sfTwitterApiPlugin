<?php

class sfTwitterRequestTrends extends sfTwitterRequest
{
  /**
   * Configures the trends request
   *
   */
  public function configure()
  {
    $this->setResponseFormat('json');
    $this->setApiUri('http://search.twitter.com/trends/current');
  }
}