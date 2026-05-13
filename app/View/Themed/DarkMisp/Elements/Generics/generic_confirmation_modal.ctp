<?php
$modalId = isset($modalId) ? $modalId : 'attributeConfirmationModal';
?>

<div
    id="<?= h($modalId) ?>"
    data-modal="attribute-confirmation"
    class="fixed left-0 top-0 right-0 bottom-0 inset-0 bg-black/80 items-center justify-center z-100 backdrop-blur-xs hidden">

    <div class="bg-mispnight rounded-lg shadow-lg w-md relative drop-shadow-xl/50 drop-shadow-cyan-500/50 border-1 border-mispblue">

        <div class="flex items-center justify-between border-b pl-6 pr-3 py-3 bg-mispblue rounded-t-lg">
            <h2 class="text-xl font-semibold">
                <span data-modal-title></span>
                <span data-modal-mode></span>
            </h2>

            <button
                type="button"
                data-close-modal
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-white hover:text-gray-800 cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6">
            <fieldset class="space-y-4">
                <p data-modal-message></p>

                <hr>

                <div class="flex items-center justify-between">
                    <button
                        type="button"
                        data-confirm-modal
                        class="bg-mispblue text-white px-4 py-2 rounded cursor-pointer">
                        <?= __('Yes') ?>
                    </button>

                    <button
                        type="button"
                        data-close-modal
                        class="border-1 border-mispblue bg-mispnight text-white px-4 py-2 rounded cursor-pointer">
                        <?= __('Cancel') ?>
                    </button>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script>
 $(function () {
    $(document).on('click', '[data-open-modal]', function (e) {
        e.preventDefault();

        const $trigger = $(this);
        const modalName = $trigger.data('open-modal');
        const $modal = $('[data-modal="' + modalName + '"]');

        $modal.data('form-id', $trigger.data('form-id'));

        $modal.find('[data-modal-title]').text($trigger.data('modal-title'));
        $modal.find('[data-modal-mode]').text($trigger.data('modal-mode'));
        $modal.find('[data-modal-message]').text($trigger.data('modal-message'));

        $modal.removeClass('hidden').addClass('flex');
    });

    $(document).on('click', '[data-close-modal]', function (e) {
        e.preventDefault();

        $(this)
            .closest('[data-modal]')
            .addClass('hidden')
            .removeClass('flex');
    });

    $(document).on('click', '[data-confirm-modal]', function (e) {
        e.preventDefault();

        const $modal = $(this).closest('[data-modal]');
        const formId = $modal.data('form-id');
        const $form = $('#' + formId);

        if (!$form.length) {
            console.error('Form not found:', formId);
            return;
        }

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),

            success: function (data) {
                handleGenericAjaxResponse(data, 1);
                location.reload();
            },

            error: function (xhr) {
                console.error('AJAX Error:', xhr.status, xhr.responseText);
            }
        });

        $modal.addClass('hidden').removeClass('flex');
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('[data-modal]')
                .addClass('hidden')
                .removeClass('flex');
        }
    });

    $(document).on('click', '[data-modal]', function (e) {
        if (e.target === this) {
            $(this).addClass('hidden').removeClass('flex');
        }
    });
});
</script>
