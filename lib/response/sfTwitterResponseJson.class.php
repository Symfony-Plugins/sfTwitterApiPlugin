<?php

class sfTwitterResponseJson extends sfTwitterResponseBase
{
  /**
   * Returns the JSON response as an array
   *
   * @return array
   */
  public function toArray()
  {
    return json_decode($this->getContent());
  }
}