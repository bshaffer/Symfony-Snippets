<?php

/**
* 
*/
class confirmationActions extends sfActions
{
  public function askConfirmation($title, $message, $redirect = false, $variables = array())
  {
    $request = $this->getRequest();

    if ($request->hasParameter('ask_confirmation') && $request->getParameter('ask_confirmation'))
    {
      if ($request->getParameter('yes'))
      {
        return true;
      } else {
        if ($redirect === true) 
        {
          $this->redirect($request->getParameter('redirect_url'));
        }
        elseif($redirect)
        {
          $this->redirect($redirect);          
        }
        return false;
      }
    } else {
      $this->getResponse()->setTitle($title);
      $request->setAttribute('title', $title);
      $request->setAttribute('message', $message);

      $this->forward('default', 'confirmation');
    }
  }
}
