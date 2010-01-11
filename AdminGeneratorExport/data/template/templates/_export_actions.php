<?php if ($actions = $this->configuration->getValue('export.actions')): ?>
<?php foreach ($actions as $name => $params): ?>
<li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
  <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, false), $params)."\n" ?>
</li>
<?php endforeach; ?>
<?php endif; ?>
