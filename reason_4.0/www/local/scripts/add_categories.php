<?php
	include_once('reason_header.php');
	reason_include_once('function_libraries/relationship_finder.php');
	reason_include_once('function_libraries/admin_actions.php');
	reason_include_once('function_libraries/user_functions.php');

	if (!reason_user_has_privs( id_of( reason_check_authentication() ), 'db_maintenance' ) )
	{
	    die('<html><head><title>Reason: Add Categories</title></head><body><h1>Sorry.</h1><p>You do not have permission to add categories.</p><p>Only Reason users who have database maintenance privileges may do that.</p></body></html>');
	} else {
		// this code causes each site to borrow all categories from the Luther 2010 Home site
		$es = new entity_selector();
		$es->add_type(id_of('site'));
		$es->add_relation('entity.id != ' . id_of('events'));
		$sites = $es->run_one();

		$cat_es = new entity_selector(id_of('events'));
		$cat_es->add_type(id_of('category_type'));
		$cat_result = $cat_es->run_one();
		$cats = array_keys($cat_result);

		$borrows_rel_id = get_borrow_relationship_id(id_of('category_type'));

		foreach ($sites as $site_id => $site)
		{
			$es2 = new entity_selector($site_id);
			$es2->add_type(id_of('category_type'));
			$result2 = $es2->run_one();
			$site_categories = array_keys($result2);
			
			$my_cats = array_diff($cats, $site_categories);
			
			foreach ($my_cats as $new_cat_id)
			{
				create_relationship($site_id, $new_cat_id, $borrows_rel_id);
			}
		}
	}
?>