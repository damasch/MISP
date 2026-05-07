<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo __('Tags');?></h1>
        </div>
        <button class="flex items-center space-x-2 px-4 py-2 bg-mispblue hover:bg-mispdarkblue rounded-lg transition-colors cursor-pointer">
            <i class="fas fa-plus"></i>
            <span>Add Tag</span>
        </button>
    </div>
    <div class="pagination">
        <?= $this->element('pagination'); ?>
    </div>
    <div class="pagination">
         <?= $this->element('Tags/tag_index_table', array(
            'tags' => $list
        )); ?> 
    </div>
    <div>
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
                ?>
        </p>
        <div class="pagination">
            <?= $pagination ?>
        </div>
    </div>
    <div class="pagination">
        <?= $this->element('pagination'); ?>
    </div>
</div>
