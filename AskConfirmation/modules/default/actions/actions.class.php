<?php

/**
 * default actions.
 *
 * @package    cfit
 * @subpackage sfGuardUser
 */
class defaultActions extends sfActions
{
  public function executeConfirmation(sfWebRequest $request)
  {
    $this->url = $request->getUri();
    $this->title = $request->getAttribute('title');
    $this->message = $request->getAttribute('message');
  }
}
