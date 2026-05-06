<?php
$sortClusters = function (array $clusters) {
    usort($clusters, function (array $a, array $b) {
        $aExternalId = $a['meta']['external_id'][0] ?? null;
        $bExternalId = $b['meta']['external_id'][0] ?? null;
        if ($aExternalId && $bExternalId) {
            return strcmp($aExternalId, $bExternalId);
        }
        return strcmp($a['value'], $b['value']);
    });
    return $clusters;
};


?>
<?php if (!empty($data)): ?>
<div class="galaxyQuickView">
<?php $data = array_values(array_combine(array_column($data, 'id'), $data)); ?>
<?php foreach ($data as $galaxy): ?>
    <div class="">
        <input data-show-clusters type="checkbox" id="showClusters-<?= $galaxy['id'] ?>" class="peer hidden" checked>
        <label for="showClusters-<?= $galaxy['id'] ?>" class="peer-checked:hidden cursor-pointer ">
            <i class="fas fa-caret-square-down text-mispblue"></i>
        </label>
        <label for="showClusters-<?= $galaxy['id'] ?>" class="hidden peer-checked:inline cursor-pointer ">
            <i class="fas fa-caret-square-up text-mispblue"></i>
        </label>
        <label for="showClusters-<?= $galaxy['id'] ?>" class="text-sm font-normal inline cursor-pointer " title="<?= isset($galaxy['description']) ? h($galaxy['description']) : h($galaxy['name']) ?>">
            <?= h($galaxy['name']) ?>
            <span class="rounded-sm bg-mispblue px-1.5 text-sm text-mispnight">
                <?= count($galaxy['GalaxyCluster']) ?>
            </span>
            <!-- <?php if (!$preview): ?>
            <a href="<?= $baseurl ?>/galaxies/view/<?= h($galaxy['id']) ?>" 
                title="<?= __('View details about this galaxy') ?>" 
                aria-label="<?= __('View galaxy') ?>">
                <i class="fa fa-search text-mispblue" ></i>
            </a>
            <?php endif ;?> -->
        </label>
        <ul class="ml-4 hidden peer-checked:block">
        <?php 
            foreach ($sortClusters($galaxy['GalaxyCluster']) as $cluster): ?>
                <li>
                <?php if (!$preview): ?>
                    <a href="<?= $baseurl ?>/events/index/searchtag:<?= h($cluster['tag_id']) ?>" 
                        title="<?= __('View details about this cluster') ?>" 
                        aria-label="<?= __('View Cluster') ?>">

                        <?php if (!empty($cluster['relationship_type'])) : ?>
                            <span class="inline-flex items-center gap-2 rounded-sm bg-purple-500 px-2 text-sm text-mispnight">
                            <?= $cluster['relationship_type'] ?> :
                            </span>
                        <?php endif; ?>

                        <i class="fa fa-<?=$cluster['local'] ? 'user' : 'globe-americas'?> text-yellow-400"></i> 
                        <?= $cluster["value"] ?> 
                        <!-- <i class="fa fa-search text-mispblue"></i> -->
                    </a>
                    
                <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<script>
$('#toggleClusters').on('click', function () {
    $('input[type="checkbox"][data-show-clusters]').each(function () {
        $(this).prop('checked', !$(this).prop('checked'));
    });
});
</script>
