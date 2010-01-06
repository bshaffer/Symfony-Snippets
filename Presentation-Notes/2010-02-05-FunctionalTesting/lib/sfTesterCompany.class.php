<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfTesterForm implements tests for forms submitted by the user.
 *
 * @package    symfony
 * @subpackage test
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfTesterForm.class.php 24217 2009-11-22 06:47:54Z fabien $
 */
class sfTesterCompany extends sfTester
{
  public function prepare()
  {
    
  }
  
  public function initialize()
  {
    
  }
  
  public function isCompany(Company $company)
  {
    $id = $this->browser->getRequest()->getParameter('company_id');
    $this->tester->is($company['id'], $id, "Current Company is $company");
  }
}
