<?php
$maxValue = function ($items) {
    if (empty($items)) {
        return 1;
    }

    $max = max($items);
    return $max > 0 ? $max : 1;
};

$barWidth = function ($value, $max) {
    if ($max <= 0) {
        return 0;
    }

    return round(($value / $max) * 100);
};

$statusClass = function ($status) {
    if ($status === 'ok') {
        return 'bg-green-500/20 text-green-400 border-green-500/30';
    }

    if ($status === 'warning') {
        return 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30';
    }

    if ($status === 'critical') {
        return 'bg-red-500/20 text-red-400 border-red-500/30';
    }

    return '';
};

$statusTextColor = function ($status) {
    if ($status === 'ok') {
        return 'text-green-400';
    }

    if ($status === 'warning') {
        return 'text-yellow-400';
    }

    if ($status === 'critical') {
        return 'text-red-400';
    }

    return '';
};

$statusText = function ($status) {
    if ($status === 'ok') {
        return __('Systems running normally');
    }

    if ($status === 'warning') {
        return __('Systems require attention');
    }

    if ($status === 'critical') {
        return __('Systems in critical state');
    }

    return '';
};

$statusIcon = function ($status) {
    if ($status === 'ok') {
        return 'fa-check-circle';
    }

    if ($status === 'warning') {
        return 'fa-exclamation-triangle';
    }

    if ($status === 'critical') {
        return 'fa-times-circle';
    }

    return '';
};

$attributeValue = function ($attribute) {
    $value1 = isset($attribute['attributes']['value1'])
        ? $attribute['attributes']['value1']
        : (isset($attribute['Attribute']['value1']) ? $attribute['Attribute']['value1'] : '');

    $value2 = isset($attribute['attributes']['value2'])
        ? $attribute['attributes']['value2']
        : (isset($attribute['Attribute']['value2']) ? $attribute['Attribute']['value2'] : '');

    return trim($value1 . '|' . $value2, '|');
};

$topTagMax = 1;
foreach ($topTags as $row) {
    $topTagMax = max($topTagMax, (int)$row[0]['counter']);
}

$topGalaxyMax = 1;
foreach ($topGalaxies as $row) {
    $topGalaxyMax = max($topGalaxyMax, (int)$row[0]['counter']);
}

$topTaxonomyMax = count($topTaxonomies) ? max($topTaxonomies) : 1;

$healthTotal = 0;

$healthGrouped = array(
    'ok' => array(),
    'warning' => array(),
    'critical' => array()
);

foreach ($health as $name => $status) {
    $healthTotal++;

    if (!isset($healthGrouped[$status])) {
        $healthGrouped[$status] = array();
    }

    $healthGrouped[$status][$name] = $status;
}
?>

<div class="min-h-screen text-gray-200">
    <div class="p-6 space-y-6">

        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-medium text-white print:text-black">
                    <?= __('MISP Monitoring Dashboard') ?>
                </h1>
                <p class="text-sm text-gray-400 tracking-wide print:text-black">
                    <?= __('Events, Attributes, Objects, Organisations, Galaxies, Tags, Feeds and Sync Activity') ?>
                </p>
            </div>

            <div class="flex items-center gap-4">
                
                <a href="<?= $scope === 'mine' ? $baseurl . '/darkmisp/index' : $baseurl . '/darkmisp/index/searchorg:' . $myOrgId ?>"
                    class="inline-flex items-center cursor-pointer group">
                    <span class="select-none mr-3 text-xs uppercase tracking-wider text-gray-400 group-hover:text-white print:text-black">
                        <?= $scope === 'mine' ? __('My org') : __('All') ?>
                    </span>
                    <span class="relative inline-flex items-center">
                        <input
                            type="checkbox"
                            class="sr-only peer"
                            <?= $scope === 'mine' ? 'checked="checked"' : '' ?>>

                        <span class="
                            relative w-10 h-5 rounded-full transition-all
                            bg-mispnight border border-mispdarkblue
                            peer-checked:bg-mispblue
                            peer-focus:ring-2 peer-focus:ring-mispblue/40
                            after:content-['']
                            after:absolute
                            after:top-[2px]
                            after:left-[2px]
                            after:h-4
                            after:w-4
                            after:rounded-full
                            after:bg-white
                            after:transition-all
                            peer-checked:after:translate-x-5
                        "></span>
                    </span>
                </a>

                <div class="flex items-center gap-2 px-3 py-2 rounded-lg border border-mispdarkblue bg-mispaccentnight">
                    <i class="fas fa-bolt text-mispblue"></i>
                    <span class="text-xs uppercase tracking-wider text-gray-400 print:text-black">
                        <?= __('Live Overview') ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="relative overflow-hidden rounded-lg border border-mispdarkblue bg-mispaccentnight p-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-mispblue/10 rounded-full -mr-12 -mt-12"></div>
                <div class="absolute bottom-4 right-4">
                    <i class="fas fa-calendar-alt text-6xl text-mispblue/70"></i>
                </div>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-calendar-alt text-mispblue"></i>
                        <span class="text-xs text-gray-400 uppercase tracking-wider print:text-black"><?= __('Events') ?></span>
                    </div>

                    <div class="text-3xl font-bold text-mispblue print:text-mispdarkblue">
                        <?= h($eventCount) ?>
                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">
                        <?= __('Total created events') ?>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-800">
                    <div class="h-full bg-mispblue w-full"></div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-lg border border-mispdarkblue bg-mispaccentnight p-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-400/10 rounded-full -mr-12 -mt-12"></div>
                <div class="absolute bottom-4 right-4">
                    <i class="fas fa-list text-6xl text-blue-400/70"></i>
                </div>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-list text-blue-400"></i>
                        <span class="text-xs text-gray-400 uppercase tracking-wider print:text-black"><?= __('Attributes') ?></span>
                    </div>

                    <div class="text-3xl font-bold text-blue-400 print:text-mispdarkblue">
                        <?= h($attributeCount) ?>
                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">
                        <?= __('Non deleted attributes') ?>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-800">
                    <div class="h-full bg-blue-400 w-full"></div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-lg border border-mispdarkblue bg-mispaccentnight p-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-400/10 rounded-full -mr-12 -mt-12"></div>
                <div class="absolute bottom-4 right-4">
                    <i class="fas fa-cubes text-6xl text-green-400/70"></i>
                </div>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-cubes text-green-400"></i>
                        <span class="text-xs text-gray-400 uppercase tracking-wider print:text-black"><?= __('Objects') ?></span>
                    </div>

                    <div class="text-3xl font-bold text-green-400 print:text-mispdarkblue">
                        <?= h($objectCount) ?>
                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">
                        <?= __('Non deleted MISP objects') ?>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-800">
                    <div class="h-full bg-green-400 w-full"></div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-lg border border-mispdarkblue bg-mispaccentnight p-4">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-400/10 rounded-full -mr-12 -mt-12"></div>
                <div class="absolute bottom-4 right-4">
                    <i class="fas fa-building text-6xl text-purple-400/70"></i>
                </div>

                <div class="relative">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-building text-purple-400"></i>
                        <span class="text-xs text-gray-400 uppercase tracking-wider print:text-black"><?= __('Organisations') ?></span>
                    </div>

                    <div class="text-3xl font-bold text-purple-400 print:text-mispdarkblue">
                        <?= h($organisationCount) ?>
                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">
                        <?= __('Total organisations') ?>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-800">
                    <div class="h-full bg-purple-400 w-full"></div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-tags text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 10 Tags') ?></h2>
                </div>

                <div class="p-4 space-y-3">
                    <?php foreach ($topTags as $row): ?>
                        <div>
                            <div class="flex justify-between gap-3 text-xs mb-1">
                                <span class="truncate font-mono text-mispblue">
                                    <?= h($row['tags']['name']) ?>
                                </span>
                                <span class="text-gray-400">
                                    <?= h($row[0]['counter']) ?>
                                </span>
                            </div>

                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-mispblue rounded-full" style="width: <?= h($barWidth($row[0]['counter'], $topTagMax)) ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-sitemap text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 10 Taxonomies') ?></h2>
                </div>

                <div class="p-4 space-y-3">
                    <?php foreach ($topTaxonomies as $name => $count): ?>
                        <div>
                            <div class="flex justify-between gap-3 text-xs mb-1">
                                <span class="truncate font-mono text-mispblue">
                                    <?= h($name) ?>
                                </span>
                                <span class="text-gray-400">
                                    <?= h($count) ?>
                                </span>
                            </div>

                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-mispblue rounded-full" style="width: <?= h($barWidth($count, $topTaxonomyMax)) ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-meteor text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 10 Galaxies') ?></h2>
                </div>

                <div class="p-4 space-y-3">
                    <?php foreach ($topGalaxies as $row): ?>
                        <div>
                            <div class="flex justify-between gap-3 text-xs mb-1">
                                <span class="truncate text-mispblue">
                                    <?= h($row['galaxy_clusters']['value']) ?>
                                </span>
                                <span class="text-gray-400">
                                    <?= h($row[0]['counter']) ?>
                                </span>
                            </div>

                            <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-mispblue rounded-full" style="width: <?= h($barWidth($row[0]['counter'], $topGalaxyMax)) ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-building text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 5 Contributing Organisations') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($topOrganisations as $organisation): ?>
                        <div class="p-3">
                            <div class="flex justify-between gap-3">
                                <span class="text-sm text-mispblue truncate">
                                    <?= h($organisation['organisations']['name']) ?>
                                </span>
                                <span class="text-sm text-gray-400">
                                    <?= h($organisation[0]['counter']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-project-diagram text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 5 Correlations') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($topCorrelations as $correlation): ?>
                        <a href="<?= $baseurl ?>/events/view/<?= h($correlation['attributes']['event_id']) ?>" class="block p-3 hover:bg-mispnight transition-colors">
                            <div class="flex justify-between gap-3">
                                <span class="text-sm text-mispblue truncate font-mono">
                                    <?= h($correlation['attributes']['value']) ?>
                                </span>
                                <span class="text-sm text-gray-400">
                                    <?= h($correlation[0]['counter']) ?>
                                </span>
                            </div>
                            <div class="text-xs text-gray-400">
                                <?= h($correlation['attributes']['type']) ?> · Event <?= h($correlation['attributes']['event_id']) ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-link text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Top 5 Events with most Relations') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($topEventsWithRelations as $event): ?>
                        <a href="<?= $baseurl ?>/events/view/<?= h($event['events']['id']) ?>" class="block p-3 hover:bg-mispnight transition-colors">
                            <div class="flex justify-between gap-3">
                                <span class="text-sm text-mispblue truncate">
                                    <?= h($event['events']['info']) ?>
                                </span>
                                <span class="text-sm text-gray-400">
                                    <?= h($event[0]['counter']) ?>
                                </span>
                            </div>
                            <div class="text-xs text-gray-400">
                                #<?= h($event['events']['id']) ?> · <?= h($event['events']['date']) ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <?php
            $charts = array(
                __('Events last 10 days') => array(
                    'items' => $eventsByDay,
                    'icon' => 'fa-calendar-alt',
                    'color' => 'bg-mispblue'
                ),
                __('Objects last 10 days') => array(
                    'items' => $objectsByDay,
                    'icon' => 'fa-cubes',
                    'color' => 'bg-blue-400'
                ),
                __('Attributes last 10 days') => array(
                    'items' => $attributesByDay,
                    'icon' => 'fa-list',
                    'color' => 'bg-green-400'
                )
            );
            ?>

            <?php foreach ($charts as $title => $chart): ?>
                <?php $max = $maxValue($chart['items']); ?>

                <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                    <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                        <i class="fas <?= h($chart['icon']) ?> text-mispblue"></i>
                        <h2 class="text-lg font-medium print:text-black"><?= h($title) ?></h2>
                    </div>

                    <div class="p-4">
                        <div class="flex items-end gap-2 h-44">
                            <?php foreach ($chart['items'] as $date => $count): ?>
                                <div class="flex-1 flex flex-col items-center justify-end gap-2">
                                    <div class="text-xs text-gray-400">
                                        <?= h($count) ?>
                                    </div>

                                    <div class="w-full bg-gray-800 rounded-t overflow-hidden flex items-end h-32">
                                        <div
                                            class="w-full <?= h($chart['color']) ?> rounded-t transition-all"
                                            style="height: <?= h(max(4, $barWidth($count, $max))) ?>%">
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        <?= h(date('d.m', strtotime($date))) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Latest Events') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($latestEvents as $event): ?>
                        <a href="<?= $baseurl ?>/events/view/<?= h($event['Event']['id']) ?>" class="block p-3 hover:bg-mispnight transition-colors">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-sm text-mispblue truncate">
                                        <?= h($event['Event']['info']) ?>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        #<?= h($event['Event']['id']) ?> · <?= h($event['Event']['date']) ?>
                                    </div>
                                </div>

                                <span class="text-xs uppercase tracking-wide rounded-full border px-2 py-0.5 <?= $event['Event']['published'] ? 'border-green-500/30 text-green-400 bg-green-500/20' : 'border-yellow-500/30 text-yellow-400 bg-yellow-500/20' ?>">
                                    <?= $event['Event']['published'] ? __('published') : __('draft') ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-cubes text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Latest Objects') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($latestObjects as $object): ?>
                        <a href="<?= $baseurl ?>/events/view/<?= h($object['objects']['event_id']) ?>" class="block p-3 hover:bg-mispnight transition-colors">
                            <div class="text-sm text-mispblue truncate">
                                <?= h($object['objects']['name']) ?>
                            </div>

                            <div class="text-xs text-gray-400">
                                #<?= h($object['objects']['id']) ?> · Event <?= h($object['objects']['event_id']) ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-list text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Latest Attributes') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($latestAttributes as $attribute): ?>
                        <a href="<?= $baseurl ?>/events/view/<?= h($attribute['attributes']['event_id']) ?>" class="block p-3 hover:bg-mispnight transition-colors">
                            <div class="text-sm text-mispblue truncate font-mono">
                                <?= h($attributeValue($attribute)) ?>
                            </div>

                            <div class="text-xs text-gray-400">
                                <?= h($attribute['attributes']['type']) ?>
                                · <?= h($attribute['attributes']['category']) ?>
                                · Event <?= h($attribute['attributes']['event_id']) ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="grid grid-cols-1 gap-4">
                <div class="relative overflow-hidden rounded-lg border border-mispdarkblue bg-mispaccentnight divide-y divide-mispdarkblue">
                    <div class="bg-mispaccentnight overflow-hidden">
                        <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                            <i class="fas fa-heartbeat text-mispblue"></i>
                            <h2 class="text-lg font-medium print:text-black"><?= __('Health Status') ?></h2>
                        </div>
                    </div>

                    <?php foreach ($healthGrouped as $groupName => $group): ?>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas <?= h($statusIcon($groupName)) ?> <?= h($statusTextColor($groupName)) ?>"></i>

                                <span class="text-xs text-gray-400 uppercase tracking-wider print:text-black">
                                    <?= h($groupName) ?>
                                </span>

                                <span class="font-bold <?= h($statusTextColor($groupName)) ?> print:text-mispdarkblue">
                                    (<?= h(count($group)) ?>)
                                </span>

                                <div class="text-xs text-gray-400">
                                    <?= h($statusText($groupName)) ?>
                                </div>
                            </div>

                            <div class="py-4 flex items-center flex-wrap gap-2">
                                <?php foreach ($group as $name => $status): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full border text-xs uppercase tracking-wide <?= h($statusClass($status)) ?>">
                                        <i class="fas <?= h($statusIcon($status)) ?>"></i>
                                        <?= h($name) ?>: <?= h($status) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-rss text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Feed Activity') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($feedActivity as $feed): ?>
                        <div class="p-3 hover:bg-mispnight transition-colors">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-sm text-mispblue truncate">
                                        <?= h($feed['Feed']['name']) ?>
                                    </div>

                                    <div class="text-xs text-gray-400">
                                        cache: <?= h($feed['Feed']['caching_enabled']) ?>
                                        · lookup: <?= h($feed['Feed']['lookup_visible']) ?>
                                    </div>
                                </div>

                                <span class="text-xs uppercase tracking-wide rounded-full border px-2 py-0.5 <?= $feed['Feed']['enabled'] ? 'border-green-500/30 text-green-400 bg-green-500/20' : 'border-red-500/30 text-red-400 bg-red-500/20' ?>">
                                    <?= $feed['Feed']['enabled'] ? __('enabled') : __('disabled') ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-lg border border-mispdarkblue bg-mispaccentnight overflow-hidden">
                <div class="p-3 border-b border-mispdarkblue flex items-center gap-2">
                    <i class="fas fa-exchange-alt text-mispblue"></i>
                    <h2 class="text-lg font-medium print:text-black"><?= __('Sync Instances') ?></h2>
                </div>

                <div class="divide-y divide-mispdarkblue">
                    <?php foreach ($syncActivity as $server): ?>
                        <div class="p-3 hover:bg-mispnight transition-colors">
                            <div class="text-sm text-mispblue truncate">
                                <?= h($server['Server']['name']) ?>
                            </div>

                            <div class="text-xs text-gray-400 truncate">
                                <?= h($server['Server']['url']) ?>
                            </div>

                            <div class="flex gap-2 mt-2">
                                <span class="text-xs uppercase tracking-wide rounded-full border px-2 py-0.5 <?= $server['Server']['pull'] ? 'border-green-500/30 text-green-400 bg-green-500/20' : 'border-gray-500/30 text-gray-400 bg-gray-500/10' ?>">
                                    pull
                                </span>

                                <span class="text-xs uppercase tracking-wide rounded-full border px-2 py-0.5 <?= $server['Server']['push'] ? 'border-green-500/30 text-green-400 bg-green-500/20' : 'border-gray-500/30 text-gray-400 bg-gray-500/10' ?>">
                                    push
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </div>
</div>
