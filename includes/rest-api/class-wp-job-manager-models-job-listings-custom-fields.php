<?php
/**
 * Declaration of our Settings Model
 *
 * @package WPJM/REST
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WP_Job_Manager_Models_Job_Listings_Custom_Fields
 */
class WP_Job_Manager_Models_Job_Listings_Custom_Fields extends WPJM_REST_Model_Declaration {
	/**
	 * Declare Fields
	 *
	 * @param WPJM_REST_Field_Declaration_Collection_Builder $def Def.
	 * @return array
	 * @throws WPJM_REST_Exception Exc.
	 */
	function declare_fields( $def ) {
		global $post;

		$current_user = wp_get_current_user();

		$declarations = array(
			$def->field( '_job_location', __( 'Leave this blank if the location is not important.', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'job_location_reader' ) ),

			$def->field( '_application', __( 'Application Email or URL', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'application_reader' ) ),

			$def->field( '_company_name', __( 'Company Name', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'company_name_reader' ) ),

			$def->field( '_company_website',  __( 'Company Website', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'company_website_reader' ) ),

			$def->field( '_company_tagline',  __( 'Company Tagline', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'company_tagline_reader' ) ),

			$def->field( '_company_twitter',  __( 'Company Twitter', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'company_twitter_reader' ) ),

			$def->field( '_company_video',  __( 'Company Video', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, 'company_video_reader' ) ),

			$def->field( '_filled',  __( 'Position Filled', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'boolean' ) )
				->with_reader( array( $this, 'filled_reader' ) ),
		);

		if ( $current_user->has_cap( 'manage_job_listings' ) ) {

			$declarations[] = $def->field( '_featured',  __( 'Featured Listing', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'boolean' ) )
				->with_reader( array( $this, '_featured_reader' ) );

			$declarations[] = $def->field( '_job_expires',  __( 'Listing Expiry Date', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, '_job_expires_reader' ) );
		}

		if ( $current_user->has_cap( 'edit_others_job_listings' ) ) {
			$declarations[] = $def->field( '_job_author',  __( 'Posted by', 'wp-job-manager' ) )
				->with_kind( WPJM_REST_Field_Declaration::DERIVED )
				->with_type( $def->type( 'string' ) )
				->with_reader( array( $this, '_job_author_reader' ) );
		}

		return $declarations;
	}

	/**
	 * _application reader.
	 *
	 * @return mixed|string
	 */
	function application_reader() {
		global $post;
		$current_user = wp_get_current_user();
		return metadata_exists( 'post', $post->ID, '_application' ) ? get_post_meta( $post->ID, '_application', true ) : $current_user->user_email;
	}
}
