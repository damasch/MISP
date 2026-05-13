<?php
$date = time();
$day = 86400;
?>

<div class="bg-mispaccentnight rounded-lg border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 bg-mispnight">
                    <?= $this->element('Generics/table/th', array(
                        'class' => 'w-8 text-left',
                        'content' => $this->Form->checkbox('select_all', array(
                            'class' => 'select_all select',
                            'title' => __('Select all'),
                            'role' => 'button',
                            'tabindex' => '0',
                            'aria-label' => __('Select all events on current page'),
                            'onclick' => 'toggleAllCheckboxes();',
                            'hiddenField' => false,
                        )),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => 'w-8 text-left',
                        'content' => $this->Paginator->sort('id', __('ID'), ['direction' => 'desc']),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => 'min-w-8 text-left',
                        'content' => $this->Paginator->sort('info'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => 'min-w-8 text-left',
                        'content' => $this->Paginator->sort('date', null, array('direction' => 'desc')),
                    )) ?>
                    <?php if (in_array('timestamp', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'title' => __('Last modified at'),
                            'content' => $this->Paginator->sort('timestamp', __('Last modified at')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (Configure::read('MISP.showorgalternate') && Configure::read('MISP.showorg')): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'content' => $this->Paginator->sort('Orgc.name', __('Source Org'))
                        )) ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'content' => $this->Paginator->sort('Orgc.name', __('Member Org')),
                        )) ?>
                    <?php elseif (Configure::read('MISP.showorg') || $isAdmin): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'content' => $this->Paginator->sort('Orgc.name', __('Creator Org')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('owner_org', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'content' => $this->Paginator->sort('Orgc.name', __('Owner Org')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('creator_user', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'content' => $this->Paginator->sort('Orgc.name', __('Creator user')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('clusters', $columns, true)): ?>
                        <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                            <?= __('Clusters') ?>
                            <button id="toggleClusters">
                                <i class="fas fa-caret-square-down text-mispblue"></i>
                            </button>
                        </th>
                    <?php endif; ?>
                    <?php if (in_array('tags', $columns, true)): ?>
                        <th class="px-3 py-4 text-left text-sm font-medium text-gray-400 w-150">
                            <?= __('Tags') ?>
                            <button id="toggleTags" 
                                class="px-2 py-1 bg-gray-700 text-gray-400 rounded text-xs break-keep inline-flex items-center">
                                +
                            </button>
                        </th>
                    <?php endif; ?>
                    <?php if (in_array('attribute_count', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'title' => __('Attribute Count'),
                            'content' => $this->Paginator->sort('attribute_count', __('#Attr.')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('correlations', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'title' => __('Correlation Count'),
                            'content' => $this->Paginator->sort('correlations', __('#Corr.')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('report_count', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'title' => __('Report Count'),
                            'content' => $this->Paginator->sort('report_count', __('#Reports.')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('sightings', $columns, true)): ?>
                        <?= $this->element('Generics/table/th', array(
                            'class' => 'min-w-8 text-left',
                            'title' => __('Sighting Count'),
                            'content' => $this->Paginator->sort('report_count', __('#Sightings.')),
                        )) ?>
                    <?php endif; ?>
                    <?php if (in_array('proposals', $columns, true)): ?>
                        <th class="px-3 py-4 text-left text-sm font-medium text-gray-400" 
                            title="<?= __('Proposal Count') ?>"><?= __('#Prop') ?></th>
                    <?php endif; ?>
                    <?php if (in_array('discussion', $columns, true)): ?>
                        <th class="px-3 py-4 text-left text-sm font-medium text-gray-400" 
                            title="<?= __('Post Count') ?>"><?= __('#Posts') ?></th>
                    <?php endif; ?>
                    <?php if (in_array('publish_timestamp', $columns, true)): ?>
                        <th class="px-3 py-4 text-left text-sm font-medium text-gray-400 w-30" 
                            title="<?= __('Published at') ?>"><?= $this->Paginator->sort('publish_timestamp', __('Published at')) ?></th>
                    <?php endif; ?>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400" 
                        title="<?= $eventDescriptions['distribution']['desc'];?>">
                        <?= $this->Paginator->sort('distribution');?></th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400" 
                        title="<?= __('Published') ?>">
                        <?= $this->Paginator->sort('published', __('Status') , ['escape' => false]) ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400"><?php echo __('Actions');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): $eventId = (int)$event['Event']['id']; ?>
                <?php $eventLinkId = Configure::read('MISP.use_uuids_in_urls') ? h($event['Event']['uuid']) : h($eventId); ?>
                <tr id="event_<?= $eventId ?>" class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                    <td class="px-3 py-4 text-sm align-top">
                        <input class="select" type="checkbox" data-id="<?= $eventId ?>" data-can-modify="<?= $this->Acl->canModifyEvent($event) ? 1 : 0 ?>">
                    </td>
                    <td class="py-4 text-center text-sm align-top">
                        <span>
                            <a href="<?= $baseurl."/events/view/".$eventLinkId ?>" 
                                class="px-3 py-4 text-sm dblclickActionElement threat-level-<?= strtolower(h($event['ThreatLevel']['name'])) ?>" 
                                title="<?= h($event['Event']['info']) ?>">
                                #<?= $eventId ?>
                            </a> 
                            <?= !empty($event['Event']['protected']) ? sprintf('<i class="fas fa-lock" title="%s"></i>', __('Protected event')) : ''?>
                        </span>
                    </td>

                    <td class="px-3 py-4 text-sm align-top dblclickElement" style="min-width: 20vi; white-space: normal;">
                        <?= nl2br(h($event['Event']['info']), false) ?>

                        <?php if ($extends_info): ?>
                            <?php if (in_array('is_extension', $columns, true)): ?>
                                <div class="pl-3">
                                    <span class="apply_css_arrow">
                                        <p style="display: inline;">
                                            Extends 
                                            <a href="<?= h($baseurl) ?>/events/view/<?= h($extends_id) ?>" 
                                            title="<?= __('See extended event') ?>" 
                                            aria-label="<?= __('See extended event') ?>">
                                                <?= h($extends_id)?>
                                            </a>
                                            : <?= h($extends_info) ?>
                                        </p>
                                    </span>
                                </div>
                            <?php else: ?>
                                <a href="<?= h($baseurl) ?>/events/view/<?= h($extends_id) ?>" 
                                title="<?= __('Extends event %s', h($extends_id)) ?>"
                                aria-label="<?= __('Extends event %s', h($extends_id)) ?>">
                                    <i class="fas fa-external-link-square-alt"></i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class="px-3 py-4 text-sm align-top dblclickElement">
                        <time><?= $event['Event']['date'] ?></time>
                    </td>
                    <?php if (in_array('timestamp', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement">
                        <?= $this->Time->time($event['Event']['timestamp']) ?>
                    </td>
                    <?php endif; ?>
                    
                    <?php if (Configure::read('MISP.showorg') || $isAdmin): ?>
                    <td class="px-3 py-4 text-center text-sm align-top" >
                        <a href="<?= $baseurl . "/events/index/searchorg:" . $event['Orgc']['id'] ?>" 
                            class="block text-center org-logo" 
                            title="<?= __('View organisation %s', h($event['Orgc']['name'])) ?>" 
                            aria-label="<?= __('View organisation %s', h($event['Orgc']['name'])) ?>">
                            <img 
                                src="<?= $baseurl ?>/organisations/getOrgLogo/<?= h($event['Orgc']['id']) ?>.json"
                                title="<?= h($event['Orgc']['name']) ?>"
                                alt="<?= h($event['Orgc']['name']) ?>"
                                class="inline-block w-6 h-6"
                                onError="this.onerror=null; this.replaceWith(document.createTextNode(this.alt));"
                            >
                        </a>
                    </td>
                    <?php endif;?>
                    <?php if (in_array('owner_org', $columns, true) || (Configure::read('MISP.showorgalternate') && Configure::read('MISP.showorg'))): ?>
                    <td class="px-3 py-4 text-center text-sm align-top" ondblclick="document.location.href ='<?php echo $baseurl . "/events/index/searchorg:" . $event['Org']['id'];?>'">
                        <a href="<?= $baseurl . '/events/index/searchorg:' . h($event['Org']['id']) ?>" 
                            class="block text-center org-logo"
                            title="<?= __('View organisation %s', h($event['Org']['name'])) ?>" 
                            aria-label="<?= __('View organisation %s', h($event['Org']['name'])) ?>">
                            <img 
                                src="<?= $baseurl ?>/organisations/getOrgLogo/<?= h($event['Org']['id']) ?>.json"
                                title="<?= h($event['Org']['name']) ?>"
                                alt="<?= h($event['Org']['name']) ?>"
                                class="inline-block w-6 h-6"
                                onError="this.onerror=null; this.replaceWith(document.createTextNode(this.alt));"
                            >
                        </a>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('creator_user', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement">
                        <a href="<?= $baseurl . '/events/index/searchemail:' . h($event['User']['email']) ?>" >
                        <?php echo h($event['User']['email']); ?>
                        </a>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('clusters', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top">
                        <?php
                            $galaxies = array();
                            if (!empty($event['GalaxyCluster'])) {
                                foreach ($event['GalaxyCluster'] as $galaxy_cluster) {
                                    $galaxy_id = $galaxy_cluster['Galaxy']['id'];
                                    if (!isset($galaxies[$galaxy_id])) {
                                        $galaxies[$galaxy_id] = $galaxy_cluster['Galaxy'];
                                    }
                                    unset($galaxy_cluster['Galaxy']);
                                    $galaxies[$galaxy_id]['GalaxyCluster'][] = $galaxy_cluster;
                                }
                                echo $this->element('galaxyQuickViewNew', array(
                                'data' => $galaxies,
                                'event' => $event,
                                'target_id' => $eventId,
                                'target_type' => 'event',
                                'static_tags_only' => true,
                                ));
                            }
                        ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('tags', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top space-y-2">
                        <?= $this->element('Events/event_tag_list', array(
                            'event' => $event,
                            'eventId' => $eventId,
                        )); ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('attribute_count', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top">
                        <?= $event['Event']['attribute_count']; ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('correlations', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top">
                        <?php if (!empty($event['Event']['correlation_count'])): ?>
                            <a href="<?= "$baseurl/events/view/$eventLinkId/correlation:1" ?>" title="<?= __n('%s correlation', '%s correlations', $event['Event']['correlation_count'], $event['Event']['correlation_count']), '. ' . __('Show filtered event with correlation only.');?>">
                                <?= intval($event['Event']['correlation_count']); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('report_count', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top">
                        <?= $event['Event']['report_count']; ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('sightings', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top">
                        <?php if (!empty($event['Event']['sightings_count'])): ?>
                            <a href="<?= "$baseurl/events/view/$eventLinkId/sighting:1" ?>" title="<?= __n("1 sighting. Show filtered event with sighting only.", "%s sightings. Show filtered event with sightings only.", $event['Event']['sightings_count'], intval($event['Event']['sightings_count'])) ?>">
                                <?= intval($event['Event']['sightings_count']) ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <?php if (in_array('proposals', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement" title="<?= __n('%s proposal', '%s proposals', $event['Event']['proposals_count'], $event['Event']['proposals_count']) ?>">
                        <?= !empty($event['Event']['proposals_count']) ? intval($event['Event']['proposals_count']) : ''; ?>
                    </td>
                    <?php endif;?>
                    <?php if (in_array('discussion', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement">
                        <?php
                            if (!empty($event['Event']['post_count'])) {
                                $post_count = h($event['Event']['post_count']);
                                if (($date - $event['Event']['last_post']) < $day) {
                                    $post_count .=  ' (<span class="red bold">' . __('NEW') . '</span>)';
                                }
                            } else {
                                $post_count = '';
                            }
                        ?>
                        <span style=" white-space: nowrap;"><?php echo $post_count?></span>
                    </td>
                    <?php endif;?>
                    <?php if (in_array('publish_timestamp', $columns, true)): ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement">
                        <?= $this->Time->time($event['Event']['publish_timestamp']) ?>
                    </td>
                    <?php endif; ?>
                    <?php
                        $extends_uuid = $event['Event']['extends_uuid'] ?? null;
                        $extendedEventsInfoByUuid = array_column($extendedEvents, 'info', 'uuid');
                        $extendedEventsIdByUuid = array_column($extendedEvents, 'id', 'uuid');
                        $extends_info = $extendedEventsInfoByUuid[$extends_uuid] ?? null;
                        $extends_id = $extendedEventsIdByUuid[$extends_uuid] ?? null;
                    ?>
                    <td class="px-3 py-4 text-sm align-top dblclickElement<?php if ($event['Event']['distribution'] == 0) echo ' privateRedText';?>" title="<?= $event['Event']['distribution'] != 3 ? $distributionLevels[$event['Event']['distribution']] : __('All');?>">
                        <?php if ($event['Event']['distribution'] == 4):?>
                            <a class="break-keep" href="<?php echo $baseurl;?>/sharingGroups/view/<?= intval($event['SharingGroup']['id']); ?>"><?= h($event['SharingGroup']['name']) ?></a>
                        <?php else:
                            echo h($shortDist[$event['Event']['distribution']]);
                        endif;
                        ?>
                        <?php
                        echo sprintf(
                            '<it type="button" title="%s" class="%s" aria-hidden="true" style="font-size: x-small;" data-event-distribution="%s" data-event-distribution-name="%s" data-scope-id="%s"></it>',
                            __('Toggle advanced sharing network viewer'),
                            'fa fa-share-alt useCursorPointer distributionNetworkToggle',
                            intval($event['Event']['distribution']),
                            $event['Event']['distribution'] == 4 ? h($event['SharingGroup']['name']) : h($shortDist[$event['Event']['distribution']]),
                            $eventId
                        )
                        ?>
                    </td>
                    <td class="dblclickElement px-3 py-4 text-sm align-top">
                        <a href="<?= "$baseurl/events/view/$eventLinkId" ?>" title="<?= __('View') ?>" aria-label="<?= __('View') ?>">
                            <span
                                class="px-2 py-1 rounded text-xs font-medium <?= $event['Event']['published'] ? 'bg-green-900/30 text-green-400' : 'bg-gray-700 text-gray-400' ?>">
                                <?= $event['Event']['published'] ? __('Published') : __('Draft') ?>
                            </span>
                        </a>
                    </td>
                    <td class="short action-links">
                        <?php
                            if (0 == $event['Event']['published'] && $this->Acl->canPublishEvent($event)) {
                                echo sprintf('<a class="useCursorPointer fa fa-upload" title="%s" aria-label="%s" onclick="event.preventDefault();publishPopup(%s)"></a>', __('Publish Event'), __('Publish Event'), $eventLinkId);
                            }

                            if ($this->Acl->canModifyEvent($event)):
                        ?>
                                <a href="<?php echo $baseurl."/events/edit/".$eventLinkId ?>" title="<?php echo __('Edit');?>" aria-label="<?php echo __('Edit');?>"><i class="black fa fa-edit"></i></a>
                        <?php
                                echo sprintf('<a class="useCursorPointer fa fa-trash" title="%s" aria-label="%s" onclick="event.preventDefault();deleteEventPopup(%s)"></a>', __('Delete'), __('Delete'), $eventLinkId);
                            endif;
                        ?>
                        <a href="<?php echo $baseurl."/events/view/".$eventLinkId ?>" title="<?php echo __('View');?>" aria-label="<?php echo __('View');?>"><i class="fa black fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var lastSelected = false;
    $(function() {
        $('.select').on('change', function() {
            listCheckboxesCheckedEventIndex();
        }).click(function(e) {
            if ($(this).is(':checked')) {
                if (e.shiftKey) {
                    selectAllInBetween(lastSelected, this);
                }
                lastSelected = this;
            }
        });

        $('.distributionNetworkToggle').each(function() {
            $(this).distributionNetwork({
                distributionData: <?= json_encode($distributionData, JSON_UNESCAPED_UNICODE); ?>,
            });
        });
        
        $('#toggleClusters').on('click', function () {

            const $checkboxes = $('input[type="checkbox"][data-show-clusters]');
            const allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;

            // Wenn alle checked → alle uncheck, sonst alle check
            $checkboxes.prop('checked', !allChecked);

            const $icon = $(this).find('i');

            if (allChecked) {
                $icon.removeClass('fa-caret-square-up').addClass('fa-caret-square-down');
            } else {
                $icon.removeClass('fa-caret-square-down').addClass('fa-caret-square-up');
            }
        });

        $('#toggleTags').on('click', function () {

            const $checkboxes = $('input[type="checkbox"][data-show-tags]');
            const allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;

            // Wenn alle checked → alle uncheck, sonst alle check
            $checkboxes.prop('checked', !allChecked);
        });
    });
</script>
