<div class="space-y-1">
<?php
foreach ($possibleColumns as $possibleColumn) {
    ?>
    <div class="group">
      <a class="" id="" href="#" onclick="event.preventDefault();eventIndexColumnsToggle('<?= $possibleColumn ;?>')">
        <span class="border-1 border-mispblue w-6 h-6 inline-block text-center rounded-sm">
          <i class="fa fa-check <?= in_array($possibleColumn, $columns, true) ? '' : 'invisible group-hover:visible ' ?>"></i>
        </span>
        <?= $columnsDescription[$possibleColumn]; ?>
        
      </a>
    </div>
    <?php
}
?>
</div>
