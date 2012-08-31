<?php

/**
 * Maps a Memberful user to a WordPress user.
 *
 * If the WordPress user does not exist then they are created from the member
 * details provided.
 *
 */
class Memberful_User_Map
{
	public function map($user, $products, $subscriptions, $refresh_token = NULL)
	{
		$wp_user = $this->sync_user_and_token($user, $refresh_token);

		$this->sync_products($wp_user, $products);
		$this->sync_member_subscriptions($wp_user, $subscriptions);

		return $wp_user;
	}

	/**
	 * Takes a set of Memberful member details and tries to associate it with the
	 * WordPress user account.
	 *
	 * @param StdObject $details       Details about the member
	 * @param string    $refresh_token The member's refresh token for oauth
	 * @return WP_User
	 */
	public function sync_user_and_token($member, $refresh_token = NULL)
	{
		global $wpdb;

		$query = $wpdb->prepare(
			'SELECT *, (`memberful_member_id` = %d) AS `exact_match` FROM `'.$wpdb->users.'` WHERE `memberful_member_id` = %d OR `user_email` = %s ORDER BY `exact_match` DESC',
			$member->id,
			$member->id,
			$member->email
		);

		$user = $wpdb->get_row($query);

		// User does not exist
		if($user === NULL)
		{
			$data = array(
				'user_pass'     => wp_generate_password(),
				'user_login'    => $member->username,
				'user_nicename' => $member->username,
				'user_email'    => $member->email,
				'display_name'  => $member->full_name,
				'nickname'      => $member->full_name,
				'first_name'    => $member->first_name,
				'last_name'     => $member->last_name,
				'show_admin_bar_frontend' => FALSE,
			);

			$user_id = wp_insert_user($data);

			if(is_wp_error($user_id))
			{
				var_dump($user_id);
				die('ERRORR!!!');
				return $user_id;
			}
		}
		else
		{
			// Now sync the two accounts
			$user_id = $user->ID;

			// Mapping of WordPress => Memberful keys
			$mapping = array(
				'user_email'    => 'email',
				'user_login'    => 'username',
				'display_name'  => 'full_name',
				'user_nicename' => 'username',

			);

			$metamap = array(
				'nickname'      => 'full_name',
				'first_name'    => 'first_name',
				'last_name'     => 'last_name'
			);

			$meta = get_user_meta($user_id, '', true);

			// WordPress only allows us to do a complete update of values.
			// No partial updates allowed.
			$data = (array) $user;

			foreach($mapping as $wp_key => $m_key)
			{
				$data[$wp_key] = $member->$m_key;
			}

			foreach($metamap as $wp_key => $m_key)
			{
				$data[$wp_key] = $member->$m_key;
			}

			wp_insert_user($data);
		}

		$this->_update_user($user_id, $member->id, $member->username, $refresh_token);

		return get_userdata($user_id);
	}

	public function sync_products(WP_User $user, $products)
	{
		$product_ids = array_map(array($this, '_extract_id'), $products);

		$new_products = empty($product_ids)
			? array()
			: array_combine($product_ids, $product_ids);

		update_user_meta($user->ID, 'memberful_products', $new_products);
	}

	public function sync_member_subscriptions(WP_User $user, $subscriptions)
	{
		$member_subscriptions = $subscription_ids = array();

		foreach($subscriptions as $subscription)
		{
			$expires_at = strtotime($subscription->expires_at);

			$member_subscriptions[$subscription->subscription_id] = array(
				// If we couldn't parse the date then the sub never expires
				'expires_at'             => $expires_at ? $expires_at : true,
				'member_subscription_id' => $subscription->id,
			);
		}

		update_user_meta($user->ID, 'memberful_subscriptions', $member_subscriptions);
	}

	protected function _extract_id($product_link)
	{
		return (int) $product_link->id;
	}

	protected function _update_user($user_id, $member_id, $username, $refresh_token = NULL)
	{
		global $wpdb;
		$data = array();

		$update = 'UPDATE `'.$wpdb->users.'` SET ';

		if($refresh_token !== NULL)
		{
			$update .= '`memberful_refresh_token` = %s, ';
			$data[] = $refresh_token;
		}

		$update .= '`user_login` = %s, `memberful_member_id` = %d WHERE `ID` = %d';
		$data[] = $username;
		$data[] = $member_id;
		$data[] = $user_id;

		$wpdb->query($wpdb->prepare($update, $data));
	}
}