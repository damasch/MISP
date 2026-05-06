<?php $tagsCount = 0; ?>

<?php foreach ($event['EventTag'] as $tag): if ($tagsCount++ >= 2) break;?>
    <a href="<?= $baseurl ?>/events/index/searchtag:<?= $tag["tag_id"]?>" 
        class="rounded px-2 py-1 text-xs break-keep inline-flex items-center"
        style="background-color: <?= $tag["Tag"]["colour"]?>; color: <?= $this->TextColour->getTextColour($tag['Tag']['colour']); ?>">
        <i class="fa fa-<?= $tag['local'] ? 'user' : 'globe-americas'?> mr-1"></i> 
        <?= $tag["Tag"]["name"] ?>
    </a>
<?php endforeach; ?>

<input data-show-tags type="checkbox" id="showEventTags-<?= $eventId ?>" class="peer hidden">

<?php foreach (array_slice($event['EventTag'], 2) as $tag): ?>
    <a href="<?= $baseurl ?>/events/index/searchtag:<?= $tag["tag_id"]?>" 
    class="rounded px-2 py-1 text-xs break-keep hidden items-center peer-checked:inline-flex"
    style="background-color: <?= $tag["Tag"]["colour"]?>; color: <?= $this->TextColour->getTextColour($tag['Tag']['colour']); ?>">
    <i class="fa fa-<?= $tag['local'] ? 'user' : 'globe-americas'?> mr-2"></i> 
    <?= $tag["Tag"]["name"] ?>
</a>
<?php endforeach; ?>

<?php if (count($event['EventTag']) > 2):?>
    <label for="showEventTags-<?= $eventId ?>"
        class="px-2 py-1 bg-gray-700 text-gray-400 rounded text-xs  break-keep inline-flex items-center peer-checked:hidden">
        +<?= count($event['EventTag']) - 2 ?>
    </label>
<?php endif; ?>
