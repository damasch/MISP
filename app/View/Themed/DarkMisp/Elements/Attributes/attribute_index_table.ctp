<div class="bg-mispaccentnight rounded-lg border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 bg-mispnight">
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('ID') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Date') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Org') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Category') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Type') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Value') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Tags') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Galaxies') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Comment') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Correlate') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Related Events') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Feed hits') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('IDS') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Distribution') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Sightings') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Activity') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Actions') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attributes as $attribute): ?>
                    <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["id"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= date('Y-m-d', $attribute["Attribute"]["timestamp"]) ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $this->OrgImg->getOrgLogo($attribute["Event"]["Orgc"], 24); ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["category"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["type"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $this->element('/genericElements/IndexTable/Fields/attributeValue', array(
                                'row' => $attribute,
                                'field' => array(
                                    'data_path' => 'Attribute'
                                )
                            )); ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            -- tags --
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            -- galaxies --
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <a class="text-mispblue"
                                href="<?= $baseurl ?>/attributes/search/value:<?= $attribute["Attribute"]["value"] ?>">
                                <i class="fas fa-search"></i>
                            </a>
                            <?php // var_dump($attribute); ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $attribute["Attribute"]["comment"] ?>
                        </td>
                    </tr>
                  <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
