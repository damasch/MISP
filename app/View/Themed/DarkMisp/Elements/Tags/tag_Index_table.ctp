<div class="bg-mispaccentnight rounded-lg border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 bg-mispnight">
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('ID'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'content' => __('Name'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Exportable'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Hidden'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Local Only'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Restricted to org'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Restricted to user'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Taxonomy'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Tagged events'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Favourite'),
                    )) ?>
                    <?= $this->element('Generics/table/th', array(
                        'class' => "text-center",
                        'content' => __('Actions'),
                    )) ?>
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
                        <?php $tag_id = $tag["Tag"]["id"]; ?>
                            <?= $this->Form->create('FavouriteTag', [
                                'url' => ['controller' => 'favourite_tags', 'action' => 'toggle'],
                                'class' => 'js-favourite-tag-form inline-block',
                            ]); ?>

                            <?= $this->Form->hidden('FavouriteTag.data', [
                                'value' => $tag_id
                            ]); ?>

                            <button type="submit"
                                class="toggleFavoriteSettings"
                                data-tag-id="<?= h($tag_id) ?>">
                                <span class="border-1 border-mispblue w-6 h-6 inline-block text-center rounded-sm">
                                    <i class="fa fa-check <?= $tag["Tag"]["favourite"] ? '' : 'invisible hover:visible' ?>"></i>
                                </span>
                            </button>

                            <?= $this->Form->end(); ?>
                            
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

$(document).on('submit', '.js-favourite-tag-form', function (event) {
    event.preventDefault();

    const $form = $(this);
    const $button = $form.find('.toggleFavoriteSettings');
    const $icon = $button.find('i');

    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        beforeSend: function () {
            $button.addClass('opacity-50 pointer-events-none');
        },
        success: function () {
            $icon.toggleClass('invisible hover:visible');

            // Wichtig: Token wurde verbraucht.
            // Sicherste Variante:
            location.reload();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
        complete: function () {
            $button.removeClass('opacity-50 pointer-events-none');
        }
    });
});

</script>
