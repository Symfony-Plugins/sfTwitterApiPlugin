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

    $this->setUri('http://search.twitter.com/trends/current.json');
  }
}