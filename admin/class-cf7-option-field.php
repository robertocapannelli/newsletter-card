<?php
/**
 * Created by PhpStorm.
 * User: robertocapannelli
 * Date: 10/10/18
 * Time: 21:26
 */

class CF7_Option_Field {

	private $option_name;
	private $type;
	private $section;
	private $field_id;
	private $field_title;
	private $is_required;
	private $hint;

	/**
	 * CF7_Option_Field constructor.
	 *
	 * @param $option_name
	 * @param $type
	 * @param $section
	 * @param $field_id
	 * @param $field_title
	 * @param $is_required
	 * @param $hint
	 */
	public function __construct( $array ) {
		$this->option_name = $array['option_name'];
		$this->type        = $array['type'];
		$this->section     = $array['section'];
		$this->field_id    = $array['field_id'];
		$this->field_title = $array['field_title'];
		$this->is_required = $array['is_required'];
		$this->hint        = $array['hint'];
	}

	/**
	 * @return mixed
	 */
	public function get_option_name() {
		return $this->option_name;
	}

	/**
	 * @return mixed
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function get_section() {
		return $this->section;
	}

	/**
	 * @return mixed
	 */
	public function get_field_id() {
		return $this->field_id;
	}

	/**
	 * @return mixed
	 */
	public function get_field_title() {
		return $this->field_title;
	}

	/**
	 * @return mixed
	 */
	public function is_required() {
		return $this->is_required;
	}

	/**
	 * @return mixed
	 */
	public function get_hint() {
		return $this->hint;
	}


}