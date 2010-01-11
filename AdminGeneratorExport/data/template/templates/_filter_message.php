[?php if ($helper->activeFilters()): ?]
  <span class="filter-message">
    These results have been filtered. Click
    [?php echo link_to(__('Here', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]
    to show all the records.
  </span>
[?php endif; ?]