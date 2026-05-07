<span class="rounded px-2 py-1 text-xs break-keep inline-flex items-center"
      style="background-color: <?= $tag["Tag"]["colour"]?>; color: <?= $this->TextColour->getTextColour($tag['Tag']['colour']); ?>">
      <i class="fa fa-<?= $tag['local'] ? 'user' : 'globe-americas'?> mr-1"></i> 
      <?= $tag["Tag"]["name"] ?>
  </span>
