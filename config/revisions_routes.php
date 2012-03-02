<?php
    CroogoRouter::connect('/page/:slug/:revision', array('controller' => 'revisions', 'plugin'=>'revisions', 'action' => 'view', 'type' => 'page'));
?>