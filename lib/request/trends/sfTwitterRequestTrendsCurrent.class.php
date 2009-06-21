<?php

class sfTwitterRequestTrendsCurrent extends sfTwitterRequestTrends
{
  /**
   * Configures the request
   *
   */
  public function configure()
  {
    parent::configure();

    $this->addSupportedParameter('exclude');

    $this->setApiUri('http://search.twitter.com/trends/current');
    $this->setResponseFormat('json');
  }

  /**
   * Forces the request to exclude hashtags
   *
   */
  public function excludeHashtags()
  {
    $this->setParameter('exclude', 'hashtags');
  }
}