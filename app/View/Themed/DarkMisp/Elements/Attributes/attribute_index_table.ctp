<div class="bg-mispaccentnight rounded-lg border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 bg-mispnight">
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('ID')
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Date'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Org'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Category'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Type'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Value'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Tags'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Galaxies'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Comment'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Correlate'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Related Events'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Feed hits'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('IDS'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Distribution'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Sightings'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Activity'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Actions'),
                    )) ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attributes as $attribute): ?>
                    <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["id"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => date('Y-m-d', $attribute["Attribute"]["timestamp"]),
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $this->OrgImg->getOrgLogo($attribute["Event"]["Orgc"], 24),
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["category"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["type"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $this->element('/genericElements/IndexTable/Fields/attributeValue', array(
                                'row' => $attribute,
                                'field' => array(
                                    'data_path' => 'Attribute'
                                )
                            )),
                         )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => 'tags',
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => 'galaxies',
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["comment"],
                        )) ?>
                        <?php ob_start(); ?>

                        <?= $this->Form->create('Attribute', array(
                            'id' => 'ToggleAttributeCorrelation' . $attribute['Attribute']['id'], 
                            'url' => $baseurl . '/attributes/toggleCorrelation/' . $attribute['Attribute']['id'])); ?>
                        <?= $this->Form->end();?>
                        <span
                            id="attribute-correlation-toggle<?= h($attribute['Attribute']['id']) ?>"
                            data-open-modal="attribute-confirmation"
                            data-form-id="ToggleAttributeCorrelation<?= h($attribute['Attribute']['id']) ?>"
                            data-modal-title="<?= h(__('Toggle Correlation')) ?>"
                            data-modal-mode="<?= $attribute['Attribute']['disable_correlation'] ? h(__('on')) : h(__('off')) ?>"
                            data-modal-message="<?= h(
                                $attribute['Attribute']['disable_correlation']
                                    ? __('Re-enable correlation for this attribute.')
                                    : __('This will remove all correlations that already exist for this attribute and prevents any attributes to be related as long as this setting is disabled.')
                            ) ?>"
                            role="button"
                            tabindex="0"
                            class="border-1 border-mispblue w-6 h-6 inline-block text-center rounded-sm group cursor-pointer">
                            <i class="fa fa-check <?= $attribute['Attribute']['disable_correlation'] ? 'invisible group-hover:visible' : '' ?>"></i>
                        </span>
                        <?php $content = ob_get_clean(); ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $content,
                        )) ?>
                        
                        <td class="px-3 py-4 text-sm align-top">
                            <a class="text-mispblue"
                                href="<?= $baseurl ?>/attributes/search/value:<?= $attribute["Attribute"]["value"] ?>">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?php // var_dump($attribute); ?>
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">

                            <?= $this->Form->create('Attribute', array(
                                'id' => 'ToggleAttributeids' . $attribute['Attribute']['id'], 
                                'url' => $baseurl . '/attributes/editField/' . $attribute['Attribute']['id'])); ?>
                            <?= $this->Form->hidden('Attribute.to_ids', array(
                                'value' => $attribute['Attribute']['to_ids'] ? 0 : 1,
                                )); ?>
                            <?= $this->Form->end();?>
                            
                            <span
                                id="attribute-ids-toggle<?= h($attribute['Attribute']['id']) ?>"
                                data-open-modal="attribute-confirmation"
                                data-form-id="ToggleAttributeids<?= h($attribute['Attribute']['id']) ?>"
                                data-modal-title="<?= h(__('Toggle IDS flag')) ?>"
                                data-modal-mode="<?= $attribute['Attribute']['to_ids'] ? h(__('off')) : h(__('on')) ?>"
                                data-modal-message="<?= h(
                                    $attribute['Attribute']['to_ids']
                                        ? __('Unset the IDS flag for this attribute.')
                                        : __('Set the IDS flag for this attribute.')
                                ) ?>"
                                role="button"
                                tabindex="0"
                                class="border-1 border-mispblue w-6 h-6 inline-block text-center rounded-sm group cursor-pointer">
                                <i class="fa fa-check <?= $attribute['Attribute']['to_ids'] ? '' : 'invisible group-hover:visible' ?>"></i>
                            </span>
                        </td>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["comment"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["comment"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["comment"],
                        )) ?>
                        <?= $this->element('Generics/table/td', array(
                            'content' => $attribute["Attribute"]["comment"],
                        )) ?>
                    </tr>
                  <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('Generics/generic_confirmation_modal'); ?>
