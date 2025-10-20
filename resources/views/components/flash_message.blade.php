<?php if (isset($_SESSION['flash_msg'])): ?>
<div class="fixed top-4 right-4 z-50 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg">
  <?php  echo htmlspecialchars($_SESSION['flash_msg']); ?>
</div>
<?php  unset($_SESSION['flash_msg']); ?>
<?php endif; ?>