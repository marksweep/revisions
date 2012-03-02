<?php
/**
 * Routes
 *
 * Revisions_routes.php will be loaded in main app/config/routes.php file.
 */
    Croogo::hookRoutes('Revisions');
/**
 * Behavior
 *
 * This plugin's Revisions behavior will be attached whenever Node model is loaded.
 */
    Croogo::hookBehavior('Node', 'Revisions.Revisions', array());
/**
 * Component
 *
 * This plugin's Revisions component will be loaded in ALL controllers.
 */
    Croogo::hookComponent('*', 'Revisions.Revisions');
/**
 * Helper
 *
 * This plugin's Revisions helper will be loaded via NodesController.
 */
    Croogo::hookHelper('Nodes', 'Revisions.Revisions');
/**
 * Admin menu (navigation)
 *
 * This plugin's admin_menu element will be rendered in admin panel under Extensions menu.
 */
    //Croogo::hookAdminMenu('Revisions');
/**
 * Admin row action
 *
 * When browsing the content list in admin panel (Content > List),
 * an extra link called 'Revisions' will be placed under 'Actions' column.
 */
    //Croogo::hookAdminRowAction('Nodes/admin_index', 'Revisions', 'controller:nodes/action:edit/:id#node-revisions');
/**
 * Admin tab
 *
 * When adding/editing Content (Nodes),
 * an extra tab with title 'Revisions' will be shown with markup generated from the plugin's admin_tab_node element.
 *
 * Useful for adding form extra form fields if necessary.
 */
    Croogo::hookAdminTab('Nodes/admin_add', 'Revisions', 'Revisions.admin_tab_node');
    Croogo::hookAdminTab('Nodes/admin_edit', 'Revisions', 'Revisions.admin_tab_node');
?>