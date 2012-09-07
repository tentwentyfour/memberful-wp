<?php

function memberful_wp_register_options()
{
	add_option('memberful_client_id');
	add_option('memberful_client_secret');
	add_option('memberful_site');
	add_option('memberful_api_key');
	add_option('memberful_webhook_secret');
	add_option('memberful_products', array());
	add_option('memberful_subscriptions', array());
	add_option('memberful_acl', array());
}


/**
 * Displays the memberful options page
 *
 */
function memberful_options()
{
	$options = array();

	if ( ! empty($_POST['activation_code']) ) {
		$activation = memberful_wp_activate($_POST['activation_code']);

		if ( $activation === TRUE) {
			memberful_sync_products();
		}
		else {

		}
	}

	if ( ! get_option('memberful_client_id') ) {
		memberful_wp_render('setup');
	}
	else {
		$products = get_option('memberful_products', array());
		$subs     = get_option('memberful_subscriptions', array());

		memberful_wp_render(
			'options',
			array(
				'products'      => $products,
				'subscriptions' => $subs
			)
		);
	}
}

/**
 * Attempts to get the necessary details from memberful and set them
 * using the wordpress settings API
 *
 * @param $code string The activation code
 */
function memberful_wp_activate($code)
{
	$activator = new Memberful_Activator($code, html_entity_decode(get_bloginfo('name')));

	$activator
		->requireApiKey()
		->requireOauth(memberful_wp_oauth_callback_url())
		->requireWebhook(memberful_wp_webhook_url());

	$credentials = $activator->activate();

	update_option('memberful_client_id', $credentials->oauth->identifier);
	update_option('memberful_client_secret', $credentials->oauth->secret);
	update_option('memberful_api_key', $credentials->api_key->key);
	update_option('memberful_site', $credentials->site);

	return TRUE;
}

function memberful_sync_products()
{
	$url = memberful_admin_products_url(MEMBERFUL_JSON);

	$full_url = add_query_arg('auth_token', get_option('memberful_api_key'), $url);

	$response = wp_remote_get($full_url, array('sslverify' => MEMBERFUL_SSL_VERIFY));

	if(is_wp_error($response))
	{
		var_dump($response, $full_url, $url);
		die();
	}

	if($response['response']['code'] != 200 OR ! isset($response['body']))
	{
		return new WP_Error('memberful_product_sync_fail', "Couldn't retrieve list of products from memberful");
	}

	$raw_products = json_decode($response['body']);
	$products = array();

	foreach($raw_products as $product)
	{
		$products[$product->id] = array(
			'id'       => $product->id,
			'name'     => $product->name,
			'for_sale' => $product->for_sale,
		);
	}

	update_option('memberful_products', $products);

	return TRUE;
}
