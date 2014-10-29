<?php

/**
 * @file
 * Views definitions/alterations for the UTLogin module.
 */

/**
 * Implements hook_views_default_views().
 *
 * This creates a custom view showing non-UTLogin users in table format with the
 * option to convert them to UTLogin users.
 *
 * The table of non-UTLogin users is populated by altering the query in
 * utlogin_views_query_alter().
 *
 * The action to convert non-UTLogin users to UTLogin users is defined in
 * utlogin_convert_local_to_utlogin_action().
 *
 * @see UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_HUMAN_NAME
 * @see UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_MACHINE_NAME
 * @see UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_PATH
 * @see utlogin_convert_local_to_utlogin_action()
 * @see utlogin_views_query_alter()
 */
function utlogin_views_default_views() {
  $views = array();

  $view = new view();
  $view->name = UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_MACHINE_NAME;
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'users';
  $view->human_name = UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_HUMAN_NAME;
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE;

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_HUMAN_NAME;
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['access']['perm'] = 'administer utlogin module';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'none';
  $handler->display->display_options['style_plugin'] = 'table';
  $handler->display->display_options['style_options']['columns'] = array(
    'views_bulk_operations' => 'views_bulk_operations',
    'name' => 'name',
  );
  $handler->display->display_options['style_options']['default'] = 'name';
  $handler->display->display_options['style_options']['info'] = array(
    'views_bulk_operations' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'name' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );

  /* Field: Bulk operations: User */
  $handler->display->display_options['fields']['views_bulk_operations']['id'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['table'] = 'users';
  $handler->display->display_options['fields']['views_bulk_operations']['field'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['display_type'] = '0';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['enable_select_all_pages'] = 1;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['force_single'] = 0;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['entity_load_capacity'] = '10';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_operations'] = array(
    'action::utlogin_convert_local_to_utlogin_action' => array(
      'selected' => 1,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 0,
      'label' => '',
    ),
  );
  /* Field: User: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'users';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['label'] = 'EID';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_PATH;
  $handler->display->display_options['menu']['type'] = 'tab';
  $handler->display->display_options['menu']['title'] = 'Convert users';
  $handler->display->display_options['menu']['description'] = 'Convert users to authenticate with UTLogin';
  $handler->display->display_options['menu']['weight'] = '0';
  $handler->display->display_options['menu']['context'] = 0;
  $handler->display->display_options['menu']['context_only_inline'] = 0;

  $views[$view->name] = $view;

  return $views;
}

/**
 * Implements hook_views_query_alter().
 *
 * Change the query for the view created in utlogin_views_default_views() such
 * that it only retrieves non-UTLogin users.
 *
 * @see UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_MACHINE_NAME
 * @see utlogin_views_default_views()
 */
function utlogin_views_query_alter(&$view, &$query) {
  if ($view->name == UTLOGIN_VIEW_ELIGIBLE_LOCAL_USERS_MACHINE_NAME) {
    // Modify the view's query to search for non-user1 users without an authmap
    // record where authmap.module == 'utlogin'; equivalent of the following SQL:
    //   SELECT [fields defined in utlogin_views_default_views()]
    //   FROM users users
    //   LEFT JOIN authmap authmap
    //     ON users.uid = authmap.uid
    //       AND authmap.module = 'utlogin'
    //   WHERE users.uid > 1
    //     AND authmap.aid IS NULL
    //   ORDER BY users.name ASC

    $join = new views_join();
    $join->table = 'authmap';
    $join->field = 'uid';
    $join->left_table = 'users';
    $join->left_field = 'uid';
    $join->type = 'LEFT';
    $join->extra = array(
      array(
        'table' => 'authmap',
        'field' => 'module',
        'operator' => '=',
        'value' => 'utlogin',
      ),
    );
    $alias = $query->ensure_table('authmap', 'users', $join);

    $condition = db_and()->condition('users.uid', 1, '>')->isNULL("{$alias}.aid");
    $query->add_where(0, $condition);

    $query->add_orderby('users', 'name');
  }
}
