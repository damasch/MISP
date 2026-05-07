<?php
    $pagination = '<ul class="flex items-center gap-1 text-sm">';
    $pagination .= $this->Paginator->prev(
        '&laquo; ' . __('previous'), 
        array(
            'tag' => 'li', 
            'escape' => false,
            'class' => 'rounded-md border border-mispblue bg-mispblue text-white hover:bg-mispdarkblue [&>a]:block [&>a]:w-full [&>a]:h-full [&>a]:px-3 [&>a]:py-2'), 
        null, 
        array(
            'tag' => 'li', 
            'class' => 'rounded-md border border-mispblue bg-mispnight text-gray-400 cursor-not-allowed [&>span]:block [&>span]:px-3 [&>span]:py-2', 
            'escape' => false, 
            'disabledTag' => 'span'));
    $pagination .= $this->Paginator->numbers(
        array(
            'modulus' => 20, 
            'separator' => '', 
            'tag' => 'li', 
            'currentClass' => 'bg-mispblue text-white border-mispdarkblue [&>span]:block [&>span]:px-3 [&>span]:py-2',
            'currentTag' => 'span',
            'class' => 'rounded-md border border-mispblue text-gray-400 hover:bg-mispblue [&>a]:block [&>a]:w-full [&>a]:h-full [&>a]:px-3 [&>a]:py-2'));
    $pagination .= $this->Paginator->next(
        __('next') . ' &raquo;', 
        array(
            'tag' => 'li', 
            'escape' => false,
            'class' => 'rounded-md border border-mispblue bg-mispblue text-white hover:bg-mispdarkblue [&>a]:block [&>a]:w-full [&>a]:h-full [&>a]:px-3 [&>a]:py-2'), 
        null, 
        array(
            'tag' => 'li', 
            'class' => 'rounded-md border border-mispblue bg-mispnight text-gray-400 cursor-not-allowed [&>span]:block [&>span]:px-3 [&>span]:py-2',
            'escape' => false, 
            'disabledTag' => 'span'));
    
    $pagination .= '</ul>';

    echo $pagination;
?>
