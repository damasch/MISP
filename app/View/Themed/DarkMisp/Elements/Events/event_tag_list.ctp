<?php $tagsCount = 0; ?>

<?php foreach ($event['EventTag'] as $tag): if ($tagsCount++ >= 2) break;?>
    <a href="<?= $baseurl ?>/events/index/searchtag:<?= $tag["tag_id"]?>" 
        class="">
        <?= $this->element('Tags/single_tag', array(
            'tag' => $tag
        )); ?> 
    </a>
<?php endforeach; ?>

<input data-show-tags type="checkbox" id="showEventTags-<?= $eventId ?>" class="peer hidden">

<?php foreach (array_slice($event['EventTag'], 2) as $tag): ?>
    <a href="<?= $baseurl ?>/events/index/searchtag:<?= $tag["tag_id"]?>"
        class="hidden peer-checked:inline"
        >
        <?= $this->element('Tags/single_tag', array(
            'tag' => $tag
        )); ?> 
    </a>
<?php endforeach; ?>

<?php if (count($event['EventTag']) > 2):?>
    <label for="showEventTags-<?= $eventId ?>"
        class="px-2 py-1 bg-gray-700 text-gray-400 rounded text-xs  break-keep inline-flex items-center">
        +<?= count($event['EventTag']) - 2 ?>
    </label>
<?php endif; ?>
