<?php

class sfTwitterRequestTrendsCurrent extends sfTwitterRequestTrend
{
  /**
   * Configures the request
   *
   */
  public function configure()
  {
    parent::configure();

    $this->setUri('http://search.twitter.com/trends/current.json');
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