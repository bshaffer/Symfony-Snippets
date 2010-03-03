<?php

/**
 * Project filter form base class.
 *
 * @package    filters
 *
 * @version    SVN: $Id: sfDoctrineFormFilterBaseTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
abstract class BaseFormFilterDoctrine extends sfFormFilterDoctrine
{
  public function addOccursInRangeColumnQuery(Doctrine_Query $query, $field, $value)
  {
    if ($query instanceof DQ) 
    {
      $query->andClause();
    }

    foreach ($this->getOption('occurs_in_range.filter_fields') as $i => $f) 
    {
      $this->orClause()
              ->addDateQuery($query, $f, $value)
           ->endClause();
    }
    
    if ($query instanceof DQ) 
    {
      $query->endClause();
    }
    
    return $query;
  }
}