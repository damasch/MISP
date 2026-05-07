<div class="bg-mispaccentnight rounded-lg border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 bg-mispnight">
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('ID') ?>
                    </th>
                    <th class="px-3 py-4 text-left text-sm font-medium text-gray-400">
                        <?= __('Name') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Exportable') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Hidden') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Local Only') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Restricted to org') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Restricted to user') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Taxonomy') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Tagged events') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Favourite') ?>
                    </th>
                    <th class="px-3 py-4 text-center text-sm font-medium text-gray-400">
                        <?= __('Actions') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag): ?>
                    <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $tag["Tag"]["id"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top">
                            <?= $this->element('Tags/single_tag', array(
                                'tag' => $tag
                            )); ?> 
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["exportable"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["hide_tag"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["local_only"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["org_id"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["user_id"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php if ($tag["Tag"]["Taxonomy"]["id"]): ?>
                                <i class="fas fa-check"></i>
                            <?php else: ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?= $tag["Tag"]["count"] ?>
                        </td>
                        <td class="px-3 py-4 text-sm align-top text-center">
                            <?php
                            echo $this->Form->create('FavouriteTag'. $tag["Tag"]["id"], array(
                                'url' => $baseurl . '/favourite_tags/toggle',
                                'name' => 'FavouriteTag',
                                'data-form-favourite-tag' => '',
                            ));
                            echo $this->Form->input('data', array(
                                'type' => 'checkbox',
                                'label' => '',
                                'name' => 'data',
                                'data-check-favourite-tag' => '',
                                'value' => $tag["Tag"]["id"],
                                'checked' => $tag["Tag"]["favourite"],
                            ));
                            echo $this->Form->end();
                            ?>
                        </td>
                        <td>
                            <?php // var_dump($tag); ?>
                        </td>
                    </tr>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).on('change', '[data-check-favourite-tag]', function (e) {
    e.preventDefault();

    // passendes Formular finden
    var $form = $(this).closest('form[data-form-favourite-tag]');

    if (!$form.length) return;

    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method') || 'POST',
        data: $form.serialize(),
        success: function (res) {
            console.log('Favourite updated');
        },
        error: function (err) {
            console.error('Error:', err);
        }
    });
});
</script>
