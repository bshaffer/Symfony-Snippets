[?php echo form_tag('@<?php echo $this->params['route_prefix'] ?>_export?sf_format=xls') ?]
<table>
  <tr><th>Include in Export</th><th>Field</th><th>Label (optional)</th></tr>
<?php foreach ($this->configuration->getValue('export.display') as $name => $field): ?>
  <tr>
    <td><input name='export[<?php echo $name ?>][include]' type='checkbox' checked /></td>
    <td><?php echo $field->getConfig('label', '', true) ?></td>
    <td>
      <input name='export[<?php echo $name ?>][default]' value="<?php echo $field->getConfig('label', '', true) ?>" type='hidden' />
      <input name='export[<?php echo $name ?>][label]' type='textbox' size='20'>
    </td>
  </tr>
<?php endforeach ?>
  </table>
  <input type='submit' value='Export' />
</form>
