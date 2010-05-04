<?php use_helper('Confirmation') ?>
<div id="ask_confirmation">
  <h2><?php echo $title ?></h2>

  <p><?php echo htmlspecialchars_decode($message) ?></p>

  <form action="<?php echo $url ?>" method="POST">
    <input type="hidden" name="sf_method" value="<?php echo $sf_request->getMethod() ?>" />
    <input type="hidden" name="ask_confirmation" value="1" />
    <input type="hidden" name="redirect_url" value="<?php echo $sf_request->getReferer() ?>" />
    <?php foreach ($sf_request->getParameterHolder()->getAll() as $key => $value): ?>
      <?php echo parameter_to_input_tag($key, $value) ?>
    <?php endforeach; ?>

    <input type="submit" name="yes" class="yes" value="<?php echo 'Yes' ?>" />
    <?php if ($sf_request->getReferer()): ?>
      <input type="submit" name="no" class="no" value="<?php echo 'No' ?>" />
    <?php endif; ?>
  </form>
</div>

<?php slot('extra_links', '') ?>