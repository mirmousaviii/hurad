<div class="row-actions">
    <?php
    $viewLink = $this->Html->link(
        __d('hurad', 'View'),
        $this->Content->getPermalink(),
        array('title' => __d('hurad', 'View “%s”', $this->Content->getTitle()), 'rel' => 'permalink')
    );
    HuradRowActions::addAction('view', $viewLink, 'read');

    $editLink = $this->Html->link(
        __d('hurad', 'Edit'),
        array('admin' => true, 'controller' => 'pages', 'action' => 'edit', $this->Content->getId()),
        array('title' => __d('hurad', 'Edit this item'))
    );
    HuradRowActions::addAction('edit', $editLink, 'edit_published_pages');

    $deleteLink = $this->Form->postLink(
        __d('hurad', 'Delete'),
        array('admin' => true, 'action' => 'delete', $this->Content->getId()),
        array('title' => __d('hurad', 'Delete this item')),
        __d('hurad', 'Are you sure you want to delete "%s"?', $this->Content->getTitle())
    );
    HuradRowActions::addAction('delete', $deleteLink, 'delete_pages');

    $actions = HuradHook::apply_filters('page_row_actions', HuradRowActions::getActions(), $page);
    echo $this->AdminLayout->rowActions($actions);
    ?>
</div>