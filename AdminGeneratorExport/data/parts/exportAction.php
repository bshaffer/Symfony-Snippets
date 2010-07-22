  public function executeExport(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
    
    if ($request->isMethod('POST')) 
    {      
      // Export
      $headers = array();
      
      foreach ($request->getParameter('export', array()) as $name => $field) 
      {
        $row = array();
        if (isset($field['include']) && $field['include']) 
        {
          $headers[] = $field['label'] ? $field['label'] : ($field['default'] ? $field['default'] : sfInflector::humanize($name));
          $fields[] = $name;
        }
      }

      $rows = array($this->helper->exportColumnHeaders($headers)); // Add space in front of header to prevent Excel from interpreting as a SYLK file
      
      $results = $this->getCollectionForExport(); // bypass offsets

      foreach ($results as $result) 
      {
        $rows[] = $this->helper->exportObjectRow($result, $fields);
      }

      // Set HTTP Headers
      $this->getContext()->getResponse()->setContentType('text/xls');
      $this->getContext()->getResponse()->setHttpHeader('Content-Disposition', 'attachment;filename='.$this->configuration->getExportFilename().'.xls;');
      return $this->renderText(implode("\n", $rows));
    }
  }
  
  protected function getCollectionForExport()
  {
    $query = $this->pager
                  ->getQuery()
                  ->limit(9999999);

    return $query->execute();
  }
